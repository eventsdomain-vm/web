<?php

declare(strict_types=1);

namespace Tests\Feature\Organizer;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DraftSaveTest extends TestCase
{
    use RefreshDatabase;

    private User $organizer;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        \Artisan::call('db:seed', ['--class' => RoleSeeder::class]);

        $this->organizer = User::factory()->create();
        $this->organizer->assignRole('organizer');

        $this->category = Category::factory()->create();
    }

    public function test_organizer_can_save_draft(): void
    {
        $data = [
            'title' => 'Draft Event',
            'description' => 'This is a draft',
            'category_id' => $this->category->id,
            'event_type' => 'virtual',
        ];

        $response = $this->actingAs($this->organizer)->postJson(route('organizer.events.saveDraft'), $data);

        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['event_id']);

        $eventId = $response->json('event_id');
        $this->assertDatabaseHas('events', [
            'id' => $eventId,
            'status' => 'draft',
            'title' => 'Draft Event',
        ]);
    }

    public function test_organizer_can_save_draft_with_dates(): void
    {
        $data = [
            'title' => 'Draft With Dates',
            'description' => 'Draft event with date sessions',
            'category_id' => $this->category->id,
            'event_type' => 'physical',
            'dates' => [
                ['label' => 'Workshop', 'start_date' => now()->addWeek()->format('Y-m-d'), 'start_time' => '10:00', 'end_time' => '16:00'],
            ],
        ];

        $response = $this->actingAs($this->organizer)->postJson(route('organizer.events.saveDraft'), $data);

        $response->assertJson(['success' => true]);

        $event = Event::find($response->json('event_id'));
        $this->assertCount(1, $event->dates);
        $this->assertEquals('Workshop', $event->dates->first()->label);
    }

    public function test_organizer_can_save_draft_with_venues(): void
    {
        $data = [
            'title' => 'Draft With Venues',
            'description' => 'Draft event with venues',
            'category_id' => $this->category->id,
            'event_type' => 'hybrid',
            'venues' => [
                ['venue_type' => 'physical', 'venue_name' => 'Convention Center', 'city' => 'Mumbai', 'country' => 'India', 'is_primary' => '1'],
                ['venue_type' => 'virtual', 'virtual_url' => 'https://zoom.us/j/456', 'virtual_platform' => 'zoom'],
            ],
        ];

        $response = $this->actingAs($this->organizer)->postJson(route('organizer.events.saveDraft'), $data);

        $response->assertJson(['success' => true]);

        $event = Event::find($response->json('event_id'));
        $this->assertCount(2, $event->venues);
    }

    public function test_organizer_can_load_draft(): void
    {
        $event = Event::factory()->draft()->create([
            'organizer_id' => $this->organizer->id,
            'title' => 'Existing Draft',
        ]);

        $response = $this->actingAs($this->organizer)->getJson(route('organizer.events.loadDraft'));

        $response->assertJson(['success' => true]);
        $response->assertJson(['data' => ['title' => 'Existing Draft']]);
    }

    public function test_organizer_load_draft_returns_404_when_no_draft(): void
    {
        $response = $this->actingAs($this->organizer)->getJson(route('organizer.events.loadDraft'));

        $response->assertStatus(404);
    }

    public function test_organizer_can_discard_draft(): void
    {
        $event = Event::factory()->draft()->create([
            'organizer_id' => $this->organizer->id,
        ]);

        $response = $this->actingAs($this->organizer)->deleteJson(
            route('organizer.events.discardDraft', $event->id)
        );

        $response->assertJson(['success' => true]);
        $this->assertSoftDeleted('events', ['id' => $event->id]);
    }

    public function test_organizer_cannot_discard别人的_draft(): void
    {
        $other = User::factory()->create();
        $other->assignRole('organizer');

        $event = Event::factory()->draft()->create([
            'organizer_id' => $other->id,
        ]);

        $response = $this->actingAs($this->organizer)->deleteJson(
            route('organizer.events.discardDraft', $event->id)
        );

        $response->assertStatus(404);
        $this->assertDatabaseHas('events', ['id' => $event->id]);
    }
}
