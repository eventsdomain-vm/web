# EventsDomain — Backend Implementation Plan

> Detailed backend implementation guide. Read `project.md` and `00-project-overview.md` first.

---

## 1. Backend Stack

| Layer | Technology | Purpose |
|---|---|---|
| **Framework** | Laravel 12 | MVC framework |
| **PHP** | 8.2+ | Strict types enabled |
| **ORM** | Eloquent | Database abstraction |
| **Auth** | Laravel Breeze + Sanctum | Authentication |
| **Permissions** | Spatie Permission | Role-based access |
| **Search** | MySQL FULLTEXT + Scout | Discovery |
| **Queue** | Laravel Queue | Async jobs |
| **Mail** | Laravel Mail | Email notifications |
| **Real-time** | Laravel Reverb | WebSocket messaging |

---

## 2. Service Layer Architecture

### 2.1 Service Directory Structure

```
app/Services/
├── Auth/
│   ├── OtpService.php
│   ├── SmsService.php
│   ├── WhatsAppService.php
│   └── EmailVerificationService.php
├── Event/
│   ├── EventService.php
│   ├── EventGalleryService.php
│   ├── EventScheduleService.php
│   └── EventAnalyticsService.php
├── Sponsorship/
│   ├── PackageService.php
│   ├── EnquiryService.php
│   ├── ContractService.php
│   └── RoiService.php
├── Partner/
│   ├── PartnerService.php
│   ├── ServiceService.php
│   ├── BidService.php
│   ├── ContractService.php
│   └── PortfolioService.php
├── Communication/
│   ├── MessageService.php
│   ├── NotificationService.php
│   └── ConversationService.php
├── Search/
│   ├── SeoSearchService.php
│   ├── AiSearchService.php
│   └── RankingService.php
├── SocialMedia/
│   ├── SocialMediaServiceInterface.php
│   ├── LinkedInService.php
│   ├── FacebookService.php
│   ├── InstagramService.php
│   └── YouTubeService.php
├── Cms/
│   ├── PageService.php
│   └── SettingService.php
└── Analytics/
    ├── DashboardService.php
    └── ReportService.php
```

### 2.2 Service Implementation Pattern

```php
<?php

declare(strict_types=1);

namespace App\Services\Event;

use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class EventService
{
    public function __construct(
        private EventGalleryService $galleryService,
        private EventScheduleService $scheduleService,
    ) {}

    public function create(array $data, User $organizer): Event
    {
        return DB::transaction(function () use ($data, $organizer) {
            $event = Event::create([
                'organizer_id' => $organizer->id,
                'title' => $data['title'],
                'slug' => $this->generateSlug($data['title']),
                'description' => $data['description'],
                'category_id' => $data['category_id'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'] ?? null,
                'location_type' => $data['location_type'],
                'location' => $data['location'] ?? null,
                'city' => $data['city'] ?? null,
                'state' => $data['state'] ?? null,
                'country' => $data['country'] ?? null,
                'expected_audience' => $data['expected_audience'] ?? null,
                'budget_min' => $data['budget_min'] ?? null,
                'budget_max' => $data['budget_max'] ?? null,
                'sponsorship_type' => $data['sponsorship_type'] ?? 'paid',
                'tags' => $data['tags'] ?? [],
                'status' => 'draft',
            ]);

            // Handle gallery if provided
            if (isset($data['gallery'])) {
                $this->galleryService->store($event, $data['gallery']);
            }

            // Handle schedule if provided
            if (isset($data['schedule'])) {
                $this->scheduleService->store($event, $data['schedule']);
            }

            // Invalidate cache
            Cache::forget('events_home');
            Cache::forget("organizer_events_{$organizer->id}");

            return $event;
        });
    }

    public function update(Event $event, array $data): Event
    {
        return DB::transaction(function () use ($event, $data) {
            $event->update($data);

            if (isset($data['gallery'])) {
                $this->galleryService->sync($event, $data['gallery']);
            }

            if (isset($data['schedule'])) {
                $this->scheduleService->sync($event, $data['schedule']);
            }

            Cache::forget("event_{$event->id}");
            Cache::forget('events_home');

            return $event;
        });
    }

    public function publish(Event $event): Event
    {
        $event->update(['status' => 'pending']);
        // Admin approval required
        return $event;
    }

    public function approve(Event $event): Event
    {
        $event->update(['status' => 'published']);
        Cache::forget('events_home');
        return $event;
    }

    public function getPublishedEvents(array $filters = [])
    {
        return Cache::remember('events_home', 300, function () use ($filters) {
            return Event::with(['organizer', 'category'])
                ->where('status', 'published')
                ->when($filters['category'] ?? null, fn($q, $cat) => $q->where('category_id', $cat))
                ->when($filters['city'] ?? null, fn($q, $city) => $q->where('city', $city))
                ->when($filters['budget_min'] ?? null, fn($q, $min) => $q->where('budget_min', '>=', $min))
                ->when($filters['budget_max'] ?? null, fn($q, $max) => $q->where('budget_max', '<=', $max))
                ->latest()
                ->paginate(15);
        });
    }

    private function generateSlug(string $title): string
    {
        $slug = \Illuminate\Support\Str::slug($title);
        $count = Event::where('slug', 'like', "{$slug}%")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }
}
```

