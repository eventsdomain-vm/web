# Copilot Instructions for Events Domain

## Build, Test & Development

### Prerequisites
- PHP 8.2+
- Node.js (for Vite & Tailwind)
- MySQL 8 (for production; SQLite for testing)
- Composer & npm

### Setup
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### Running the Application
```bash
# Full development stack (server + queue + logs + Vite)
composer run dev

# Or run individually:
php artisan serve                    # Start Laravel server
php artisan queue:listen             # Process background jobs
npm run dev                          # Run Vite dev server with Tailwind
```

### Testing
```bash
# Run all tests
composer run test

# Run specific test file
php artisan test tests/Feature/EventTest.php

# Run unit tests only
php artisan test --testsuite=Unit

# Run feature tests only
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage

# Run single test method
php artisan test tests/Feature/EventTest.php --filter=testEventCreation
```

**Test Setup**: Tests use SQLite `:memory:` database configured in `phpunit.xml`. All tests run isolated.

### Building Assets
```bash
npm run build      # Production build (Tailwind + Vite optimization)
npm run dev        # Development with hot reload
```

### Code Quality
```bash
# Laravel Pint (PHP linting)
./vendor/bin/pint              # Check & auto-fix all files
./vendor/bin/pint app/Models   # Check & auto-fix specific directory
```

## Architecture Overview

### Tech Stack
- **Backend**: Laravel 12, PHP 8.2
- **Database**: MySQL 8 (Eloquent ORM)
- **Frontend**: Blade templates, Tailwind CSS v3, Alpine.js 3
- **Authentication**: Laravel Sanctum + Spatie Permission (RBAC)
- **Media**: Spatie MediaLibrary
- **Build Tools**: Vite (asset bundling), Laravel Vite Plugin
- **Queue**: Database driver

### Core Domain

The application is an **event management platform** with four main user roles:
1. **Organizers** - Create & manage events
2. **Sponsors** - Browse events, purchase sponsorship packages
3. **Partners** - Service providers (caterers, decorators, etc.)
4. **Admins** - Platform governance, SEO, analytics

### Directory Structure
```
app/
├── Console/Commands/          # Artisan commands for background tasks
├── DTOs/                      # Data Transfer Objects (EventCreateData, EventUpdateData, etc.)
├── Http/
│   ├── Controllers/
│   │   ├── Admin/             # Admin panel (SEO, Analytics, Users, Reports)
│   │   ├── Organizer/         # Organizer dashboard & event management wizard
│   │   ├── Sponsor/           # Sponsor-facing features (browse, purchase)
│   │   ├── Partner/           # Partner features
│   │   └── [Root]             # Public/auth controllers (Event, Home, Auth)
│   └── Requests/              # FormRequest validation
├── Models/                    # 100+ Eloquent models (Events, Sponsors, Partners, etc.)
├── Observers/                 # EventDateObserver, EventVenueObserver (sync denormalized columns)
├── Policies/                  # EventPolicy (authorization)
├── Repositories/              # EventRepository (query abstraction)
├── Services/                  # Business logic (EventService, SponsorCampaignService, etc.)
└── Traits/                    # Reusable functionality (MediaUploadable, HasSearchFilter)

resources/
├── views/admin/               # Admin panel templates
├── views/organizer/           # Organizer dashboard + 10-step wizard
├── views/sponsor/             # Sponsor browsing & booking
├── views/partner/             # Partner interfaces
├── views/events/              # Public event listings & details
└── views/components/          # Reusable Blade components

config/
├── permission.php             # Spatie Permission config (roles/permissions)
├── media-library.php          # Spatie MediaLibrary config
└── [other]                    # Database, cache, queue, auth config
```

### Design Patterns

#### Service/Repository Pattern
**Data flow**: Controller → Service → Repository → Model
- Controllers inject `EventService` (business logic) + `EventPolicy` (authorization)
- Services inject repositories for data access
- DTOs handle request → model mapping
- Example: `EventController@store()` → `EventService::createEvent(EventCreateData)` → `EventRepository::create()`

#### Observer Pattern
Keeps denormalized summary columns in sync:
- `EventDateObserver` syncs `start_date`, `end_date` from `event_dates` table to `events` table
- `EventVenueObserver` syncs `city`, `state`, `country`, `venue` from `event_venues` table to `events` table

#### Dynamic Category Forms
- `CategoryFieldDefinition` model stores field schemas (28 global defaults + per-category overrides)
- `CategoryFormResolverService` merges schemas and caches for 1 hour
- Allows admins to customize event creation forms per category without code changes

#### 10-Step Organizer Wizard
Located in `resources/views/organizer/events/wizard/`:
- Steps: Basic Info → Dates → Venues → Sponsorship → Packages → Audience → Media → Participants → Plan → Review
- Uses Alpine.js for state management with auto-save every 10 seconds
- localStorage backup for crash recovery
- Server-side draft persistence via `EventDraft` model and `saveDraft()`/`loadDraft()` methods

#### RBAC (Role-Based Access Control)
- Roles: `admin`, `organizer`, `sponsor`, `partner`
- Permissions managed by Spatie Permission package
- Admin panel gated by `role:admin` middleware
- Authorization via `EventPolicy` registered with Laravel Gate

