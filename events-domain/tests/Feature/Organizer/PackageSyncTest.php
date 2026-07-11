<?php

declare(strict_types=1);

namespace Tests\Feature\Organizer;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackageSyncTest extends TestCase
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

    public function test_packages_are_created_on_store(): void
    {
        $data = [
            'title' => 'Event With Packages',
            'description' => 'Test packages',
            'category_id' => $this->category->id,
            'event_type' => 'physical',
            'start_date' => now()->addMonth()->format('Y-m-d'),
            'end_date' => now()->addMonth()->format('Y-m-d'),
            'city' => 'Mumbai',
            'plan' => 'basic',
            'packages' => [
                ['name' => 'Platinum', 'price' => 500000, 'description' => 'Top tier', 'benefits' => "All benefits\nVIP access\nKeynote slot"],
                ['name' => 'Gold', 'price' => 200000, 'description' => 'Mid tier', 'benefits' => "Logo placement\nBooth"],
                ['name' => 'Silver', 'price' => 100000, 'description' => 'Base tier'],
            ],
        ];

        $response = $this->actingAs($this->organizer)->post(route('organizer.events.store'), $data);

        $response->assertRedirect();

        $event = Event::where('title', 'Event With Packages')->first();
        $this->assertNotNull($event);
        $this->assertCount(3, $event->packages);

        $event->load('packages.benefitRecords');

        $platinum = $event->packages->where('title', 'Platinum')->first();
        $this->assertNotNull($platinum);
        $this->assertCount(3, $platinum->benefitRecords);

        $gold = $event->packages->where('title', 'Gold')->first();
        $this->assertCount(2, $gold->benefitRecords);

        $silver = $event->packages->where('title', 'Silver')->first();
        $this->assertCount(0, $silver->benefitRecords);
    }

    public function test_empty_packages_are_skipped(): void
    {
        $data = [
            'title' => 'Event Empty Packages',
            'description' => 'Test',
            'category_id' => $this->category->id,
            'event_type' => 'virtual',
            'start_date' => now()->addMonth()->format('Y-m-d'),
            'end_date' => now()->addMonth()->format('Y-m-d'),
            'plan' => 'basic',
            'packages' => [
                ['name' => '', 'price' => 0],
                ['name' => 'Valid Package', 'price' => 50000],
            ],
        ];

        $response = $this->actingAs($this->organizer)->post(route('organizer.events.store'), $data);

        $event = Event::where('title', 'Event Empty Packages')->first();
        $this->assertCount(1, $event->packages);
        $this->assertEquals('Valid Package', $event->packages->first()->title);
    }

    public function test_draft_save_includes_packages(): void
    {
        $data = [
            'title' => 'Draft With Packages',
            'description' => 'Test',
            'category_id' => $this->category->id,
            'event_type' => 'physical',
            'packages' => [
                ['name' => 'Early Bird', 'price' => 25000, 'benefits' => "Discounted rate\nNetworking"],
            ],
        ];

        $response = $this->actingAs($this->organizer)->postJson(route('organizer.events.saveDraft'), $data);

        $response->assertJson(['success' => true]);

        $event = Event::find($response->json('event_id'));
        $event->load('packages.benefitRecords');
        $this->assertCount(1, $event->packages);
        $this->assertEquals('Early Bird', $event->packages->first()->title);

        $benefits = $event->packages->first()->benefitRecords;
        $this->assertCount(2, $benefits);
    }

    public function test_package_benefits_are_string_array(): void
    {
        $data = [
            'title' => 'Benefits Test',
            'description' => 'Test benefits parsing',
            'category_id' => $this->category->id,
            'event_type' => 'virtual',
            'start_date' => now()->addMonth()->format('Y-m-d'),
            'end_date' => now()->addMonth()->format('Y-m-d'),
            'plan' => 'basic',
            'packages' => [
                [
                    'name' => 'VIP',
                    'price' => 100000,
                    'benefits' => "Benefit 1\nBenefit 2\nBenefit 3\n",
                ],
            ],
        ];

        $response = $this->actingAs($this->organizer)->post(route('organizer.events.store'), $data);

        $event = Event::where('title', 'Benefits Test')->first();
        $event->load('packages.benefitRecords');
        $benefits = $event->packages->first()->benefitRecords->pluck('benefit_text')->toArray();

        $this->assertEquals(['Benefit 1', 'Benefit 2', 'Benefit 3'], $benefits);
    }
}
