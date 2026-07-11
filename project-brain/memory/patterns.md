# Memory — Patterns

## Coding Patterns

### 1. Service Layer
All business logic lives in Service classes. Controllers call one service method per action.

```php
// Controller stays thin
class EventController extends Controller
{
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $event = $this->eventService->create($request->validated());
        return to_route('organizer.events.show', $event)->with('success', 'Event created.');
    }
}

// Service contains logic
class EventService
{
    public function create(array $data): Event
    {
        return DB::transaction(function () use ($data) {
            $event = Event::create($data);
            // Additional setup...
            return $event;
        });
    }
}
```

### 2. Form Request Validation
```php
class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Event::class);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'start_date' => ['required', 'date', 'after:today'],
            'expected_audience' => ['required', 'integer', 'min:1'],
        ];
    }
}
```

### 3. Resource Controllers
Use `php artisan make:controller --resource` for all CRUD operations.

### 4. Policy Authorization
```php
class EventPolicy
{
    public function view(User $user, Event $event): bool
    {
        return $user->id === $event->organizer_id || $user->hasRole('admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('organizer');
    }
}
```

### 5. Database Transactions
Wrap multi-step operations in `DB::transaction()`.

### 6. Queue Jobs
Defer email, notification, and analytics to queue jobs.

## Blade Patterns

### Component Pattern
```blade
{{-- resources/views/components/ui/card.blade.php --}}
<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-sm border border-gray-200 p-6']) }}>
    @isset($header)
        <div class="mb-4">{{ $header }}</div>
    @endisset
    {{ $slot }}
    @isset($footer)
        <div class="mt-4 pt-4 border-t border-gray-100">{{ $footer }}</div>
    @endisset
</div>
```

### Layout Inheritance
```blade
{{-- Layout defines navigation, sidebar, header --}}
<x-layouts.organizer>
    <x-slot:title>My Events</x-slot>
    {{-- Page content --}}
</x-layouts.organizer>
```

## Alpine.js Patterns

### Single-State Component
```blade
<div x-data="{ open: false, loading: false }">
    <button @click="open = true" :disabled="loading">Open</button>
    <div x-show="open" @click.away="open = false">
        {{-- Content --}}
    </div>
</div>
```

### AJAX Component
```blade
<div x-data="{ query: '', results: [] }">
    <input x-model="query" @input.debounce="fetchResults">
    <template x-for="item in results" :key="item.id">
        <div x-text="item.name"></div>
    </template>
</div>
```

## Naming Conventions
- Models: Singular, PascalCase (`Event`, `SponsorshipPackage`)
- Tables: Plural, snake_case (`events`, `sponsorship_packages`)
- Controllers: Singular, PascalCase + Controller suffix (`EventController`)
- Services: Singular, PascalCase + Service suffix (`EventService`)
- Routes: kebab-case (`/organizer/events/create`)
- Blade files: kebab-case (`event-card.blade.php`)
- Migrations: `YYYY_MM_DD_HHmmss_create_events_table.php`
