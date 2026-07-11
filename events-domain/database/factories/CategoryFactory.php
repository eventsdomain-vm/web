<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'slug' => fake()->unique()->slug(),
            'parent_id' => null,
        ];
    }

    public function child(): static
    {
        return $this->state(fn () => [
            'parent_id' => Category::whereNull('parent_id')->first()?->id ?? Category::factory(),
        ]);
    }
}
