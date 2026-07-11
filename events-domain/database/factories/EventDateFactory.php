<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventDate;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventDateFactory extends Factory
{
    protected $model = EventDate::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('+1 month', '+6 months');

        return [
            'event_id' => Event::factory(),
            'label' => fake()->randomElement([null, 'Day 1', 'Day 2', 'Workshop', 'Main Event']),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => (clone $startDate)->format('Y-m-d'),
            'start_time' => fake()->randomElement([null, '09:00', '10:00', '14:00']),
            'end_time' => fake()->randomElement([null, '17:00', '18:00', '20:00']),
            'timezone' => 'Asia/Kolkata',
            'all_day' => fake()->boolean(20),
            'sort_order' => 0,
        ];
    }
}
