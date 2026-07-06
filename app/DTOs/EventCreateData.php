<?php

declare(strict_types=1);

namespace App\DTOs;

final class EventCreateData
{
    public function __construct(
        public readonly int $organizerId,
        public readonly string $title,
        public readonly ?string $tagline,
        public readonly string $description,
        public readonly int $categoryId,
        public readonly ?int $subcategoryId,
        public readonly string $eventType,
        public readonly string $visibility,
        public readonly ?string $venue,
        public readonly ?string $address,
        public readonly ?string $city,
        public readonly ?string $state,
        public readonly ?string $country,
        public readonly ?string $startDate,
        public readonly ?string $endDate,
        public readonly ?string $registrationDeadline,
        public readonly ?int $expectedAudience,
        public readonly ?string $audienceDescription,
        public readonly ?float $budgetMin,
        public readonly ?float $budgetMax,
        public readonly string $sponsorshipType,
        public readonly string $currency,
        public readonly ?string $websiteUrl,
        public readonly ?string $videoUrl,
        public readonly ?array $tags,
    ) {}

    public static function fromRequest(array $data, int $organizerId): self
    {
        $tags = null;
        if (! empty($data['tags'])) {
            $raw = is_string($data['tags']) ? explode("\n", $data['tags']) : $data['tags'];
            $tags = array_values(array_filter(array_map('trim', $raw), fn ($t) => ! empty($t) && strlen($t) <= 100));
        }

        return new self(
            organizerId: $organizerId,
            title: $data['title'],
            tagline: $data['tagline'] ?? null,
            description: $data['description'] ?? '',
            categoryId: (int) $data['category_id'],
            subcategoryId: ! empty($data['subcategory_id']) ? (int) $data['subcategory_id'] : null,
            eventType: $data['event_type'] ?? 'physical',
            visibility: $data['visibility'] ?? 'public',
            venue: $data['venue'] ?? $data['address'] ?? null,
            address: $data['address'] ?? null,
            city: $data['city'] ?? null,
            state: $data['state'] ?? null,
            country: $data['country'] ?? 'India',
            startDate: $data['start_date'] ?? null,
            endDate: $data['end_date'] ?? null,
            registrationDeadline: $data['registration_deadline'] ?? null,
            expectedAudience: ! empty($data['expected_audience']) ? (int) $data['expected_audience'] : null,
            audienceDescription: $data['audience_description'] ?? null,
            budgetMin: isset($data['budget_min']) ? (float) $data['budget_min'] : null,
            budgetMax: isset($data['budget_max']) ? (float) $data['budget_max'] : null,
            sponsorshipType: $data['sponsorship_type'] ?? 'paid',
            currency: $data['currency'] ?? 'INR',
            websiteUrl: $data['website_url'] ?? null,
            videoUrl: $data['video_url'] ?? null,
            tags: $tags,
        );
    }

    public function toEventArray(bool $isDraft = false): array
    {
        return [
            'organizer_id' => $this->organizerId,
            'title' => $this->title,
            'tagline' => $this->tagline,
            'description' => $this->description,
            'category_id' => $this->categoryId,
            'subcategory_id' => $this->subcategoryId,
            'event_type' => $this->eventType,
            'visibility' => $this->visibility,
            'approval_status' => $isDraft ? 'draft' : 'pending',
            'status' => $isDraft ? 'draft' : 'pending',
            'timezone' => 'Asia/Kolkata',
            'currency' => $this->currency,
            'budget_min' => $this->budgetMin,
            'budget_max' => $this->budgetMax,
            'sponsorship_type' => $this->sponsorshipType,
            'expected_audience' => $this->expectedAudience,
            'audience_description' => $this->audienceDescription,
            'registration_deadline' => $this->registrationDeadline,
            'website_url' => $this->websiteUrl,
            'video_url' => $this->videoUrl,
            'tags' => $this->tags,
            'is_published' => false,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'venue' => $this->venue,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ];
    }
}
