<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Event;
use App\Models\EventDate;
use App\Models\EventVenue;
use App\Models\SponsorshipPackage;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportSponsorshipEvents extends Command
{
    protected $signature = 'import:sponsorship-events';

    protected $description = 'Import remaining past events and download images from sponsorshipsearch.com';

    private $categoryMap = [];

    private $organizerUser;

    public function handle()
    {
        $this->info('Starting import...');

        $this->buildCategoryMap();
        $this->ensureOrganizerUser();

        $json = json_decode(file_get_contents(database_path('sponsorshipsearch_data.json')), true);

        // Phase 1: Download images for existing events
        $this->info('Phase 1: Downloading images for existing events...');
        $this->downloadExistingImages();

        // Phase 2: Import past events that aren't in the DB yet
        $this->info('Phase 2: Importing missing past events...');
        $existingSlugs = DB::table('events')->pluck('slug')->toArray();

        $pastList = $json['past_events_listing'] ?? [];
        $fullEvents = $json['events'] ?? [];

        $fullSlugs = array_column($fullEvents, 'slug');
        $imported = 0;
        $scraped = 0;

        foreach ($pastList as $pe) {
            if (in_array($pe['slug'], $existingSlugs)) {
                continue;
            }

            $this->info("Processing: {$pe['title']}");

            // Check if it has full detail in events array
            $idx = array_search($pe['slug'], $fullSlugs);
            if ($idx !== false) {
                $this->importFromJson($fullEvents[$idx]);
                $imported++;
            } else {
                // Scrape the page
                $data = $this->scrapeEventPage($pe['slug']);
                if ($data) {
                    $this->importFromScraped($data, $pe);
                    $scraped++;
                } else {
                    $this->warn("Failed to scrape: {$pe['title']}");
                }
            }
        }

        $this->info("Done. Imported: $imported full, $scraped scraped");
    }

    private function buildCategoryMap()
    {
        $categories = Category::all();
        foreach ($categories as $cat) {
            $this->categoryMap[strtolower($cat->name)] = $cat->id;
        }
        // Add direct name matches
        $this->categoryMap['music & entertainment'] = $this->findCategoryId('Music & Entertainment');
        $this->categoryMap['sports'] = $this->findCategoryId('Sports');
        $this->categoryMap['health & wellness'] = $this->findCategoryId('Health & Wellness');
        $this->categoryMap['arts & culture'] = $this->findCategoryId('Arts & Culture');
        $this->categoryMap['technology'] = $this->findCategoryId('Technology');
        $this->categoryMap['education'] = $this->findCategoryId('Education');
        $this->categoryMap['food & beverage'] = $this->findCategoryId('Food & Beverage');
        $this->categoryMap['fashion'] = $this->findCategoryId('Fashion');
        $this->categoryMap['charity & non-profit'] = $this->findCategoryId('Charity & Non-Profit');
    }

    private function findCategoryId($name)
    {
        $cat = Category::where('name', $name)->first();

        return $cat ? $cat->id : 1;
    }

    private function mapCategory($name)
    {
        $key = strtolower(trim($name));

        return $this->categoryMap[$key] ?? $this->findCategoryId($name) ?? 1;
    }

    private function ensureOrganizerUser()
    {
        $this->organizerUser = User::where('email', 'admin@eventsdomain.com')->first();
        if (! $this->organizerUser) {
            $this->organizerUser = User::first();
        }
    }

    private function downloadExistingImages()
    {
        $events = DB::table('events')->get(['id', 'title', 'cover_image', 'logo', 'banner_image']);

        foreach ($events as $event) {
            $urls = [];
            if ($event->cover_image) {
                $urls['cover_image'] = $event->cover_image;
            }
            if ($event->logo) {
                $urls['logo'] = $event->logo;
            }
            if ($event->banner_image) {
                $urls['banner_image'] = $event->banner_image;
            }

            foreach ($urls as $field => $url) {
                if (str_starts_with($url, 'http')) {
                    $localPath = $this->downloadImage($url, "events/{$event->id}");
                    if ($localPath) {
                        DB::table('events')->where('id', $event->id)->update([$field => $localPath]);
                        $this->info("  Downloaded {$field} for event {$event->id}");
                    }
                }
            }
        }
    }

    private function downloadImage($url, $subdir)
    {
        if (empty($url) || ! str_starts_with($url, 'http')) {
            return $url;
        }

        try {
            $response = Http::timeout(30)->get($url);
            if (! $response->successful()) {
                return null;
            }

            $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'jfif'])) {
                $ext = 'jpg';
            }

            $filename = Str::random(32).'.'.$ext;
            $path = "events/{$subdir}/{$filename}";

            Storage::disk('public')->put($path, $response->body());

            return $path;
        } catch (\Exception $e) {
            $this->warn("  Failed to download: $url - {$e->getMessage()}");

            return null;
        }
    }

    private function importFromJson(array $data)
    {
        try {
            DB::beginTransaction();

            $event = Event::create([
                'organizer_id' => $this->organizerUser->id,
                'category_id' => $this->mapCategory($data['category']),
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => $data['description'] ?? '',
                'event_type' => 'physical',
                'visibility' => 'public',
                'status' => 'live',
                'approval_status' => 'approved',
                'is_published' => true,
                'is_featured' => $data['featured'] ?? false,
                'timezone' => 'Asia/Kolkata',
                'currency' => 'INR',
                'budget_min' => $data['budget_min'],
                'budget_max' => $data['budget_max'],
                'sponsorship_type' => $this->mapSponsorshipType($data['sponsorship_type']),
                'expected_audience' => $data['expected_audience'],
                'views_count' => $data['views'] ?? 0,
                'start_date' => $data['start_date'] ? $data['start_date'].($data['start_time'] ? " {$data['start_time']}" : '') : null,
                'end_date' => $data['end_date'] ? $data['end_date'].($data['end_time'] ? " {$data['end_time']}" : '') : null,
                'venue' => $data['venue'],
                'city' => $data['city'],
                'state' => $data['state'] ?? '',
                'country' => $data['country'] ?? 'India',
                'tags' => $data['tags'] ?? [],
                'published_at' => now(),
            ]);

            // Create event date
            if ($data['start_date']) {
                EventDate::create([
                    'event_id' => $event->id,
                    'label' => 'Main Event',
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'all_day' => empty($data['start_time']),
                    'sort_order' => 0,
                ]);
            }

            // Create venue
            EventVenue::create([
                'event_id' => $event->id,
                'venue_type' => 'physical',
                'venue_name' => $data['venue'],
                'address' => $data['venue_address'] ?? null,
                'city' => $data['city'],
                'state' => $data['state'] ?? '',
                'country' => $data['country'] ?? 'India',
                'is_primary' => true,
                'sort_order' => 0,
            ]);

            // Create sponsorship packages
            if (! empty($data['sponsorship_tiers'])) {
                foreach ($data['sponsorship_tiers'] as $i => $tier) {
                    SponsorshipPackage::create([
                        'event_id' => $event->id,
                        'title' => $tier['level'],
                        'level' => $tier['level'],
                        'price' => $this->parseBudgetRange($tier['budget_range'] ?? ''),
                        'slots_available' => $tier['slots_available'] ?? ($tier['slots_total'] ?? 1),
                        'description' => "{$tier['level']} sponsorship opportunity",
                        'is_active' => true,
                        'sort_order' => $i,
                    ]);
                }
            }

            // Download and store images
            if (! empty($data['image_urls'])) {
                foreach ($data['image_urls'] as $idx => $imgUrl) {
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
            }

            DB::commit();
            $this->info("  Imported (JSON): {$data['title']}");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("  Failed to import {$data['title']}: {$e->getMessage()}");
        }
    }

    private function scrapeEventPage($slug)
    {
        $url = "https://sponsorshipsearch.com/events/{$slug}";
        try {
            $response = Http::timeout(30)->get($url);
            if (! $response->successful()) {
                return null;
            }

            $html = $response->body();

            return $this->parseEventHtml($html);
        } catch (\Exception $e) {
            $this->warn("  HTTP error for $slug: {$e->getMessage()}");

            return null;
        }
    }

    private function parseEventHtml($html)
    {
        $data = [
            'title' => '',
            'description' => '',
            'category' => '',
            'city' => '',
            'state' => '',
            'country' => 'India',
            'venue' => '',
            'venue_address' => '',
            'start_date' => '',
            'end_date' => '',
            'start_time' => null,
            'end_time' => null,
            'expected_audience' => null,
            'budget_min' => null,
            'budget_max' => null,
            'sponsorship_type' => '',
            'image_urls' => [],
            'views' => 0,
        ];

        // Use DOMDocument for more reliable HTML parsing
        $doc = new \DOMDocument;
        @$doc->loadHTML('<?xml encoding="UTF-8">'.$html);
        $xpath = new \DOMXPath($doc);

        // Title from h1
        $h1Nodes = $xpath->query('//h1');
        foreach ($h1Nodes as $node) {
            $text = trim($node->textContent);
            if (! empty($text) && ! str_contains($text, 'Find Sponsorship') && ! str_contains($text, 'Past Events')) {
                $data['title'] = $text;
                break;
            }
        }

        // Category from breadcrumb links
        $links = $xpath->query('//a[contains(@href, "category=")]');
        foreach ($links as $link) {
            $text = trim($link->textContent);
            if (! empty($text) && ! str_contains($text, 'All')) {
                $data['category'] = $text;
                break;
            }
        }

        // Extract text content for pattern matching
        $bodyText = $doc->textContent;

        // View count
        if (preg_match('/([\d,]+)\s*views/', $bodyText, $m)) {
            $data['views'] = (int) str_replace(',', '', $m[1]);
        }

        // Parse structured data from the detail grid using line-by-line approach
        $lines = explode("\n", $bodyText);
        $currentKey = null;
        $aboutStarted = false;
        $aboutText = '';

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            // Track key-value pairs
            if (str_starts_with($line, 'Event Date')) {
                $currentKey = 'event_date';

                continue;
            }
            if (str_starts_with($line, 'Event Time')) {
                $currentKey = 'event_time';

                continue;
            }
            if (str_starts_with($line, 'Venue')) {
                $currentKey = 'venue';

                continue;
            }
            if (str_starts_with($line, 'Location')) {
                $currentKey = 'location';

                continue;
            }
            if (str_starts_with($line, 'Expected Audience')) {
                $currentKey = 'audience';

                continue;
            }
            if (str_starts_with($line, 'Budget Range')) {
                $currentKey = 'budget';

                continue;
            }
            if (str_starts_with($line, 'Sponsorship Type')) {
                $currentKey = 'sponsorship_type';

                continue;
            }

            // About This Event section
            if (str_contains($line, 'About This Event')) {
                $aboutStarted = true;
                $currentKey = 'about';

                continue;
            }

            // Event Has Ended or other headings stop the about section
            if ($aboutStarted && (str_starts_with($line, '##') || str_starts_with($line, '###'))) {
                if (! str_contains($line, 'About This Event')) {
                    $aboutStarted = false;
                    $currentKey = null;
                }
            }

            if ($currentKey === 'about' && $aboutStarted) {
                if (! str_starts_with($line, '#')) {
                    $aboutText .= ' '.$line;
                }

                continue;
            }

            // Capture value for current key
            if ($currentKey === 'event_date' && preg_match('/^[A-Z][a-z]{2}\s+\d+/', $line)) {
                $parts = explode(' - ', $line);
                $data['start_date'] = $this->parseDateFromText(trim($parts[0]));
                if (isset($parts[1])) {
                    $endPart = preg_replace('/\s+at\s+\d+.*$/', '', trim($parts[1]));
                    $data['end_date'] = $this->parseDateFromText($endPart);
                }
                // Extract time from "at HH:MM"
                if (preg_match('/at\s+(\d{1,2}:\d{2})/', $line, $tm)) {
                    $data['start_time'] = $tm[1];
                }
                $currentKey = null;
            } elseif ($currentKey === 'event_time' && preg_match('/^\d{1,2}:\d{2}/', $line)) {
                $parts = explode(' - ', $line);
                $data['start_time'] = trim($parts[0]);
                if (isset($parts[1])) {
                    $data['end_time'] = trim($parts[1]);
                }
                $currentKey = null;
            } elseif ($currentKey === 'venue' && ! str_starts_with($line, '#')) {
                $data['venue'] = $line;
                $currentKey = null;
            } elseif ($currentKey === 'location' && ! str_starts_with($line, '#')) {
                $locParts = explode(',', $line);
                $data['city'] = trim($locParts[0]);
                if (isset($locParts[1])) {
                    $remainder = trim($locParts[1]);
                    if (str_contains($remainder, 'India')) {
                        $data['country'] = 'India';
                        $data['state'] = trim(str_replace('India', '', $remainder));
                    } else {
                        $data['state'] = $remainder;
                    }
                }
                $currentKey = null;
            } elseif ($currentKey === 'audience' && preg_match('/^[\d,]+$/', $line)) {
                $data['expected_audience'] = (int) str_replace(',', '', $line);
                $currentKey = null;
            } elseif ($currentKey === 'budget' && (str_contains($line, '₹') || str_contains($line, 'Lakh') || str_contains($line, 'Under'))) {
                $data['budget_range_display'] = $line;
                $this->parseBudgetRangeToMinMax($line, $data);
                $currentKey = null;
            } elseif ($currentKey === 'sponsorship_type' && ! str_starts_with($line, '#')) {
                $data['sponsorship_type'] = $line;
                $currentKey = null;
            }
        }

        // Store description
        $data['description'] = trim($aboutText);

        // Extract images from HTML
        preg_match_all('/<img[^>]+src="([^"]+supabase[^"]+)"[^>]*>/', $html, $matches);
        $data['image_urls'] = array_unique($matches[1]);

        // Fallback: if title not found from h1, try the basic data
        if (empty($data['title'])) {
            if (preg_match('/<title>([^<]+)<\/title>/', $html, $m)) {
                $t = $m[1];
                $t = preg_replace('/\s*-\s*SponsorshipSearch.*$/', '', $t);
                $data['title'] = trim($t);
            }
        }

        return $data;
    }

    private function parseDateFromText($text)
    {
        $months = ['Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04', 'May' => '05', 'Jun' => '06',
            'Jul' => '07', 'Aug' => '08', 'Sep' => '09', 'Oct' => '10', 'Nov' => '11', 'Dec' => '12'];
        if (preg_match('/([A-Z][a-z]{2})\s+(\d{1,2})(?:\s*,\s*(\d{4}))?/', $text, $m)) {
            $mon = $months[$m[1]] ?? '01';
            $day = str_pad($m[2], 2, '0', STR_PAD_LEFT);
            $year = $m[3] ?? '2026';

            return "{$year}-{$mon}-{$day}";
        }

        return $text;
    }

    private function importFromScraped(array $data, array $basic)
    {
        try {
            if (empty($data['title'])) {
                $data['title'] = $basic['title'];
            }
            if (empty($data['city'])) {
                $data['city'] = $basic['city'] ?? '';
            }

            // Clean null/empty values
            $data['start_time'] = ! empty($data['start_time']) ? $data['start_time'] : null;
            $data['end_time'] = ! empty($data['end_time']) ? $data['end_time'] : null;
            $data['start_date'] = ! empty($data['start_date']) ? $data['start_date'] : ($basic['date'] ?? null);
            $data['end_date'] = ! empty($data['end_date']) ? $data['end_date'] : $data['start_date'];

            DB::beginTransaction();

            $event = Event::create([
                'organizer_id' => $this->organizerUser->id,
                'category_id' => $this->mapCategory($data['category'] ?: 'Music & Entertainment'),
                'title' => $data['title'],
                'slug' => $basic['slug'],
                'description' => $data['description'] ?? '',
                'event_type' => 'physical',
                'visibility' => 'public',
                'status' => 'completed',
                'approval_status' => 'approved',
                'is_published' => true,
                'timezone' => 'Asia/Kolkata',
                'currency' => 'INR',
                'budget_min' => $data['budget_min'],
                'budget_max' => $data['budget_max'],
                'sponsorship_type' => $this->mapSponsorshipType($data['sponsorship_type']),
                'expected_audience' => $data['expected_audience'],
                'views_count' => $data['views'] ?? 0,
                'start_date' => $data['start_date'] ? $data['start_date'].($data['start_time'] ? " {$data['start_time']}" : '') : null,
                'end_date' => $data['end_date'] ? $data['end_date'].($data['end_time'] ? " {$data['end_time']}" : '') : null,
                'venue' => $data['venue'] ?: null,
                'city' => $data['city'] ?: null,
                'state' => $data['state'] ?? null,
                'country' => $data['country'] ?? 'India',
                'published_at' => now(),
            ]);

            // Create event date
            if ($data['start_date']) {
                EventDate::create([
                    'event_id' => $event->id,
                    'label' => 'Main Event',
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'] ?: $data['start_date'],
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'all_day' => empty($data['start_time']),
                    'sort_order' => 0,
                ]);
            }

            // Create venue
            if (! empty($data['city'])) {
                EventVenue::create([
                    'event_id' => $event->id,
                    'venue_type' => 'physical',
                    'venue_name' => $data['venue'] ?: null,
                    'city' => $data['city'],
                    'state' => $data['state'] ?? null,
                    'country' => $data['country'] ?? 'India',
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }

            // Download and store images
            $allImages = array_unique(array_filter(array_merge(
                $data['image_urls'] ?? [],
                isset($basic['image_url']) ? [$basic['image_url']] : []
            )));

            foreach ($allImages as $idx => $imgUrl) {
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
            $this->info("  Imported (Scraped): {$data['title']}");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("  Failed to import {$data['title']}: {$e->getMessage()}");
        }
    }

    private function mapSponsorshipType($type)
    {
        return match (strtolower($type ?? '')) {
            'paid sponsorship', 'paid' => 'paid',
            'barter/in-kind', 'barter' => 'barter',
            'paid + barter', 'hybrid' => 'hybrid',
            default => 'paid',
        };
    }

    private function parseBudgetRange($range)
    {
        if (empty($range)) {
            return null;
        }
        if (preg_match('/([\d,]+)\s*Lakh/', $range, $m)) {
            return (float) str_replace(',', '', $m[1]) * 100000;
        }
        if (preg_match('/([\d,]+)\s*Crore/', $range, $m)) {
            return (float) str_replace(',', '', $m[1]) * 10000000;
        }

        return null;
    }

    private function parseBudgetRangeToMinMax($range, array &$data)
    {
        if (preg_match('/Under ₹?([\d,]+)\s*Lakh/', $range, $m)) {
            $data['budget_min'] = 0;
            $data['budget_max'] = (float) str_replace(',', '', $m[1]) * 100000;
        } elseif (preg_match('/₹?([\d,]+)\s*Lakhs?\s*\+\s*/', $range, $m)) {
            $data['budget_min'] = (float) str_replace(',', '', $m[1]) * 100000;
            $data['budget_max'] = null;
        } elseif (preg_match('/₹?([\d,]+)\s*[-–]\s*₹?([\d,]+)\s*Lakhs?/', $range, $m)) {
            $data['budget_min'] = (float) str_replace(',', '', $m[1]) * 100000;
            $data['budget_max'] = (float) str_replace(',', '', $m[2]) * 100000;
        }
    }
}