### Key Models & Relationships
| Model | Purpose |
|-------|---------|
| `Event` | Main event record with denormalized columns (`start_date`, `end_date`, `city`, `country`, `venue`) |
| `EventDate` | Normalized date entries (multi-day events supported) |
| `EventVenue` | Normalized venue entries (physical/virtual) |
| `EventSchedule` | Sessions/stages within event |
| `SponsorshipPackage` | Sponsorship tiers (e.g., Gold, Silver, Bronze) |
| `Sponsor` | Companies offering sponsorships |
| `SponsorCampaign` | Active sponsorship deals with deliverables/milestones |
| `Partner` | Service providers (catering, décor, etc.) |
| `OrganizerProfile` | Organizer's business info & settings |

### Database Conventions
- **Timestamps**: All tables have `created_at`, `updated_at`
- **Soft Deletes**: Key models use `deleted_at` (EventDraft, EventMedia, etc.)
- **Denormalization**: Summary columns on `events` (start_date, city, venue) kept in sync by observers
- **Polling Tables**: `crawl_jobs`, `search_indexes` for background data processing
- **Audit Trails**: `activity_logs`, `sponsor_audit_logs`, `partner_activity_logs` track changes

## Key Conventions

### File Organization
- **Controllers**: Named by feature + entity (`AdminEventController`, `OrganizerEventController`, `SponsorEventController`)
- **Services**: Named `{Entity}Service` (e.g., `EventService`, `SponsorCampaignService`)
- **Repositories**: Named `{Entity}Repository` (e.g., `EventRepository`)
- **Models**: Use singular names (`Event`, `Sponsor`, `Partner`)
- **Migrations**: Follow Laravel convention: `YYYY_MM_DD_HHMMSS_create_table_name_table.php`

### Validation
- Use `FormRequest` classes in `app/Http/Requests/` for complex validation
- Name requests after the action: `StoreEventRequest`, `UpdateEventRequest`
- Validation rules in `rules()` method, custom messages in `messages()` method

### Blade Components
- Reusable components in `resources/views/components/`
- Prefix component names with domain: `events::card`, `events::form-group`
- Use `@component()` or `<x-events-card>` syntax

### Styling
- **Framework**: Tailwind CSS v3 with custom terracotta color palette
- **Custom Colors**: `terracotta-50` through `terracotta-950` (defined in `tailwind.config.js`)
- **SafeList**: Long list of dynamic Tailwind classes in `tailwind.config.js` for CMS content (don't remove!)
- **Typography Plugin**: Enabled for rich text content (blog posts, descriptions)

### Frontend Interactivity
- Use Alpine.js 3 for interactive components
- State managed with `x-data` and `x-bind`/`x-show` for simple toggle logic
- Form auto-save patterns with `@input.debounce` and AJAX handlers
- See `organizer/events/wizard/` for complex state management example

### Naming Conventions
- **Routes**: Plural resource names (`/events`, `/sponsors`, `/partners`)
- **Database Columns**: snake_case (`event_date`, `sponsor_id`, `is_active`)
- **PHP Classes**: PascalCase (`EventService`, `SponsorPolicy`)
- **Methods**: camelCase (`createEvent()`, `publishEvent()`)

### Testing Patterns
- **Unit Tests**: Business logic in `tests/Unit/` (services, repositories)
- **Feature Tests**: HTTP endpoints in `tests/Feature/` (controllers, policies)
- **Fixtures**: Use factory methods (`EventFactory::make()`) for test data
- **Assertions**: Use Laravel's assertion helpers (`$this->assertDatabaseHas()`, `$response->assertStatus()`)

### Relationships & Eager Loading
- Always use `with()` to eager-load relationships and prevent N+1 queries
- Example: `Event::with('dates', 'venues', 'sponsorshipPackages')->get()`
- Define relationship methods in models using `hasMany()`, `belongsTo()`, `belongsToMany()`

### Error Handling
- Throw `\Illuminate\Auth\AuthorizationException` for permission failures
- Throw `\Illuminate\Database\Eloquent\ModelNotFoundException` for missing resources (auto-catches with 404)
- Use try-catch for external API calls (payment processing, LinkedIn AI, etc.)

### Queue/Background Jobs
- Enqueue jobs with `dispatch()` or `Job::dispatch()`
- Jobs stored in database driver (configured in `.env`)
- Process with `php artisan queue:listen` (development) or supervisor (production)

## Important Gotchas

1. **Denormalized Columns**: `events.start_date`, `events.end_date`, `events.city`, etc. are kept in sync by observers—don't update them directly!
2. **SafeList in Tailwind**: The long safelist in `tailwind.config.js` is intentional for CMS content. Don't shorten it.
3. **Test Database**: Tests use SQLite `:memory:`; configure `DB_DATABASE` in `phpunit.xml` only.
4. **Lazy Loading**: Always eager-load relationships to avoid N+1 queries; see relationship definitions in models.
5. **Soft Deletes**: When querying, remember to include `withTrashed()` or `onlyTrashed()` if soft-deleted rows should be visible.
6. **Queue Sync Mode in Testing**: `QUEUE_CONNECTION=sync` in phpunit.xml ensures jobs run immediately during tests.

## Resources

- **Architecture Details**: `docs/ARCHITECTURE.md`
- **Entity Relationships**: `docs/er-diagram.md`
- **Database Migrations**: `database/migrations/`
- **Laravel Docs**: https://laravel.com/docs
- **Spatie Permission**: https://spatie.be/docs/laravel-permission
- **Spatie MediaLibrary**: https://spatie.be/docs/laravel-medialibrary
- **Tailwind CSS**: https://tailwindcss.com/docs
- **Alpine.js**: https://alpinejs.dev
