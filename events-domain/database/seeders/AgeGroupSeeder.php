<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgeGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['slug' => 'below_18', 'label' => 'Below 18', 'sort_order' => 1],
            ['slug' => '18_24', 'label' => '18-24', 'sort_order' => 2],
            ['slug' => '25_34', 'label' => '25-34', 'sort_order' => 3],
            ['slug' => '35_44', 'label' => '35-44', 'sort_order' => 4],
            ['slug' => '45_54', 'label' => '45-54', 'sort_order' => 5],
            ['slug' => '55_plus', 'label' => '55+', 'sort_order' => 6],
        ];

        foreach ($groups as $group) {
            DB::table('age_groups')->updateOrInsert(
                ['slug' => $group['slug']],
                array_merge($group, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
