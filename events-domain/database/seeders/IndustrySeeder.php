<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndustrySeeder extends Seeder
{
    public function run(): void
    {
        $industries = [
            ['slug' => 'technology', 'label' => 'Technology'],
            ['slug' => 'finance', 'label' => 'Finance'],
            ['slug' => 'education', 'label' => 'Education'],
            ['slug' => 'health_fitness', 'label' => 'Health & Fitness'],
            ['slug' => 'entertainment', 'label' => 'Entertainment'],
            ['slug' => 'food_beverage', 'label' => 'Food & Beverage'],
            ['slug' => 'retail', 'label' => 'Retail'],
            ['slug' => 'real_estate', 'label' => 'Real Estate'],
            ['slug' => 'manufacturing', 'label' => 'Manufacturing'],
            ['slug' => 'automotive', 'label' => 'Automotive'],
            ['slug' => 'travel_tourism', 'label' => 'Travel & Tourism'],
            ['slug' => 'media', 'label' => 'Media'],
            ['slug' => 'sports', 'label' => 'Sports'],
            ['slug' => 'government', 'label' => 'Government'],
            ['slug' => 'nonprofit', 'label' => 'Non-Profit'],
        ];

        foreach ($industries as $industry) {
            DB::table('industries')->updateOrInsert(
                ['slug' => $industry['slug']],
                array_merge($industry, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