---

## 3. Controller Implementation

### 3.1 Controller Directory Structure

```
app/Http/Controllers/
├── Auth/
│   ├── LoginController.php
│   ├── RegisterController.php
│   ├── PasswordResetController.php
│   └── VerificationController.php
├── Public/
│   ├── PublicController.php
│   ├── EventController.php
│   ├── CategoryController.php
│   ├── BlogController.php
│   ├── PageController.php
│   └── RoiCalculatorController.php
├── Organizer/
│   ├── OrganizerDashboardController.php
│   ├── OrganizerEventController.php
│   ├── OrganizerPackageController.php
│   ├── OrganizerSponsorController.php
│   ├── OrganizerPartnerController.php
│   ├── OrganizerScheduleController.php
│   ├── OrganizerGalleryController.php
│   ├── OrganizerAnalyticsController.php
│   ├── OrganizerMessageController.php
│   ├── OrganizerNotificationController.php
│   ├── OrganizerTeamController.php
│   ├── OrganizerProfileController.php
│   └── OrganizerSettingsController.php
├── Sponsor/
│   ├── SponsorDashboardController.php
│   ├── SponsorDiscoverController.php
│   ├── SponsorSavedController.php
│   ├── SponsorEnquiryController.php
│   ├── SponsorSponsoredController.php
│   ├── SponsorMessageController.php
│   ├── SponsorNotificationController.php
│   ├── SponsorProfileController.php
│   └── SponsorSettingsController.php
├── Partner/
│   ├── PartnerDashboardController.php
│   ├── PartnerServiceController.php
│   ├── PartnerOpportunityController.php
│   ├── PartnerContractController.php
│   ├── PartnerAvailabilityController.php
│   ├── PartnerPortfolioController.php
│   ├── PartnerReviewController.php
│   ├── PartnerMessageController.php
│   ├── PartnerNotificationController.php
│   ├── PartnerProfileController.php
│   └── PartnerSettingsController.php
├── Admin/
│   ├── AdminDashboardController.php
│   ├── AdminEventController.php
│   ├── AdminUserController.php
│   ├── AdminCategoryController.php
│   ├── AdminSponsorshipController.php
│   ├── AdminPartnerController.php
│   ├── AdminReportController.php
│   ├── AdminCmsController.php
│   ├── AdminRoleController.php
│   ├── AdminSettingController.php
│   └── AdminLogController.php
└── Api/
    ├── MessageController.php
    ├── UploadController.php
    ├── EnquiryController.php
    ├── SearchController.php
    ├── FilterController.php
    └── RoiController.php
```

### 3.2 Controller Implementation Pattern

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organizer\StoreEventRequest;
use App\Http\Requests\Organizer\UpdateEventRequest;
use App\Services\Event\EventService;
use App\Models\Event;
use Illuminate\Http\Request;

class OrganizerEventController extends Controller
{
    public function __construct(
        private EventService $eventService
    ) {}

    public function index(Request $request)
    {
        $events = auth()->user()->events()
            ->with('category')
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(15);

        return view('organizer.events.index', compact('events'));
    }

    public function create()
    {
        $categories = \App\Models\Category::where('is_active', true)->get();

        return view('organizer.events.create', compact('categories'));
    }

