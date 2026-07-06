<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ParticipantType;
use Illuminate\Database\Seeder;

class ParticipantTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Speaker', 'slug' => 'speaker', 'sort_order' => 1],
            ['name' => 'Panelist', 'slug' => 'panelist', 'sort_order' => 2],
            ['name' => 'Artist / Performer', 'slug' => 'artist', 'sort_order' => 3],
            ['name' => 'DJ', 'slug' => 'dj', 'sort_order' => 4],
            ['name' => 'Moderator', 'slug' => 'moderator', 'sort_order' => 5],
            ['name' => 'Organizer', 'slug' => 'organizer', 'sort_order' => 6],
            ['name' => 'Volunteer', 'slug' => 'volunteer', 'sort_order' => 7],
            ['name' => 'Sponsor Representative', 'slug' => 'sponsor-representative', 'sort_order' => 8],
            ['name' => 'Team Member', 'slug' => 'team-member', 'sort_order' => 9],
            ['name' => 'Judge', 'slug' => 'judge', 'sort_order' => 10],
            ['name' => 'Mentor', 'slug' => 'mentor', 'sort_order' => 11],
            ['name' => 'Attendee VIP', 'slug' => 'attendee-vip', 'sort_order' => 12],
        ];

        foreach ($types as $type) {
            ParticipantType::create($type);
        }
    }
}
