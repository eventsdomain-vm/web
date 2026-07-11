<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventTeam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventTeamFactory extends Factory
{
    protected $model = EventTeam::class;

    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'user_id' => User::factory(),
            'role' => fake()->randomElement(['coordinator', 'volunteer', 'manager', 'lead', 'member']),
        ];
    }
}
