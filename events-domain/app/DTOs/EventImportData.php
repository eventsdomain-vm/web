<?php

declare(strict_types=1);

namespace App\DTOs;

/**
 * Immutable DTO representing a single raw event record from sponsorshipsearch_data.json.
 * All transformers read from this DTO rather than touching the raw array directly.
 */
final class EventImportData
{
    public function __construct(
        public readonly string $title,
        public readonly string $eventId,
        public readonly string $slug,
        public readonly string $category,
        public readonly string $categoryId,
        public readonly ?string $description,
        public readonly ?string $city,
        public readonly ?string $state,
        public readonly string $country,
        public readonly ?string $venue,
        public readonly ?string $venueAddress,
        public readonly ?string $startDate,
        public readonly ?string $endDate,
        public readonly ?string $startTime,
        public readonly ?string $endTime,
        public readonly ?int $expectedAudience,
        public readonly ?int $budgetMin,
        public readonly ?int $budgetMax,
        public readonly ?string $budgetRangeDisplay,
        public readonly string $budgetCurrency,
        public readonly string $sponsorshipType,
        public readonly string $eventType,
        public readonly array $sponsorshipTiers,
        public readonly array $advertisingSpaces,
        public readonly array $exhibitionStalls,
        public readonly array $foodPartnerships,
        public readonly ?array $contentAddons,
        public readonly array $tags,
        public readonly array $imageUrls,
        public readonly int $views,
        public readonly bool $featured,
        public readonly bool $trending,
        public readonly bool $hasVideo,
        public readonly ?array $audience,
        public readonly array $organizer,
        public readonly ?array $confirmedSponsors,
        public readonly ?array $sponsorshipBenefits,
        public readonly ?array $tourCities,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            eventId: (string) ($data['event_id'] ?? ''),
            slug: $data['slug'] ?? '',
            category: $data['category'] ?? '',
            categoryId: $data['category_id'] ?? '',
            description: $data['description'] ?? null,
            city: $data['city'] ?? null,
            state: $data['state'] ?? null,
            country: $data['country'] ?? 'India',
            venue: $data['venue'] ?? null,
            venueAddress: $data['venue_address'] ?? null,
            startDate: $data['start_date'] ?? null,
            endDate: $data['end_date'] ?? null,
            startTime: $data['start_time'] ?? null,
            endTime: $data['end_time'] ?? null,
            expectedAudience: $data['expected_audience'] ?? null,
            budgetMin: $data['budget_min'] ?? null,
            budgetMax: $data['budget_max'] ?? null,
            budgetRangeDisplay: $data['budget_range_display'] ?? null,
            budgetCurrency: $data['budget_currency'] ?? 'INR',
            sponsorshipType: $data['sponsorship_type'] ?? 'Paid Sponsorship',
            eventType: $data['event_type'] ?? 'In-person',
            sponsorshipTiers: $data['sponsorship_tiers'] ?? [],
            advertisingSpaces: $data['advertising_spaces'] ?? [],
            exhibitionStalls: $data['exhibition_stalls'] ?? [],
            foodPartnerships: $data['food_partnerships'] ?? [],
            contentAddons: $data['content_addons'] ?? null,
            tags: $data['tags'] ?? [],
            imageUrls: $data['image_urls'] ?? [],
            views: $data['views'] ?? 0,
            featured: $data['featured'] ?? false,
            trending: $data['trending'] ?? false,
            hasVideo: $data['has_video'] ?? false,
            audience: $data['audience'] ?? null,
            organizer: $data['organizer'] ?? ['name' => 'Not publicly listed on page'],
            confirmedSponsors: $data['confirmed_sponsors'] ?? null,
            sponsorshipBenefits: $data['sponsorship_benefits'] ?? null,
            tourCities: $data['tour_cities'] ?? null,
        );
    }
}
