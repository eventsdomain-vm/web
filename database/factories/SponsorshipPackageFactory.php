<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Event;
use App\Models\SponsorshipPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class SponsorshipPackageFactory extends Factory
{
    protected $model = SponsorshipPackage::class;

    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'title' => fake()->randomElement(['Gold', 'Silver', 'Platinum', 'Title', 'Associate']).' Sponsor',
            'description' => fake()->sentence(10),
            'price' => fake()->randomElement([25000, 50000, 100000, 250000, 500000]),
            'slots_available' => rand(1, 5),
            'slots_filled' => 0,
            'is_active' => true,
        ];
    }
}
