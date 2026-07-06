<?php

declare(strict_types=1);

namespace App\DTOs;

final class EventUpdateData
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $tagline,
        public readonly ?string $description,
        public readonly ?int $categoryId,
        public readonly ?int $subcategoryId,
        public readonly ?string $eventType,
        public readonly ?string $visibility,
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
        public readonly ?string $sponsorshipType,
        public readonly ?string $currency,
        public readonly ?string $websiteUrl,
        public readonly ?string $videoUrl,
        public readonly ?array $tags,
    ) {}

    public static function fromRequest(array $data): self
    {
        $tags = null;
        if (array_key_exists('tags', $data)) {
            if (! empty($data['tags'])) {
                $raw = is_string($data['tags']) ? explode("\n", $data['tags']) : $data['tags'];
                $tags = array_values(array_filter(array_map('trim', $raw), fn ($t) => ! empty($t) && strlen($t) <= 100));
            } else {
                $tags = [];
            }
        }

        return new self(
            title: $data['title'] ?? null,
            tagline: $data['tagline'] ?? null,
            description: $data['description'] ?? null,
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null,
            subcategoryId: ! empty($data['subcategory_id']) ? (int) $data['subcategory_id'] : null,
            eventType: $data['event_type'] ?? null,
            visibility: $data['visibility'] ?? null,
            venue: $data['venue'] ?? null,
            address: $data['address'] ?? null,
            city: $data['city'] ?? null,
            state: $data['state'] ?? null,
            country: $data['country'] ?? null,
            startDate: $data['start_date'] ?? null,
            endDate: $data['end_date'] ?? null,
            registrationDeadline: $data['registration_deadline'] ?? null,
            expectedAudience: isset($data['expected_audience']) ? (int) $data['expected_audience'] : null,
            audienceDescription: $data['audience_description'] ?? null,
            budgetMin: isset($data['budget_min']) ? (float) $data['budget_min'] : null,
            budgetMax: isset($data['budget_max']) ? (float) $data['budget_max'] : null,
            sponsorshipType: $data['sponsorship_type'] ?? null,
            currency: $data['currency'] ?? null,
            websiteUrl: $data['website_url'] ?? null,
            videoUrl: $data['video_url'] ?? null,
            tags: $tags,
        );
    }

    public function toUpdateArray(): array
    {
        $payload = array_filter([
            'title' => $this->title,
            'tagline' => $this->tagline,
            'description' => $this->description,
            'category_id' => $this->categoryId,
            'subcategory_id' => $this->subcategoryId,
            'event_type' => $this->eventType,
            'visibility' => $this->visibility,
            'venue' => $this->venue,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'registration_deadline' => $this->registrationDeadline,
            'expected_audience' => $this->expectedAudience,
            'audience_description' => $this->audienceDescription,
            'budget_min' => $this->budgetMin,
            'budget_max' => $this->budgetMax,
            'sponsorship_type' => $this->sponsorshipType,
            'currency' => $this->currency,
            'website_url' => $this->websiteUrl,
            'video_url' => $this->videoUrl,
            'tags' => $this->tags,
        ], fn ($v) => $v !== null);

        return $payload;
    }
}
