<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Business & Professional' => [
                'icon' => 'briefcase',
                'children' => [
                    'Conferences & Seminars',
                    'Workshops & Training',
                    'Networking Events',
                    'Trade Shows & Expos',
                    'Corporate Meetings',
                    'Product Launches',
                ],
            ],
            'Music & Entertainment' => [
                'icon' => 'musical-note',
                'children' => [
                    'Concerts & Live Shows',
                    'DJ Events & Club Nights',
                    'Festivals',
                    'Comedy Shows',
                    'Cultural Performances',
                    'Film Screenings',
                ],
            ],
            'Sports & Fitness' => [
                'icon' => 'trophy',
                'children' => [
                    'Marathons & Running',
                    'Tournaments & Leagues',
                    'Fitness & Wellness',
                    'Adventure & Outdoor',
                    'E-Sports & Gaming',
                    'Yoga & Meditation',
                ],
            ],
            'Food & Drink' => [
                'icon' => 'cake',
                'children' => [
                    'Food Festivals',
                    'Wine & Spirits Tasting',
                    'Cooking Classes',
                    'Restaurant Events',
                    'Street Food Markets',
                ],
            ],
            'Arts & Culture' => [
                'icon' => 'paint-brush',
                'children' => [
                    'Art Exhibitions',
                    'Photography Walks',
                    'Literary Events',
                    'Theater & Drama',
                    'Museum Events',
                    'Heritage & History',
                ],
            ],
            'Technology' => [
                'icon' => 'cpu',
                'children' => [
                    'Tech Conferences',
                    'Hackathons',
                    'Meetups & User Groups',
                    'Product Demos',
                    'AI & ML Events',
                    'Web3 & Blockchain',
                ],
            ],
            'Health & Wellness' => [
                'icon' => 'heart',
                'children' => [
                    'Health Seminars',
                    'Mental Health Workshops',
                    'Medical Conferences',
                    'Wellness Retreats',
                    'Nutrition & Diet',
                ],
            ],
            'Education' => [
                'icon' => 'academic-cap',
                'children' => [
                    'Seminars & Lectures',
                    'Career Fairs',
                    'Student Events',
                    'Online Courses',
                    'Certification Programs',
                ],
            ],
            'Community & Social' => [
                'icon' => 'users',
                'children' => [
                    'Meetups',
                    'Charity & Fundraising',
                    'Social Gatherings',
                    'Volunteer Events',
                    'Neighborhood Events',
                ],
            ],
            'Festivals & Fairs' => [
                'icon' => 'sparkles',
                'children' => [
                    'Cultural Festivals',
                    'Seasonal Fairs',
                    'Carnivals',
                    'Religious Events',
                    'Holiday Celebrations',
                ],
            ],
        ];

        $sortOrder = 0;

        foreach ($categories as $name => $data) {
            $parent = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'icon' => $data['icon'],
                'sort_order' => $sortOrder++,
                'is_active' => true,
            ]);

            $childSort = 0;
            foreach ($data['children'] as $childName) {
                Category::create([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'parent_id' => $parent->id,
                    'sort_order' => $childSort++,
                    'is_active' => true,
                ]);
            }
        }
    }
}
