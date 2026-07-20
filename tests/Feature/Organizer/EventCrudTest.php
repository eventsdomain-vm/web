<?php

declare(strict_types=1);

namespace Tests\Feature\Organizer;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $organizer;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles
        \Artisan::call('db:seed', ['--class' => RoleSeeder::class]);

        $this->organizer = User::factory()->create();
        $this->organizer->assignRole('organizer');

        $this->category = Category::factory()->create();
    }

    public function test_organizer_can_view_create_form(): void
    {
        $response = $this->actingAs($this->organizer)->get(route('organizer.events.create'));

        $response->assertStatus(200);
        $response->assertSee('List Your Event for Sponsorship');
        $response->assertSee('Basic Info');
        $response->assertSee('Location');
        $response->assertSee('Sponsorship');
    }

    public function test_organizer_can_store_event_with_minimal_data(): void
    {
        $data = [
            'title' => 'Tech Conference 2026',
            'description' => 'A great tech conference',
            'category_id' => $this->category->id,
            'event_type' => 'physical',
            'start_date' => now()->addMonth()->format('Y-m-d'),
            'end_date' => now()->addMonth()->addDays(2)->format('Y-m-d'),
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'country' => 'India',
            'expected_audience' => 500,
            'plan' => 'basic',
        ];

        $response = $this->actingAs($this->organizer)->post(route('organizer.events.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('events', [
            'title' => 'Tech Conference 2026',
            'organizer_id' => $this->organizer->id,
            'status' => 'pending',
        ]);
    }

    public function test_organizer_can_store_event_with_dates_and_venues(): void
    {
        $data = [
            'title' => 'Multi-Day Summit',
            'description' => 'A multi-day event',
            'category_id' => $this->category->id,
            'event_type' => 'hybrid',
            'start_date' => now()->addMonth()->format('Y-m-d'),
            'end_date' => now()->addMonth()->addDays(3)->format('Y-m-d'),
            'city' => 'Delhi',
            'state' => 'Delhi',
            'country' => 'India',
            'expected_audience' => 2000,
            'plan' => 'featured',
            'dates' => [
                ['label' => 'Day 1', 'start_date' => now()->addMonth()->format('Y-m-d'), 'start_time' => '09:00', 'end_time' => '18:00'],
                ['label' => 'Day 2', 'start_date' => now()->addMonth()->addDay()->format('Y-m-d'), 'start_time' => '09:00', 'end_time' => '18:00'],
            ],
            'venues' => [
                ['venue_type' => 'physical', 'venue_name' => 'Pragati Maidan', 'city' => 'Delhi', 'country' => 'India', 'is_primary' => '1'],
                ['venue_type' => 'virtual', 'venue_name' => 'Zoom Session', 'virtual_url' => 'https://zoom.us/j/123', 'virtual_platform' => 'zoom'],
            ],
        ];

        $response = $this->actingAs($this->organizer)->post(route('organizer.events.store'), $data);

        $response->assertRedirect();

        $event = Event::where('title', 'Multi-Day Summit')->first();
        $this->assertNotNull($event);
        $this->assertCount(2, $event->dates);
        $this->assertCount(2, $event->venues);
        $this->assertEquals('Pragati Maidan', $event->venues->sortBy('id')->first()->venue_name);
        $this->assertEquals('Zoom Session', $event->venues->sortBy('id')->last()->venue_name);
    }

    public function test_organizer_can_store_event_with_packages(): void
    {
        $data = [
            'title' => 'Sponsorship Event',
            'description' => 'Event with packages',
            'category_id' => $this->category->id,
            'event_type' => 'physical',
            'start_date' => now()->addMonth()->format('Y-m-d'),
            'end_date' => now()->addMonth()->format('Y-m-d'),
            'city' => 'Bangalore',
            'state' => 'Karnataka',
            'country' => 'India',
            'plan' => 'basic',
            'packages' => [
                ['name' => 'Gold Sponsor', 'price' => 100000, 'description' => 'Gold tier', 'benefits' => "Logo on website\nBooth space\nSpeaking slot"],
                ['name' => 'Silver Sponsor', 'price' => 50000, 'description' => 'Silver tier', 'benefits' => "Logo on website\nBooth space"],
            ],
        ];

        $response = $this->actingAs($this->organizer)->post(route('organizer.events.store'), $data);

        $response->assertRedirect();

        $event = Event::where('title', 'Sponsorship Event')->first();
        $this->assertNotNull($event);
        $this->assertCount(2, $event->packages);

        $goldPkg = $event->packages->first();
        $this->assertEquals('Gold Sponsor', $goldPkg->title);
        $this->assertEquals(100000, $goldPkg->price);
        $goldPkg->load('benefitRecords');
        $this->assertCount(3, $goldPkg->benefitRecords);
    }

    public function test_organizer_can_view_event(): void
    {
        $event = Event::factory()->create([
            'organizer_id' => $this->organizer->id,
            'status' => 'live',
            'approval_status' => 'approved',
        ]);

        $response = $this->actingAs($this->organizer)->get(route('organizer.events.show', $event->id));

        $response->assertStatus(200);
        $response->assertSee($event->title);
    }

    public function test_organizer_cannot_view_other_organizers_event(): void
    {
        $otherOrganizer = User::factory()->create();
        $otherOrganizer->assignRole('organizer');

        $event = Event::factory()->create([
            'organizer_id' => $otherOrganizer->id,
            'status' => 'live',
            'approval_status' => 'approved',
        ]);

        $response = $this->actingAs($this->organizer)->get(route('organizer.events.show', $event->id));

        $response->assertStatus(403);
    }

    public function test_organizer_can_delete_draft_event(): void
    {
        $event = Event::factory()->draft()->create([
            'organizer_id' => $this->organizer->id,
        ]);

        $response = $this->actingAs($this->organizer)->delete(route('organizer.events.destroy', $event->id));

        $response->assertRedirect();
        $this->assertSoftDeleted('events', ['id' => $event->id]);
    }
}
