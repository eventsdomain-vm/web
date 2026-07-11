<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AudienceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['slug' => 'students', 'label' => 'Students'],
            ['slug' => 'college_youth', 'label' => 'College Youth'],
            ['slug' => 'working_professionals', 'label' => 'Working Professionals'],
            ['slug' => 'entrepreneurs', 'label' => 'Entrepreneurs'],
            ['slug' => 'corporate_executives', 'label' => 'Corporate Executives'],
            ['slug' => 'government_officials', 'label' => 'Government Officials'],
            ['slug' => 'artists_creators', 'label' => 'Artists & Creators'],
            ['slug' => 'sports_enthusiasts', 'label' => 'Sports Enthusiasts'],
            ['slug' => 'tech_community', 'label' => 'Tech Community'],
            ['slug' => 'healthcare_professionals', 'label' => 'Healthcare Professionals'],
            ['slug' => 'educators', 'label' => 'Educators'],
            ['slug' => 'general_public', 'label' => 'General Public'],
        ];

        foreach ($types as $type) {
            DB::table('audience_types')->updateOrInsert(
                ['slug' => $type['slug']],
                array_merge($type, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
