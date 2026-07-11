<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);
        $startDate = fake()->dateTimeBetween('+1 month', '+6 months');
        $endDate = (clone $startDate)->modify('+'.rand(1, 3).' days');

        return [
            'organizer_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'tagline' => fake()->sentence(6),
            'description' => fake()->paragraphs(3, true),
            'category_id' => fn () => Category::whereNull('parent_id')->first()?->id ?? Category::factory(),
            'subcategory_id' => null,
            'event_type' => fake()->randomElement(['physical', 'virtual', 'hybrid']),
            'visibility' => 'public',
            'approval_status' => 'pending',
            'status' => 'draft',
            'timezone' => 'Asia/Kolkata',
            'currency' => 'INR',
            'budget_min' => fake()->randomElement([null, 50000, 100000]),
            'budget_max' => fn (array $attr) => $attr['budget_min'] ? $attr['budget_min'] * rand(2, 5) : null,
            'sponsorship_type' => fake()->randomElement(['paid', 'barter', 'hybrid']),
            'expected_audience' => fake()->randomElement([100, 500, 1000, 5000, 10000]),
            'audience_description' => fake()->sentence(10),
            'website_url' => fake()->url(),
            'video_url' => null,
            'tags' => fake()->randomElements(['tech', 'startup', 'networking', 'conference', 'workshop'], 2),
            'is_featured' => false,
            'is_published' => false,
            'views_count' => 0,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'venue' => fake()->city(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => 'India',
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'approval_status' => 'approved',
            'is_published' => true,
            'status' => 'live',
            'published_at' => now(),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => 'draft',
            'approval_status' => 'pending',
        ]);
    }
}
