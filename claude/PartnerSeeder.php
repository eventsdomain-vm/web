<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Industry;
use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        // Assumes IndustrySeeder / CategorySeeder have already run.
        $industryIds = Industry::pluck('id')->all();
        $categoryIds = Category::pluck('id')->all();

        if (empty($industryIds) || empty($categoryIds)) {
            $this->command->warn('Run IndustrySeeder and CategorySeeder first — partners need them to attach preferences.');
        }

        Partner::factory()
            ->count(30)
            ->create()
            ->each(function (Partner $partner) use ($industryIds, $categoryIds) {
                if (!empty($industryIds)) {
                    $partner->industries()->attach(
                        collect($industryIds)->random(min(3, count($industryIds)))
                    );
                }

                if (!empty($categoryIds)) {
                    $partner->categories()->attach(
                        collect($categoryIds)->random(min(2, count($categoryIds)))
                    );
                }

                // 1-3 preferred cities per partner, including their home city
                $cities = collect(['Mumbai', 'Delhi', 'Bengaluru', 'Hyderabad', 'Chennai', 'Pune'])
                    ->shuffle()
                    ->take(rand(1, 3))
                    ->push($partner->city)
                    ->unique();

                foreach ($cities as $city) {
                    $partner->preferredCities()->create(['city' => $city]);
                }
            });

        $this->command->info('Seeded 30 partners with industries, categories, and city preferences.');
    }
}
