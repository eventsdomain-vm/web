<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\EventDate;
use App\Models\EventVenue;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportNewEvents extends Command
{
    protected $signature = 'import:new-events';

    protected $description = 'Import 49 new events scraped via Supabase API';

    private $categoryMap = [];

    private $defaultOrganizer;

    private $organizerCache = [];

    public function handle()
    {
        $this->info('Importing new events from Supabase...');

        $jsonPath = database_path('new_scraped_events.json');
        if (! file_exists($jsonPath)) {
            $this->error("File not found: $jsonPath");

            return 1;
        }

        $events = json_decode(file_get_contents($jsonPath), true);
        $this->info('Loaded '.count($events).' events from JSON');

        $this->buildCategoryMap();
        $this->defaultOrganizer = User::where('email', 'admin@eventsdomain.com')->first() ?? User::first();

        if (! $this->defaultOrganizer) {
            $this->error('No user found to assign as organizer. Create a user first.');

            return 1;
        }

        $existingSlugs = DB::table('events')->pluck('slug')->toArray();
        $imported = 0;
        $skipped = 0;

        foreach ($events as $data) {
            if (in_array($data['slug'], $existingSlugs)) {
                $this->warn("Already exists: {$data['slug']}");
                $skipped++;

                continue;
            }

            $this->info("Importing: {$data['title']}");
            $this->importEvent($data);
            $imported++;
        }

        $this->info("Done. Imported: $imported, Skipped: $skipped");

        return 0;
    }

    private function buildCategoryMap()
    {
        $categories = DB::table('categories')->get();
        foreach ($categories as $cat) {
            $this->categoryMap[strtolower($cat->name)] = $cat->id;
        }
    }

    private function mapCategory($name)
    {
        if (empty($name)) {
            return 1;
        }
        $key = strtolower(trim($name));

        return $this->categoryMap[$key] ?? 1;
    }

    private function findOrCreateOrganizer($supabaseId)
    {
        return $this->defaultOrganizer->id;
    }

    private function importEvent(array $data)
    {
        DB::beginTransaction();
        try {
            $cleanDesc = strip_tags($data['description'] ?? '');
            $cleanDesc = str_replace(["\r\n", "\r"], "\n", $cleanDesc);
            $cleanDesc = nl2br(e($cleanDesc));

            $status = ($data['status'] ?? '') === 'active' ? 'upcoming' : 'completed';

            $startDate = $data['start_date'] ?? null;
            $startTime = $data['start_time'] ?? null;
            $endDate = $data['end_date'] ?? $startDate;
            $endTime = $data['end_time'] ?? null;

            $organizerId = $this->findOrCreateOrganizer($data['organizer_id'] ?? null);

            $event = Event::create([
                'organizer_id' => $organizerId,
                'category_id' => $this->mapCategory($data['category'] ?? ''),
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => $cleanDesc,
                'event_type' => 'physical',
                'visibility' => 'public',
                'status' => $status,
                'approval_status' => 'approved',
                'is_published' => true,
                'is_featured' => false,
                'timezone' => 'Asia/Kolkata',
                'currency' => 'INR',
                'budget_min' => $data['budget_min'] ?? null,
                'budget_max' => $data['budget_max'] ?? null,
                'sponsorship_type' => $this->mapSponsorshipType($data['sponsorship_type'] ?? ''),
                'expected_audience' => $data['expected_audience'] ?? null,
                'views_count' => $data['views'] ?? 0,
                'start_date' => $startDate ? $startDate.($startTime ? " $startTime" : '') : null,
                'end_date' => $endDate ? $endDate.($endTime ? " $endTime" : '') : null,
                'venue' => $data['venue'] ?? null,
                'city' => $data['city'] ?? null,
                'state' => $data['state'] ?? null,
                'country' => 'India',
                'published_at' => now(),
            ]);

            if ($startDate) {
                EventDate::create([
                    'event_id' => $event->id,
                    'label' => 'Main Event',
                    'start_date' => $startDate,
                    'end_date' => $endDate ?: $startDate,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'all_day' => empty($startTime),
                    'sort_order' => 0,
                ]);
            }

            if (! empty($data['city'])) {
                EventVenue::create([
                    'event_id' => $event->id,
                    'venue_type' => 'physical',
                    'venue_name' => $data['venue'] ?? null,
                    'city' => $data['city'],
                    'state' => $data['state'] ?? null,
                    'country' => 'India',
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }

            $images = $data['image_urls'] ?? [];
            $images = array_filter($images, fn ($u) => ! empty($u) && $u !== 'undefined');

            foreach (array_values($images) as $idx => $imgUrl) {
                $local = $this->downloadImage($imgUrl, "events/{$event->id}/gallery");
                if ($local) {
                    if ($idx === 0) {
                        $event->update(['cover_image' => $local]);
                    }
                    DB::table('event_gallery')->insert([
                        'event_id' => $event->id,
                        'image_url' => $local,
                        'caption' => $data['title'],
                        'sort_order' => $idx,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            $this->info("  Imported: {$data['title']}");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("  Failed: {$data['title']} - {$e->getMessage()}");
        }
    }

    private function downloadImage($url, $subdir)
    {
        if (empty($url) || ! str_starts_with($url, 'http')) {
            return null;
        }

        try {
            $response = Http::timeout(30)->get($url);
            if (! $response->successful()) {
                return null;
            }

            $path = parse_url($url, PHP_URL_PATH);
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'jfif', 'svg'])) {
                $ext = 'jpg';
            }

            $filename = Str::random(32).'.'.$ext;
            $storagePath = "{$subdir}/{$filename}";
            Storage::disk('public')->put($storagePath, $response->body());

            return $storagePath;
        } catch (\Exception $e) {
            $this->warn('  Download failed: '.$e->getMessage());

            return null;
        }
    }

    private function mapSponsorshipType($type)
    {
        return match (strtolower($type ?? '')) {
            'paid sponsorship', 'paid', 'cash' => 'paid',
            'barter/in-kind', 'barter' => 'barter',
            'paid + barter', 'hybrid' => 'hybrid',
            default => 'paid',
        };
    }
}
