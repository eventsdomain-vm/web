<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FetchAllEventImages extends Command
{
    protected $signature = 'fix:fetch-all-images';

    protected $description = 'Fetch all images from Supabase event_images table';

    private $key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InVrenV3cmJoam9sYnd4cXNxbG5wIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjgzNzQ5MDUsImV4cCI6MjA4Mzk1MDkwNX0.LnnaHKJQDzNzKHW9hHSf0P-b31KOA09y3X0-SB8QGew';

    public function handle()
    {
        $this->info('Step 1: Fetching all Supabase events (UUID -> slug mapping)...');

        $slugMap = []; // supabase_uuid => slug
        $offset = 0;
        while (true) {
            $url = "https://ukzuwrbhjolbwxqsqlnp.supabase.co/rest/v1/events?select=id,slug&offset={$offset}&limit=1000";
            $resp = Http::withHeaders(['apikey' => $this->key])->get($url);
            if (! $resp->successful()) {
                break;
            }
            $data = $resp->json();
            if (empty($data)) {
                break;
            }
            foreach ($data as $ev) {
                $slugMap[$ev['id']] = $ev['slug'];
            }
            $offset += count($data);
            if (count($data) < 1000) {
                break;
            }
        }
        $this->info('  Found '.count($slugMap).' events');

        $this->info('Step 2: Fetching all event_images...');
        $images = [];
        $offset = 0;
        while (true) {
            $url = "https://ukzuwrbhjolbwxqsqlnp.supabase.co/rest/v1/event_images?select=event_id,image_url,display_order&order=display_order.asc&offset={$offset}&limit=1000";
            $resp = Http::withHeaders(['apikey' => $this->key])->get($url);
            if (! $resp->successful()) {
                $this->warn('  Query failed: '.$resp->body());
                break;
            }
            $data = $resp->json();
            if (empty($data)) {
                break;
            }
            $images = array_merge($images, $data);
            $offset += count($data);
            if (count($data) < 1000) {
                break;
            }
        }
        $this->info('  Found '.count($images).' event_images');

        if (empty($images)) {
            $this->warn('No event_images found in Supabase');

            return 0;
        }

        $this->info('Step 3: Downloading and storing images...');
        $downloaded = 0;
        $skipped = 0;
        $failed = 0;

        // Build local event lookup by slug
        $localEvents = DB::table('events')->pluck('id', 'slug')->toArray();

        foreach ($images as $img) {
            $uuid = $img['event_id'];
            $slug = $slugMap[$uuid] ?? null;
            if (! $slug) {
                $skipped++;

                continue;
            }

            $localId = $localEvents[$slug] ?? null;
            if (! $localId) {
                $skipped++;

                continue;
            }

            $imageUrl = $img['image_url'];
            if (empty($imageUrl)) {
                continue;
            }

            // Check if already in gallery
            $existing = DB::table('event_gallery')
                ->where('event_id', $localId)
                ->where('image_url', $imageUrl)
                ->exists();

            if ($existing) {
                continue;
            }

            // Download
            $local = $this->downloadImage($imageUrl, "events/{$localId}/gallery");
            if ($local) {
                DB::table('event_gallery')->insert([
                    'event_id' => $localId,
                    'image_url' => $local,
                    'caption' => DB::table('events')->where('id', $localId)->value('title') ?? '',
                    'sort_order' => $img['display_order'] ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Set as cover if first image or primary
                $hasCover = DB::table('events')->where('id', $localId)->value('cover_image');
                if (! $hasCover) {
                    DB::table('events')->where('id', $localId)->update(['cover_image' => $local]);
                }

                $downloaded++;
                if ($downloaded % 10 === 0) {
                    $this->info("  Progress: $downloaded downloaded");
                }
            } else {
                $failed++;
            }
        }

        $this->info("Done. Downloaded: $downloaded, Skipped: $skipped, Failed: $failed");

        // Final count
        $missing = DB::table('events')->whereNull('cover_image')->count();
        $totalGallery = DB::table('event_gallery')->count();
        $this->info("Remaining without cover: $missing, Total gallery images: $totalGallery");

        return 0;
    }

    private function downloadImage($url, $subdir)
    {
        if (empty($url) || ! str_starts_with($url, 'http')) {
            return null;
        }

        try {
            $response = Http::timeout(30)->withHeaders([
                'apikey' => $this->key,
            ])->get($url);

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
            return null;
        }
    }
}
