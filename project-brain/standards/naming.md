# Standards — Naming Conventions

## PHP / Laravel
| Item | Convention | Example |
|---|---|---|
| Models | Singular, PascalCase | `Event`, `SponsorshipPackage` |
| Controllers | PascalCase + Controller | `EventController` |
| Services | PascalCase + Service | `EventService` |
| Form Requests | PascalCase + Request | `StoreEventRequest` |
| Policies | PascalCase + Policy | `EventPolicy` |
| Middleware | kebab-case | `role:organizer` |
| Routes (web) | kebab-case | `/organizer/events/create` |
| Route names | dot-notation | `organizer.events.create` |
| Route params | camelCase | `{eventId}`, `{packageId}` |

## Database
| Item | Convention | Example |
|---|---|---|
| Tables | plural, snake_case | `events`, `sponsorship_packages` |
| Columns | snake_case | `sponsorship_type`, `expected_audience` |
| Pivot tables | singular_alphabetical | `event_sponsor` |
| Foreign keys | singular_id | `event_id`, `organizer_id` |
| Indexes | idx_column | `idx_status`, `idx_category_id` |
| Migrations | YYYY_MM_DD_HHmmss | `2026_06_29_000001_create_events_table` |

## Frontend
| Item | Convention | Example |
|---|---|---|
| Blade files | kebab-case | `event-card.blade.php` |
| Blade components | PascalCase | `<x-ui.card />` |
| Alpine components | camelCase | `sponsorshipPackageBuilder` |
| CSS classes | utility (Tailwind) | `bg-white text-gray-900` |
| JS functions | camelCase | `fetchResults()`, `toggleFilter()` |
| JS variables | camelCase | `isLoading`, `searchResults` |

## Filesystem
| Item | Convention | Example |
|---|---|---|
| Event images | event/{id}/{uuid}.{ext} | `event/42/a1b2c3d4.jpg` |
| User avatars | avatars/{user_id}.{ext} | `avatars/15.jpg` |
| Gallery images | gallery/{event_id}/{uuid}.{ext} | `gallery/42/e5f6a7b8.png` |
