<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'slug' => 'basic',
                'name' => 'Basic',
                'price' => 999,
                'image_limit' => 3,
                'analytics_level' => 'basic',
                'featured_badge' => false,
                'priority_listing' => false,
                'social_promotion' => false,
                'homepage_featured' => false,
                'listing_duration_days' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'featured',
                'name' => 'Featured',
                'price' => 2999,
                'image_limit' => 5,
                'analytics_level' => 'advanced',
                'featured_badge' => true,
                'priority_listing' => true,
                'social_promotion' => false,
                'homepage_featured' => false,
                'listing_duration_days' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'homepage',
                'name' => 'Homepage',
                'price' => 4999,
                'image_limit' => 5,
                'analytics_level' => 'advanced',
                'featured_badge' => true,
                'priority_listing' => true,
                'social_promotion' => true,
                'homepage_featured' => true,
                'listing_duration_days' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($plans as $plan) {
            DB::table('plans')->updateOrInsert(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
