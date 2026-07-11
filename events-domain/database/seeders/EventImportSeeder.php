<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Services\EventImportService;
use Illuminate\Database\Seeder;

class EventImportSeeder extends Seeder
{
    public function run(): void
    {
        $importer = app(EventImportService::class);
        $stats = $importer->import();

        // Assign 5 events to the demo organizer so dashboard has data
        $demoOrganizer = User::where('email', 'organizer@eventsdomain.com')->first();
        if ($demoOrganizer) {
            Event::where('organizer_id', '!=', $demoOrganizer->id)
                ->take(5)
                ->update(['organizer_id' => $demoOrganizer->id]);
        }

        $this->command->info("Events imported: {$stats['events_created']}");
        $this->command->info("Packages created: {$stats['packages_created']}");
        $this->command->info("Organizers created: {$stats['organizers_created']}");
        $this->command->info("Categories created: {$stats['categories_created']}");
        $this->command->info("Skipped (duplicates/errors): {$stats['skipped']}");
    }
}
