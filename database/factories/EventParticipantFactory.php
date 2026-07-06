<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Participant;
use App\Models\ParticipantType;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventParticipantFactory extends Factory
{
    protected $model = EventParticipant::class;

    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'participant_id' => Participant::factory(),
            'participant_type_id' => fn () => ParticipantType::first()?->id,
            'role_label' => fake()->randomElement(['Keynote Speaker', 'Panelist', 'Moderator', 'Performer', 'Workshop Lead']),
            'session_title' => fake()->sentence(4),
            'performance_start' => null,
            'performance_end' => null,
            'sort_order' => 0,
        ];
    }
}