    public function store(StoreEventRequest $request)
    {
        $event = $this->eventService->create(
            $request->validated(),
            auth()->user()
        );

        return redirect()->route('organizer.events.show', $event)
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $this->authorize('view', $event);

        $event->load(['packages.benefits', 'gallery', 'schedule', 'sponsors', 'partners']);

        return view('organizer.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        $categories = \App\Models\Category::where('is_active', true)->get();

        return view('organizer.events.edit', compact('event', 'categories'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        $this->eventService->update($event, $request->validated());

        return redirect()->route('organizer.events.show', $event)
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('organizer.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function publish(Event $event)
    {
        $this->authorize('update', $event);

        $this->eventService->publish($event);

        return redirect()->route('organizer.events.show', $event)
            ->with('success', 'Event submitted for approval.');
    }
}
```

---

## 4. Form Request Validation

### 4.1 Form Request Directory Structure

```
app/Http/Requests/
├── Auth/
│   ├── LoginRequest.php
│   └── RegisterRequest.php
├── Organizer/
│   ├── StoreEventRequest.php
│   ├── UpdateEventRequest.php
│   ├── StorePackageRequest.php
│   └── UpdatePackageRequest.php
├── Sponsor/
│   ├── SendEnquiryRequest.php
│   └── UpdateProfileRequest.php
├── Partner/
│   ├── StoreServiceRequest.php
│   ├── UpdateServiceRequest.php
│   └── BidRequest.php
└── Admin/
    ├── StoreCategoryRequest.php
    └── UpdateCategoryRequest.php
```

### 4.2 Form Request Implementation

```php
<?php

declare(strict_types=1);

namespace App\Http\Requests\Organizer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('organizer');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'start_date' => ['required', 'date', 'after:now'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'location_type' => ['required', Rule::in(['physical', 'virtual', 'hybrid'])],
            'location' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'expected_audience' => ['nullable', 'integer', 'min:1'],
            'budget_min' => ['nullable', 'numeric', 'min:0'],
            'budget_max' => ['nullable', 'numeric', 'min:0', 'gte:budget_min'],
            'sponsorship_type' => ['nullable', Rule::in(['paid', 'barter', 'hybrid'])],
            'tags' => ['nullable', 'array', 'max:5'],
            'tags.*' => ['string', 'max:50'],
            'gallery' => ['nullable', 'array', 'max:10'],
            'gallery.*' => ['image', 'mimes:jpeg,png,webp', 'max:2048'],
            'schedule' => ['nullable', 'array'],
            'schedule.*.title' => ['required_with:schedule', 'string', 'max:255'],
            'schedule.*.start_time' => ['required_with:schedule', 'date_format:H:i'],
            'schedule.*.end_time' => ['required_with:schedule', 'date_format:H:i', 'after:schedule.*.start_time'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter an event title.',
            'description.required' => 'Please provide an event description.',
            'category_id.required' => 'Please select a category.',
            'start_date.required' => 'Please select a start date.',
            'start_date.after' => 'Event must be in the future.',
            'budget_max.gte' => 'Maximum budget must be greater than minimum.',
        ];
    }
}
```

---

## 5. Policy Implementation

### 5.1 Policy Directory Structure

```
app/Policies/
├── EventPolicy.php
├── SponsorshipPackagePolicy.php
├── PartnerServicePolicy.php
├── ConversationPolicy.php
├── MessagePolicy.php
└── UserProfilePolicy.php
```

### 5.2 Policy Implementation

```php
<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Public listing
    }

    public function view(User $user, Event $event): bool
    {
        if ($event->status === 'published') {
            return true;
        }

        return $user->id === $event->organizer_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('organizer');
    }

    public function update(User $user, Event $event): bool
    {
        return $user->id === $event->organizer_id;
    }

    public function delete(User $user, Event $event): bool
    {
        if ($user->id !== $event->organizer_id) {
            return false;
        }

        // Can't delete if there are active sponsorships
        return !$event->sponsorships()->where('status', 'active')->exists();
    }

    public function publish(User $user, Event $event): bool
    {
        return $user->id === $event->organizer_id
            && in_array($event->status, ['draft', 'rejected']);
    }

    public function managePackages(User $user, Event $event): bool
    {
        return $user->id === $event->organizer_id;
    }

    public function manageSponsors(User $user, Event $event): bool
    {
        return $user->id === $event->organizer_id;
    }

    public function managePartners(User $user, Event $event): bool
    {
        return $user->id === $event->organizer_id;
    }

    public function viewAnalytics(User $user, Event $event): bool
    {
        return $user->id === $event->organizer_id;
    }
}
```

---

## 6. Database Migrations

### 6.1 Migration Execution Order

```bash
# Phase 1: Core Tables
php artisan migrate --path=database/migrations/0001_01_01_000000_create_users_table.php
php artisan migrate --path=database/migrations/0001_01_01_000001_create_profiles_table.php
php artisan migrate --path=database/migrations/0001_01_01_000002_create_otp_verifications_table.php
php artisan migrate --path=database/migrations/0001_01_01_000003_create_roles_permissions_table.php

# Phase 2: Event Tables
php artisan migrate --path=database/migrations/2024_01_01_000010_create_categories_table.php
php artisan migrate --path=database/migrations/2024_01_01_000011_create_events_table.php
php artisan migrate --path=database/migrations/2024_01_01_000012_create_event_gallery_table.php
php artisan migrate --path=database/migrations/2024_01_01_000013_create_event_schedule_table.php
php artisan migrate --path=database/migrations/2024_01_01_000014_create_event_team_table.php

# Phase 3: Sponsorship Tables
php artisan migrate --path=database/migrations/2024_01_01_000020_create_sponsorship_packages_table.php
php artisan migrate --path=database/migrations/2024_01_01_000021_create_sponsorship_benefits_table.php
php artisan migrate --path=database/migrations/2024_01_01_000022_create_sponsorship_requests_table.php
php artisan migrate --path=database/migrations/2024_01_01_000023_create_sponsorship_contracts_table.php

# Phase 4: Partner Tables
php artisan migrate --path=database/migrations/2024_01_01_000030_create_partner_services_table.php
php artisan migrate --path=database/migrations/2024_01_01_000031_create_partner_service_reviews_table.php
php artisan migrate --path=database/migrations/2024_01_01_000032_create_partner_requests_table.php
php artisan migrate --path=database/migrations/2024_01_01_000033_create_partner_bids_table.php

# Phase 5: Communication Tables
php artisan migrate --path=database/migrations/2024_01_01_000040_create_conversations_table.php
php artisan migrate --path=database/migrations/2024_01_01_000041_create_messages_table.php
php artisan migrate --path=database/migrations/2024_01_01_000042_create_notifications_table.php

# Phase 6: Social Media Tables
php artisan migrate --path=database/migrations/2024_01_01_000050_create_social_accounts_table.php
php artisan migrate --path=database/migrations/2024_01_01_000051_create_event_posts_table.php
php artisan migrate --path=database/migrations/2024_01_01_000052_create_post_logs_table.php

# Phase 7: Search & AI Tables
php artisan migrate --path=database/migrations/2024_01_01_000060_create_pages_table.php
php artisan migrate --path=database/migrations/2024_01_01_000061_create_keywords_table.php
php artisan migrate --path=database/migrations/2024_01_01_000062_create_backlinks_table.php
php artisan migrate --path=database/migrations/2024_01_01_000063_create_search_logs_table.php
php artisan migrate --path=database/migrations/2024_01_01_000064_create_crawl_jobs_table.php

# Phase 8: System Tables
php artisan migrate --path=database/migrations/2024_01_01_000070_create_activity_logs_table.php
php artisan migrate --path=database/migrations/2024_01_01_000071_create_cms_pages_table.php
php artisan migrate --path=database/migrations/2024_01_01_000072_create_platform_settings_table.php
```

---

## 7. Seeders

### 7.1 Seeder Implementation

```php
<?php

// database/seeders/DatabaseSeeder.php
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            AdminSeeder::class,
            // Only in development:
            // UserSeeder::class,
            // EventSeeder::class,
        ]);
    }
}

