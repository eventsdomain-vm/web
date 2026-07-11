<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            CategoryFieldDefinitionSeeder::class,
            ParticipantTypeSeeder::class,
            AmenitySeeder::class,
            PlatformSettingSeeder::class,
            CmsPageSeeder::class,
        ]);

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@eventsdomain.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('admin');

        // Create organizer user
        $organizer = User::factory()->create([
            'name' => 'Organizer',
            'email' => 'organizer@eventsdomain.com',
            'password' => bcrypt('password123'),
        ]);
        $organizer->assignRole('organizer');

        // Create sponsor user
        $sponsor = User::factory()->create([
            'name' => 'Sponsor',
            'email' => 'sponsor@eventsdomain.com',
            'password' => bcrypt('password123'),
        ]);
        $sponsor->assignRole('sponsor');

        // Create partner user
        $partner = User::factory()->create([
            'name' => 'Partner',
            'email' => 'partner@eventsdomain.com',
            'password' => bcrypt('password123'),
        ]);
        $partner->assignRole('partner');

        // Import events from sponsorshipsearch_data.json
        $this->call(EventImportSeeder::class);
    }
}
