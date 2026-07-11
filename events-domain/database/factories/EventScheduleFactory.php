<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventScheduleFactory extends Factory
{
    protected $model = EventSchedule::class;

    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'event_date_id' => null,
            'stage_id' => null,
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'start_time' => fake()->time('H:i'),
            'end_time' => fake()->time('H:i'),
            'speaker' => fake()->name(),
            'venue' => fake()->city(),
            'sort_order' => 0,
        ];
    }
}
