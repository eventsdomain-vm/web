<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\EventImportData;
use App\Models\Category;
use App\Models\Event;
use App\Models\EventDate;
use App\Models\EventVenue;
use App\Models\SponsorshipBenefit;
use App\Models\SponsorshipPackage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Imports events from the sponsorshipsearch_data.json file into the database.
 *
 * Responsibilities:
 *  - Map external category UUIDs to local Category IDs (creating subcategories as needed)
 *  - Create placeholder organizer User accounts (with 'organizer' role)
 *  - Transform each raw event record into an Event + SponsorshipPackages + Gallery
 *  - Handle deduplication via slug matching
 *  - Parse Indian budget ranges into numeric values
 */
class EventImportService
{
    /** @var array<string, int> external category slug → local category ID */
    private array $categoryMap = [];

    /** @var array<string, int> external organizer name → local user ID */
    private array $organizerMap = [];

    /** @var int fallback admin user ID */
    private int $adminId;

    /** @var int organizer role ID */
    private int $organizerRoleId;

    /** @var array<string, int> cache for slug uniqueness */
    private array $slugCache = [];

    // =========================================================================
    // Public API
    // =========================================================================

    /**
     * Run the full import from the JSON file. Returns summary stats.
     *
     * @return array{events_created: int, packages_created: int, organizers_created: int, categories_created: int, skipped: int}
     */
    public function import(): array
    {
        $data = $this->loadJson();
        $this->ensurePrerequisites();

        $stats = [
            'events_created' => 0,
            'packages_created' => 0,
            'organizers_created' => 0,
            'categories_created' => 0,
            'skipped' => 0,
        ];

        // 1. Create organizer users
        $organizerNames = $data['organizers'] ?? [];
        $this->organizerMap = $this->createOrganizerUsers($organizerNames);
        $stats['organizers_created'] = count($this->organizerMap);

        // 2. Map categories
        $categoryResults = $this->mapCategories($data['metadata']['categories'] ?? []);
        $this->categoryMap = $categoryResults['map'];
        $stats['categories_created'] = $categoryResults['created'];

        // 3. Import events
        foreach ($data['events'] as $raw) {
            $dto = EventImportData::fromArray($raw);

            if ($this->eventExists($dto->slug)) {
                $stats['skipped']++;

                continue;
            }

            DB::beginTransaction();
            try {
                $event = $this->createEvent($dto);
                $pkgs = $this->createPackages($event, $dto);
                $this->createGallery($event, $dto);

                DB::commit();
                $stats['events_created']++;
                $stats['packages_created'] += $pkgs;

                Log::info("Imported event: {$event->title}", ['event_id' => $event->id]);
            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error("Failed to import event: {$dto->title}", [
                    'error' => $e->getMessage(),
                    'event_id' => $dto->eventId,
                ]);
                $stats['skipped']++;
            }
        }

        return $stats;
    }

    // =========================================================================
    // JSON Loader
    // =========================================================================

    private function loadJson(): array
    {
        $path = database_path('sponsorshipsearch_data.json');

        if (! file_exists($path)) {
            $path = base_path('sponsorshipsearch_data.json');
        }

        if (! file_exists($path)) {
            throw new \RuntimeException('sponsorshipsearch_data.json not found');
        }

        $raw = file_get_contents($path);
        $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);

