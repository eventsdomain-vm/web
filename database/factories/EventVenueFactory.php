<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventVenue;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventVenueFactory extends Factory
{
    protected $model = EventVenue::class;

    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'venue_type' => 'physical',
            'venue_name' => fake()->company().' Convention Center',
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => 'India',
            'postal_code' => fake()->numerify('######'),
            'latitude' => fake()->latitude(8, 37),
            'longitude' => fake()->longitude(68, 97),
            'virtual_url' => null,
            'virtual_platform' => null,
            'is_primary' => true,
            'sort_order' => 0,
        ];
    }

    public function virtual(): static
    {
        return $this->state(fn () => [
            'venue_type' => 'virtual',
            'venue_name' => fake()->randomElement(['Zoom', 'Microsoft Teams', 'Google Meet']).' Session',
            'address' => null,
            'city' => null,
            'state' => null,
            'country' => null,
            'latitude' => null,
            'longitude' => null,
            'virtual_url' => fake()->url(),
            'virtual_platform' => fake()->randomElement(['zoom', 'teams', 'meet']),
        ]);
    }
}
