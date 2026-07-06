<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipantFactory extends Factory
{
    protected $model = Participant::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'slug' => fake()->unique()->slug(),
            'type' => fake()->randomElement(['speaker', 'panelist', 'performer', 'moderator']),
            'bio' => fake()->paragraph(),
            'organization' => fake()->company(),
            'designation' => fake()->jobTitle(),
            'website' => fake()->url(),
            'social_links' => ['twitter' => fake()->url()],
        ];
    }
}
