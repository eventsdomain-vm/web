<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            ['name' => 'Parking', 'icon' => 'map-marker', 'group' => 'venue', 'sort_order' => 1],
            ['name' => 'Free WiFi', 'icon' => 'wifi', 'group' => 'connectivity', 'sort_order' => 2],
            ['name' => 'Wheelchair Access', 'icon' => 'accessibility', 'group' => 'accessibility', 'sort_order' => 3],
            ['name' => 'Air Conditioning', 'icon' => 'snowflake', 'group' => 'comfort', 'sort_order' => 4],
            ['name' => 'Food & Beverages', 'icon' => 'cup-soda', 'group' => 'catering', 'sort_order' => 5],
            ['name' => 'AV Equipment', 'icon' => 'speaker', 'group' => 'technical', 'sort_order' => 6],
            ['name' => 'Stage & Lighting', 'icon' => 'light-bulb', 'group' => 'technical', 'sort_order' => 7],
            ['name' => 'Restrooms', 'icon' => 'restroom', 'group' => 'venue', 'sort_order' => 8],
            ['name' => 'First Aid', 'icon' => 'medical-bag', 'group' => 'safety', 'sort_order' => 9],
            ['name' => 'Security', 'icon' => 'shield-check', 'group' => 'safety', 'sort_order' => 10],
            ['name' => 'Live Streaming', 'icon' => 'video-camera', 'group' => 'technical', 'sort_order' => 11],
            ['name' => 'Photography', 'icon' => 'camera', 'group' => 'media', 'sort_order' => 12],
            ['name' => 'Coat Check', 'icon' => 'collection', 'group' => 'venue', 'sort_order' => 13],
            ['name' => 'Kid Friendly', 'icon' => 'heart', 'group' => 'family', 'sort_order' => 14],
            ['name' => 'Pet Friendly', 'icon' => 'paw', 'group' => 'family', 'sort_order' => 15],
            ['name' => 'Power Outlets', 'icon' => 'plug', 'group' => 'connectivity', 'sort_order' => 16],
            ['name' => 'Green Room', 'icon' => 'door-open', 'group' => 'backstage', 'sort_order' => 17],
            ['name' => 'VIP Lounge', 'icon' => 'star', 'group' => 'hospitality', 'sort_order' => 18],
        ];

        foreach ($amenities as $amenity) {
            $amenity['slug'] = Str::slug($amenity['name']);
            Amenity::create($amenity);
        }
    }
}
