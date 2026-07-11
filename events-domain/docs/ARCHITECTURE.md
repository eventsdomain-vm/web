# Events Domain - Architecture

## Tech Stack
- **Backend**: Laravel 12, PHP 8.2, MySQL 8
- **Frontend**: Blade + Tailwind CSS v3 + Alpine.js 3
- **Auth**: Laravel Sanctum + Spatie Permission (RBAC)
- **Media**: Spatie MediaLibrary
- **Queue**: Database driver

## Directory Structure
```
app/
├── Console/Commands/          # Artisan commands
├── DTOs/                      # Data Transfer Objects
│   ├── EventCreateData.php
│   ├── EventUpdateData.php
│   └── EventImportData.php
├── Http/
│   ├── Controllers/
│   │   ├── Admin/             # 10 admin controllers
│   │   ├── Organizer/         # Event, Package, Schedule, Gallery, Team, etc.
│   │   ├── Sponsor/           # Sponsor-facing controllers
│   │   ├── Partner/           # Partner-facing controllers
│   │   └── Cms/               # CMS page controllers
│   ├── Requests/              # FormRequest validation classes
│   └── Middleware/
├── Jobs/                      # Queued jobs (ImportSponsorshipSearchJob)
├── Models/                    # 30+ Eloquent models
├── Observers/                 # EventDateObserver, EventVenueObserver
├── Policies/                  # EventPolicy (Gate-based)
├── Providers/                 # AppServiceProvider (observers, policies)
├── Repositories/              # EventRepository (data access layer)
├── Services/                  # EventService, EventImportService, CategoryFormResolverService
├── Traits/                    # MediaUploadable, HasSearchFilter, HasStatusLabel
resources/views/
├── admin/                     # Admin panel views
├── organizer/                 # Organizer dashboard + 10-step wizard
├── sponsor/                   # Sponsor views
├── partner/                   # Partner views
├── events/                    # Public event views
└── components/                # Reusable Blade components
```

## Design Patterns

### Service/Repository Pattern
- **Controllers** inject `EventService` (business logic) + `EventPolicy` (authorization)
- **EventService** injects `EventRepository` (data access)
- **DTOs** (`EventCreateData`, `EventUpdateData`) handle request→model mapping
- Form data → `EventCreateData::fromRequest()` → `EventService::createEvent()`

### Observer Pattern
- `EventDateObserver` syncs `start_date`/`end_date` on events from child `event_dates` table
- `EventVenueObserver` syncs `city`/`state`/`country`/`venue` from child `event_venues` table
- Keeps denormalized summary columns on `events` table in sync

### Dynamic Category Forms
- `CategoryFieldDefinition` stores field schemas (global defaults + per-category overrides)
- `CategoryFormResolverService::resolveForCategory()` merges, cached 1hr
- 36 field definitions seeded (28 global + 8 category-specific)

### 10-Step Organizer Wizard
Steps: Basic Info → Dates → Venues → Sponsorship → Packages → Audience → Media → Participants → Plan → Review
- Alpine.js state management with auto-save (10s interval)
- localStorage backup for crash recovery
- Server-side draft persistence via `saveDraft()`/`loadDraft()`

### RBAC
Roles: `admin`, `organizer`, `sponsor`, `partner`
- Admin panel gated by `role:admin` middleware
- `EventPolicy` registered via `Gate::policy()` in AppServiceProvider
- Authorization: `$this->authorize('view', $event)` in controllers

## Key Tables (Domain Core)
| Table | Purpose |
|---|---|
| `events` | Main event record with denormalized summary columns |
| `event_dates` | Normalized date entries (multi-day support) |
| `event_venues` | Normalized venue entries (physical/virtual) |
| `event_schedule` | Session/stage schedule items |
| `participants` | Reusable person/act master records |
| `event_participants` | Event↔Participant pivot with role/timing |
| `sponsor_packages` | Sponsorship packages with pricing |
| `sponsorship_benefits` | Per-package benefit line items |
| `sponsorship_requests` | Sponsor→Package binding requests |
| `partner_services` | Partner service catalog |
| `partner_bids` | Partner→Event bid proposals |

## Testing
- PHPUnit with SQLite in-memory (`phpunit.xml`)
- 18 feature tests (Organizer suite): EventCrudTest (7), DraftSaveTest (6), PackageSyncTest (4)
- 9 model factories: Event, Category, Participant, SponsorshipPackage, EventDate, EventVenue, EventParticipant, EventTeam, EventSchedule
- Run: `php vendor/bin/phpunit --testsuite=Feature --filter=Organizer`
- Full DB reset: `php artisan migrate:fresh --seed`

## Seeders
| Seeder | Records |
|---|---|
| `RoleSeeder` | admin, organizer, sponsor, partner roles |
| `PlatformSettingSeeder` | Platform configuration |
| `CategorySeeder` | 5 event categories |
| `ParticipantTypeSeeder` | Speaker, Panelist, etc. |
| `AmenitySeeder` | Venue amenities |
| `CategoryFieldDefinitionSeeder` | 36 dynamic form field definitions |
| `EventImportSeeder` | 16 events + 106 packages from JSON |