// database/seeders/RoleSeeder.php
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        Role::create(['name' => 'organizer']);
        Role::create(['name' => 'sponsor']);
        Role::create(['name' => 'partner']);
        Role::create(['name' => 'admin']);

        // Permissions
        Permission::create(['name' => 'create-events']);
        Permission::create(['name' => 'edit-events']);
        Permission::create(['name' => 'delete-events']);
        Permission::create(['name' => 'publish-events']);
        Permission::create(['name' => 'manage-packages']);
        Permission::create(['name' => 'manage-sponsors']);
        Permission::create(['name' => 'manage-partners']);
        Permission::create(['name' => 'view-analytics']);
        Permission::create(['name' => 'manage-services']);
        Permission::create(['name' => 'bid-opportunities']);
        Permission::create(['name' => 'manage-users']);
        Permission::create(['name' => 'manage-categories']);
        Permission::create(['name' => 'manage-cms']);
        Permission::create(['name' => 'view-reports']);

        // Assign permissions to roles
        Role::where('name', 'organizer')->first()->givePermissionTo([
            'create-events', 'edit-events', 'delete-events', 'publish-events',
            'manage-packages', 'manage-sponsors', 'manage-partners', 'view-analytics',
        ]);

        Role::where('name', 'sponsor')->first()->givePermissionTo([
            // Sponsor permissions (default access)
        ]);

        Role::where('name', 'partner')->first()->givePermissionTo([
            'manage-services', 'bid-opportunities',
        ]);

        Role::where('name', 'admin')->first()->givePermissionTo([
            'manage-users', 'manage-categories', 'manage-cms', 'view-reports', 'publish-events',
        ]);
    }
}
```

---

## 8. Queue Jobs

### 8.1 Job Directory Structure

```
app/Jobs/
├── SendOtpJob.php
├── SendEmailVerificationJob.php
├── SendNotificationJob.php
├── SendEnquiryEmailJob.php
├── PublishSocialPostJob.php
├── RefreshSocialTokenJob.php
├── CrawlWebsiteJob.php
├── IndexContentJob.php
└── GenerateSitemapJob.php
```

### 8.2 Job Implementation

```php
<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Event;
use App\Services\SocialMedia\SocialMediaServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishSocialPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;
    public int $tries = 3;
    public array $backoff = [30, 120];

    public function __construct(
        private Event $event,
        private string $platform,
        private string $accessToken,
        private array $content
    ) {}

    public function handle(SocialMediaServiceInterface $service): void
    {
        $result = $service->post($this->accessToken, $this->content);

        // Log success
        $this->event->posts()->create([
            'platform' => $this->platform,
            'status' => 'success',
            'post_url' => $result['url'] ?? null,
            'published_at' => now(),
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        // Log failure
        $this->event->posts()->create([
            'platform' => $this->platform,
            'status' => 'failed',
            'error_message' => $exception->getMessage(),
        ]);
    }
}
```

---

## 9. Events & Listeners

### 9.1 Event Directory Structure

```
app/Events/
├── EventCreated.php
├── EventApproved.php
├── SponsorshipRequestSent.php
├── SponsorshipRequestAccepted.php
├── PartnerBidReceived.php
├── PartnerBidAccepted.php
└── MessageSent.php

app/Listeners/
├── SendEventCreatedNotification.php
├── SendEventApprovedNotification.php
├── SendSponsorshipRequestNotification.php
├── SendSponsorshipAcceptedNotification.php
├── SendPartnerBidNotification.php
├── SendPartnerBidAcceptedNotification.php
└── BroadcastMessage.php
```

---

## 10. API Controllers

### 10.1 API Route Implementation

```php
// routes/api.php

use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\EnquiryController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\RoiController;

Route::middleware('auth:sanctum')->group(function () {
    // Messages
    Route::post('/messages/send', [MessageController::class, 'send']);
    Route::get('/messages/{id}', [MessageController::class, 'fetch']);
    Route::post('/messages/typing', [MessageController::class, 'typing']);

    // Upload
    Route::post('/upload', [UploadController::class, 'store']);

    // Enquiry
    Route::post('/enquiry/send', [EnquiryController::class, 'send']);
});

Route::middleware(['api', 'search.log', 'search.rate_limit'])->group(function () {
    // Search
    Route::get('/search/events', [SearchController::class, 'events']);

    // Filters
    Route::get('/filters/categories', [FilterController::class, 'categories']);
    Route::get('/filters/cities', [FilterController::class, 'cities']);
});

Route::post('/roi/calculate', [RoiController::class, 'calculate']);
```

---

## 11. Caching Strategy

### 11.1 Cache Implementation

```php
<?php

// Static data — long TTL
Cache::remember('categories', 86400, fn() => Category::all());
Cache::remember('cities', 86400, fn() => Event::distinct('city')->pluck('city'));

// Dynamic data — short TTL
Cache::remember('events_home', 300, fn() => Event::latest()->take(20)->get());
Cache::remember("dashboard_stats_{$userId}", 300, fn() => ...);

// Invalidation
Cache::forget('events_home');
Cache::forget("organizer_events_{$organizer->id}");
Cache::forget("event_{$event->id}");
```

| Data | TTL | Invalidation |
|---|---|---|
| Categories, Cities, Settings | 24 hours | On admin edit |
| Event listings | 5 minutes | On event create/update |
| Dashboard stats | 5 minutes | On any status change |
| Sponsor/Partner lists | 10 minutes | On profile update |

---

## 12. Testing

### 12.1 Test Directory Structure

```
tests/
├── Unit/
│   ├── Services/
│   │   ├── EventServiceTest.php
│   │   ├── PackageServiceTest.php
│   │   └── PartnerServiceTest.php
│   ├── Policies/
│   │   ├── EventPolicyTest.php
│   │   └── PartnerServicePolicyTest.php
│   └── Middleware/
│       ├── EnsureProfileCompleteTest.php
│       └── RoleMiddlewareTest.php
├── Feature/
│   ├── Auth/
│   │   ├── LoginTest.php
│   │   └── RegisterTest.php
│   ├── Organizer/
│   │   ├── EventCrudTest.php
│   │   └── PackageManagementTest.php
│   ├── Sponsor/
│   │   ├── DiscoverEventsTest.php
│   │   └── SendEnquiryTest.php
│   ├── Partner/
│   │   ├── ServiceCrudTest.php
│   │   └── BidTest.php
│   └── Admin/
│       ├── EventApprovalTest.php
│       └── UserManagementTest.php
└── TestCase.php
```

### 12.2 Test Naming Convention

```php
public function test_createEvent_withValidData_returns201()
public function test_createEvent_withInvalidCategory_returns422()
public function test_organizer_canOnlyViewOwnEvents()
public function test_sponsor_canSendEnquiry()
```

---

## 13. Implementation Checklist

### Phase 1: Foundation
- [ ] Install Laravel 12
- [ ] Configure .env
- [ ] Install Spatie Permission
- [ ] Install Sanctum
- [ ] Create all migrations
- [ ] Run migrations
- [ ] Create seeders
- [ ] Run seeders

### Phase 2: Authentication
- [ ] LoginController
- [ ] RegisterController
- [ ] PasswordResetController
- [ ] VerificationController
- [ ] OtpService
- [ ] Login/Register views

### Phase 3: Event Module
- [ ] EventService
- [ ] OrganizerEventController
- [ ] EventPolicy
- [ ] StoreEventRequest
- [ ] UpdateEventRequest
- [ ] Event views

### Phase 4: Sponsorship Module
- [ ] PackageService
- [ ] EnquiryService
- [ ] OrganizerPackageController
- [ ] SponsorDiscoverController
- [ ] SponsorEnquiryController
- [ ] Package/Enquiry views

### Phase 5: Partner Module
- [ ] PartnerService
- [ ] ServiceService
- [ ] BidService
- [ ] PartnerServiceController
- [ ] PartnerOpportunityController
- [ ] Service/Bid views

### Phase 6: Communication
- [ ] MessageService
- [ ] NotificationService
- [ ] MessageController (API)
- [ ] Real-time messaging

### Phase 7: Admin
- [ ] AdminDashboardController
- [ ] AdminEventController
- [ ] AdminUserController
- [ ] Admin views

### Phase 8: Testing
- [ ] Unit tests for services
- [ ] Unit tests for policies
- [ ] Feature tests for auth
- [ ] Feature tests for CRUD
- [ ] Feature tests for permissions

---

*Last updated: 2026-06-30*
*This plan governs all backend implementation. Follow the execution pipeline from project.md Section 24.*