        return $data;
    }

    // =========================================================================
    // Prerequisites
    // =========================================================================

    private function ensurePrerequisites(): void
    {
        $this->adminId = User::where('email', 'admin@eventsdomain.com')->firstOrFail()->id;
        $this->organizerRoleId = DB::table('roles')->where('name', 'organizer')->firstOrFail()->id;
    }

    // =========================================================================
    // Category Mapping
    // =========================================================================

    /**
     * Map external category UUIDs to local Category IDs.
     * Creates subcategories under existing parent categories.
     *
     * @param  array<int, array{name: string, slug: string, category_id: string}>  $externalCategories
     * @return array{map: array<string, int>, created: int}
     */
    private function mapCategories(array $externalCategories): array
    {
        $map = [];
        $created = 0;

        // Build a lookup of existing categories by slug
        $existingBySlug = Category::pluck('id', 'slug')->toArray();
        $existingByName = Category::pluck('id', 'name')->toArray();

        // Map external category slugs to our parent category names
        $parentNameMap = [
            'sports' => 'Sports & Fitness',
            'music-entertainment' => 'Music & Entertainment',
            'technology' => 'Technology',
            'business-corporate' => 'Business & Professional',
            'education' => 'Education',
            'health-wellness' => 'Health & Wellness',
            'arts-culture' => 'Arts & Culture',
            'food-beverage' => 'Food & Drink',
            'fashion' => 'Arts & Culture',   // no Fashion parent, map to Arts
            'charity-non-profit' => 'Community & Social',
        ];

        foreach ($externalCategories as $ext) {
            $slug = $ext['slug'];
            $name = $ext['name'];

            // Try direct slug match first
            if (isset($existingBySlug[$slug])) {
                $map[$slug] = (int) $existingBySlug[$slug];

                continue;
            }

            // Try name match
            if (isset($existingByName[$name])) {
                $map[$slug] = (int) $existingByName[$name];

                continue;
            }

            // Create as subcategory under the appropriate parent
            $parentName = $parentNameMap[$slug] ?? 'Community & Social';
            $parentId = $existingByName[$parentName] ?? null;

            if (! $parentId) {
                // Find first parent category as ultimate fallback
                $parentId = Category::whereNull('parent_id')->first()?->id ?? 1;
            }

            $newCat = Category::create([
                'name' => $name,
                'slug' => $slug,
                'parent_id' => $parentId,
                'sort_order' => 50 + $created,
                'is_active' => true,
            ]);

            $map[$slug] = $newCat->id;
            $existingBySlug[$slug] = $newCat->id;
            $existingByName[$name] = $newCat->id;
            $created++;
        }

        return ['map' => $map, 'created' => $created];
    }

    // =========================================================================
    // Organizer Users
    // =========================================================================

    /**
     * Create placeholder organizer users from the JSON organizers list.
     *
     * @param  array<int, array{name: string, ...}>  $organizerEntries
     * @return array<string, int> organizer name → user ID
     */
    private function createOrganizerUsers(array $organizerEntries): array
    {
        $map = [];

        foreach ($organizerEntries as $entry) {
            $name = $entry['name'];
            $slug = Str::slug($name);
            $email = $slug.'@imported.local';

            // Check if user already exists by name or email
            $existing = User::where('name', $name)->orWhere('email', $email)->first();

            if ($existing) {
                $map[$name] = $existing->id;

                continue;
            }

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            $user->assignRole('organizer');
            $map[$name] = $user->id;
        }

        return $map;
    }

    // =========================================================================
    // Event Creation
    // =========================================================================

    private function eventExists(string $slug): bool
    {
        return Event::where('slug', $slug)->exists();
    }

    private function createEvent(EventImportData $dto): Event
    {
        $organizerId = $this->resolveOrganizerId($dto->organizer['name'] ?? null);
        $categoryId = $this->resolveCategoryId($dto->categoryId, $dto->category);

        $eventType = $this->mapEventType($dto->eventType);
        $sponsorshipType = $this->mapSponsorshipType($dto->sponsorshipType);

        $slug = $this->uniqueSlug($dto->slug ?: Str::slug($dto->title));

        $event = Event::create([
            'organizer_id' => $organizerId,
            'title' => $dto->title,
            'slug' => $slug,
            'tagline' => null,
            'description' => $dto->description ?? '',
            'category_id' => $categoryId,
            'event_type' => $eventType,
            'visibility' => 'public',
            'approval_status' => 'approved',
            'status' => 'live',
            'timezone' => 'Asia/Kolkata',
            'currency' => $dto->budgetCurrency,
            'budget_min' => $dto->budgetMin,
            'budget_max' => $dto->budgetMax,
            'sponsorship_type' => $sponsorshipType,
            'expected_audience' => $dto->expectedAudience,
            'audience_description' => $dto->audience['summary'] ?? null,
            'website_url' => null,
            'video_url' => null,
            'tags' => ! empty($dto->tags) ? $dto->tags : null,
            'is_featured' => $dto->featured,
            'is_published' => true,
            'published_at' => now(),
            'views_count' => $dto->views,
            'start_date' => $dto->startDate ? $dto->startDate.' '.($dto->startTime ?: '00:00:00') : null,
            'end_date' => $dto->endDate ? $dto->endDate.' '.($dto->endTime ?: '23:59:59') : null,
            'venue' => $dto->venue,
            'city' => $dto->city,
            'state' => $dto->state,
            'country' => $dto->country,
        ]);

        // Set cover_image from first gallery image
        if (! empty($dto->imageUrls)) {
            $event->update(['cover_image' => $dto->imageUrls[0]]);
        }

        // Create EventDate records for the normalized dates table
        if ($dto->startDate) {
            EventDate::create([
                'event_id' => $event->id,
                'start_date' => $dto->startDate,
                'end_date' => $dto->endDate ?? $dto->startDate,
                'start_time' => $dto->startTime,
                'end_time' => $dto->endTime,
                'label' => 'Main Event',
            ]);
        }

        // Create EventVenue if venue data exists
        if ($dto->venue || $dto->venueAddress) {
            EventVenue::create([
                'event_id' => $event->id,
                'venue_name' => $dto->venue,
                'address' => $dto->venueAddress,
                'city' => $dto->city,
                'state' => $dto->state,
                'country' => $dto->country,
                'is_primary' => true,
            ]);
        }

        return $event;
    }

    // =========================================================================
    // Sponsorship Packages
    // =========================================================================

    private function createPackages(Event $event, EventImportData $dto): int
    {
        $count = 0;
        $sortOrder = 0;

        // 1. Sponsorship tiers
        foreach ($dto->sponsorshipTiers as $tier) {
            $level = $tier['level'] ?? 'Sponsor';
            $budgetRange = $tier['budget_range'] ?? null;
            $price = $budgetRange ? $this->parseIndianBudgetRange($budgetRange) : 0;

            $slotsTotal = $tier['slots_total'] ?? 1;
            $slotsFilled = $tier['slots_filled'] ?? 0;

            $benefits = $this->getBenefitsForLevel($level);

            $pkg = SponsorshipPackage::create([
                'event_id' => $event->id,
                'title' => $level,
                'level' => $level,
                'description' => "{$level} sponsorship tier",
                'price' => max($price, 0),
                'currency' => 'INR',
                'budget_range_label' => $budgetRange,
                'slots_available' => $slotsTotal,
                'slots_filled' => $slotsFilled,
                'is_active' => true,
                'sort_order' => $sortOrder++,
            ]);
            $this->createBenefits($pkg, $benefits);
            $count++;
        }

        // 2. Advertising spaces
        foreach ($dto->advertisingSpaces as $ad) {
            $price = $this->parseIndianPrice($ad['pricing'] ?? null);

            $details = $ad['details'] ?? [];
            $pkg = SponsorshipPackage::create([
                'event_id' => $event->id,
                'title' => $ad['type'] ?? 'Advertising',
                'level' => 'Advertising',
                'description' => implode(', ', $details),
                'price' => max($price, 0),
                'currency' => 'INR',
                'budget_range_label' => $ad['pricing'] ?? null,
                'slots_available' => $ad['availability'] ?? 1,
                'slots_filled' => 0,
                'is_active' => true,
                'sort_order' => $sortOrder++,
            ]);
            $this->createBenefits($pkg, $details);
            $count++;
        }

        // 3. Exhibition stalls
        foreach ($dto->exhibitionStalls as $stall) {
            $price = $this->parseIndianPrice($stall['pricing'] ?? null);

            $pkg = SponsorshipPackage::create([
                'event_id' => $event->id,
                'title' => $stall['type'] ?? 'Exhibition Stall',
                'level' => 'Exhibition',
                'description' => $stall['details'] ?? 'Exhibition space',
                'price' => max($price, 0),
                'currency' => 'INR',
                'budget_range_label' => $stall['pricing'] ?? null,
                'slots_available' => $stall['slots_total'] ?? 1,
                'slots_filled' => 0,
                'is_active' => true,
                'sort_order' => $sortOrder++,
            ]);
            $this->createBenefits($pkg, [$stall['details'] ?? 'Exhibition space']);
            $count++;
        }

        // 4. Food partnerships
        foreach ($dto->foodPartnerships as $food) {
            $price = $this->parseIndianPrice($food['pricing'] ?? null);

            $pkg = SponsorshipPackage::create([
                'event_id' => $event->id,
                'title' => $food['type'] ?? 'Food Partner',
                'level' => 'Food',
                'description' => ($food['exclusive'] ?? false) ? 'Exclusive partner' : 'Non-exclusive partner',
                'price' => max($price, 0),
                'currency' => 'INR',
                'budget_range_label' => $food['pricing'] ?? null,
                'slots_available' => $food['slots_total'] ?? 1,
                'slots_filled' => 0,
                'is_active' => true,
                'sort_order' => $sortOrder++,
            ]);
            $this->createBenefits($pkg, [($food['exclusive'] ?? false) ? 'Exclusive partner' : 'Non-exclusive partner']);
            $count++;
        }

        // 5. Content add-ons
        if ($dto->contentAddons && ! empty($dto->contentAddons['items'])) {
            $price = $this->parseIndianPrice($dto->contentAddons['pricing'] ?? null);

            $pkg = SponsorshipPackage::create([
                'event_id' => $event->id,
                'title' => $dto->contentAddons['type'] ?? 'Content Add-ons',
                'level' => 'Content',
                'description' => 'Additional content and media add-ons',
                'price' => max($price, 0),
                'currency' => 'INR',
                'budget_range_label' => $dto->contentAddons['pricing'] ?? null,
                'slots_available' => $dto->contentAddons['availability'] ?? 5,
                'slots_filled' => 0,
                'is_active' => true,
                'sort_order' => $sortOrder++,
            ]);
            $this->createBenefits($pkg, $dto->contentAddons['items']);
            $count++;
        }

        return $count;
    }

    private function createBenefits(SponsorshipPackage $package, array $benefits): void
    {
        foreach ($benefits as $benefit) {
            if (is_string($benefit) && trim($benefit) !== '') {
                SponsorshipBenefit::create([
                    'package_id' => $package->id,
                    'benefit_text' => trim($benefit),
                ]);
            }
        }
    }

    // =========================================================================
    // Gallery
    // =========================================================================

    private function createGallery(Event $event, EventImportData $dto): void
    {
        if (empty($dto->imageUrls)) {
            return;
        }

        $sortOrder = 0;
        foreach ($dto->imageUrls as $imageUrl) {
            // Store the URL directly in the legacy gallery table
            DB::table('event_gallery')->insert([
                'event_id' => $event->id,
                'image_url' => $imageUrl,
                'caption' => null,
                'sort_order' => $sortOrder++,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // =========================================================================
    // Resolution Helpers
    // =========================================================================

    private function resolveOrganizerId(?string $organizerName): int
    {
        if (! $organizerName || $organizerName === 'Not publicly listed on page') {
            return $this->adminId;
        }

        // Check if we already created a user for this organizer
        foreach ($this->organizerMap as $name => $userId) {
            if (str_contains($organizerName, $name) || str_contains($name, $organizerName)) {
                return $userId;
            }
        }

        return $this->adminId;
    }

    private function resolveCategoryId(string $externalId, string $categoryName): int
    {
        // Try by mapped slug first
        foreach ($this->categoryMap as $slug => $localId) {
            // Check if this category name matches
            $cat = Category::find($localId);
            if ($cat && strcasecmp($cat->name, $categoryName) === 0) {
                return $localId;
            }
        }

        // Try by direct name match in categories table
        $found = Category::where('name', 'LIKE', "%{$categoryName}%")->first();
        if ($found) {
            return $found->id;
        }

        // Fallback: first parent category
        return Category::whereNull('parent_id')->first()?->id ?? 1;
    }

    // =========================================================================
    // Mappers
    // =========================================================================

    private function mapEventType(string $raw): string
    {
        return match (true) {
            str_contains($raw, 'Virtual') || str_contains($raw, 'Podcast') => 'virtual',
            str_contains($raw, 'Multi-city') => 'hybrid',
            default => 'physical',
        };
    }

    private function mapSponsorshipType(string $raw): string
    {
        return match ($raw) {
            'Paid + Barter' => 'hybrid',
            'Barter/In-Kind' => 'barter',
            default => 'paid',
        };
    }

    // =========================================================================
    // Slug Generator
    // =========================================================================

    private function uniqueSlug(string $base): string
    {
        $slug = Str::slug($base);
        $original = $slug;
        $counter = 1;

        while (isset($this->slugCache[$slug]) || Event::where('slug', $slug)->exists()) {
            $slug = $original.'-'.$counter;
            $counter++;
        }

        $this->slugCache[$slug] = true;

        return $slug;
    }

    // =========================================================================
    // Budget Parser (Indian format)
    // =========================================================================

    private function parseIndianBudgetRange(string $range): int
    {
        $range = trim($range);

        // "Under ₹X Lakhs" or "Under ₹X Crore"
        if (preg_match('/Under\s*₹?(\d+(?:,\d+)?)\s*(Lakh|Crore)s?/i', $range, $m)) {
            $val = (float) str_replace(',', '', $m[1]);
            $mult = strtolower($m[2]) === 'crore' ? 10_000_000 : 100_000;

            return (int) ($val * $mult / 2);
        }

        // "₹X-Y Lakhs" or "₹X-Y Crore"
        if (preg_match('/₹?(\d+(?:,\d+)?)\s*-\s*₹?(\d+(?:,\d+)?)\s*(Lakh|Crore)s?/i', $range, $m)) {
            $min = (float) str_replace(',', '', $m[1]);
            $max = (float) str_replace(',', '', $m[2]);
            $mult = strtolower($m[3]) === 'crore' ? 10_000_000 : 100_000;

            return (int) ($max * $mult);
        }

        // "₹X Lakhs+" or "₹X Crore+"
        if (preg_match('/₹?(\d+(?:,\d+)?)\s*(Lakh|Crore)s?\s*\+/i', $range, $m)) {
            $val = (float) str_replace(',', '', $m[1]);
            $mult = strtolower($m[2]) === 'crore' ? 10_000_000 : 100_000;

            return (int) ($val * $mult);
        }

        // "₹X Lakhs" or "₹X Crore" (exact)
        if (preg_match('/₹?(\d+(?:,\d+)?)\s*(Lakh|Crore)s?/i', $range, $m)) {
            $val = (float) str_replace(',', '', $m[1]);
            $mult = strtolower($m[2]) === 'crore' ? 10_000_000 : 100_000;

            return (int) ($val * $mult);
        }

        return 0;
    }

    private function parseIndianPrice(?string $pricing): int
    {
        if (! $pricing || $pricing === 'Contact for pricing') {
            return 0;
        }

        $cleaned = preg_replace('/[^0-9]/', '', $pricing);

        return $cleaned ? (int) $cleaned : 0;
    }

    // =========================================================================
    // Benefits by Level
    // =========================================================================

    private function getBenefitsForLevel(string $level): array
    {
        $allBenefits = [
            'Title Sponsor' => [
                'Logo on all event creatives', 'Logo on stage backdrop', 'Logo on banners & standees',
                'Logo on website', 'Logo on entry gate', 'Logo on LED screens',
                'On-stage brand mention', 'Emcee brand mention throughout event',
                'Dedicated speaking slot (5-10 min)', 'Award presentation opportunity',
                'Brand video playback during event', 'Social media shoutouts (3+ posts)',
                'Dedicated social media post', 'Emailer mention to all attendees',
                'WhatsApp broadcast mention', 'Post-event thank-you post',
                'Website backlink', 'Product sampling opportunity',
                'Giveaway distribution rights', 'Data capture opportunity (opt-in)',
            ],
            'Co-Sponsor' => [
                'Logo on event creatives', 'Logo on banners & standees', 'Logo on website',
                'Emcee brand mention', 'Social media shoutouts (2 posts)',
                'Dedicated social post', 'Brand video playback',
                'Product sampling', 'Giveaway distribution', 'Emailer mention',
            ],
            'Associate Sponsor' => [
                'Logo on event creatives', 'Logo on website', 'Social media shoutout',
                'Emcee brand mention', 'Standee placement at venue',
            ],
            'Powered By Sponsor' => [
                'Logo on event creatives', 'Logo on website', 'Social media mention',
                'Logo on banners',
            ],
            'Media Partner' => [
                'Logo on event creatives', 'Logo on website', 'Social media mention',
                'Media coverage accreditation', 'Interview opportunities',
            ],
            'Diamond Sponsor' => [
                'Premium logo placement', 'Logo on stage backdrop', 'Logo on all creatives',
                'Dedicated speaking slot', 'Social media campaign', 'VIP access',
            ],
            'Platinum Sponsor' => [
                'Logo on event creatives', 'Logo on website', 'Social media shoutout',
                'Standee at prime location', 'Brand mention by emcee',
            ],
            'Gold Sponsor' => [
                'Logo on event creatives', 'Logo on website', 'Social media mention',
                'Standee placement',
            ],
            'Silver Sponsor' => [
                'Logo on event creatives', 'Logo on website', 'Social media mention',
            ],
        ];

        foreach ($allBenefits as $key => $benefits) {
            if (str_contains($level, $key)) {
                return $benefits;
            }
        }

        return [
            'Logo on event creatives',
            'Logo on website',
            'Social media mention',
            'Brand recognition at event',
        ];
    }
}
