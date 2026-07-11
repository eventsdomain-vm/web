# Multi-Step "Submit Event" Wizard — Laravel + Tailwind Implementation Spec

## 1. Overall Flow Logic

This is a **7-step wizard** with a persistent **draft** (auto-saved), a **step tracker** (top nav with checkmarks once completed), and a final **plan selection + submit**.

```
Step 1: Basic Info
Step 2: Location
Step 3: Sponsorship
Step 4: Add-Ons
Step 5: Audience
Step 6: Media
Step 7: Plan (pricing + final submit)
```

### Key behaviors seen in screenshots
- **"Saving..." indicator** — the form auto-saves to a draft record on every field blur/change (debounced), so the user never loses progress if they leave.
- **"Clear Draft"** — deletes the draft row and resets the wizard.
- **Step tracker** — each step icon turns into a red circle with a ✓ once that step's required fields are valid. Clicking a completed step's label lets you jump back to it.
- **Previous / Next** — Next is disabled (or shows validation errors) until required fields (marked `*`) are filled.
- **Step 7 "Plan"** — shows 3 pricing tiers (Basic/Featured/Homepage), user picks one, then clicks **Submit Event**, which finalizes the draft into a real `events` record with `status = pending_review`.

### Chosen stack: Alpine.js + AJAX (no Livewire)
Single Blade view, one `x-data` object holds all wizard state client-side. Each step is a `<div x-show="step === N">` block — no page reloads. Autosave and final submit both go through plain Laravel controller endpoints hit via `fetch()`.

```
GET  /submit-event                     → loads wizard shell + existing draft (if any) as JSON, boots Alpine state
POST /submit-event/draft               → upserts event_drafts.data (called on debounced field change + step change)
POST /submit-event/draft/clear         → deletes the draft row
POST /submit-event/{draft}/submit      → validates everything server-side, creates real Event + related rows
```

---

## 2. Database Schema

### `event_drafts` table (holds in-progress wizard state before final submission)

```php
Schema::create('event_drafts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->unsignedTinyInteger('current_step')->default(1);
    $table->json('data')->nullable(); // stores all step field values as JSON until finalized
    $table->timestamps();
});
```

Using a single JSON `data` column for the draft is simplest — you don't need strict columns until the event is actually submitted. Alternatively, mirror the final `events` table structure directly on the draft (more type-safe, more migrations). For a wizard like this, JSON draft + normalized final tables is the common pattern.

### `events` table (final, submitted event — Basic Info + Location + Sponsorship core fields)

```php
Schema::create('events', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();

    // Step 1: Basic Info
    $table->string('title');
    $table->text('description');
    $table->string('category'); // or foreignId('category_id') if using a lookup table
    $table->date('start_date');
    $table->time('start_time')->nullable();
    $table->date('end_date')->nullable();
    $table->time('end_time')->nullable();

    // Step 2: Location
    $table->string('venue_name');
    $table->text('venue_address')->nullable();
    $table->string('country')->default('India');
    $table->string('city');

    // Step 3: Sponsorship
    $table->unsignedInteger('expected_audience_size')->nullable();
    $table->string('sponsorship_budget_range')->nullable(); // e.g. "50k-1L"
    $table->enum('sponsorship_type', ['cash', 'barter', 'paid_barter']);

    // Step 7: Plan
    $table->enum('plan', ['basic', 'featured', 'homepage'])->default('basic');
    $table->enum('status', ['draft', 'pending_review', 'approved', 'rejected', 'live'])
          ->default('pending_review');

    $table->timestamps();
});
```

### `event_sponsorship_levels` (Step 3 — multi-select checkboxes: Title Sponsor, Co-Sponsor, etc.)

```php
Schema::create('event_sponsorship_levels', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->cascadeOnDelete();
    $table->enum('level', ['title', 'co_sponsor', 'associate', 'powered_by', 'media_partner']);
    $table->timestamps();
});
```
> Many-to-many by nature (an event can offer several levels) — you could also make this a static lookup + pivot table (`sponsorship_levels` + `event_sponsorship_level` pivot) if you want admin-editable level names later. For a fixed 5 options, the enum-on-child-table approach above is simpler.

### `event_stalls` (Step 4 — Add-Ons: Stall & Booth Options, repeatable)

```php
Schema::create('event_stalls', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->cascadeOnDelete();
    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2)->nullable();
    $table->timestamps();
});
```

### `event_fnb_options` (Step 4 — Food & Beverage Sponsorship, repeatable)

```php
Schema::create('event_fnb_options', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->cascadeOnDelete();
    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2)->nullable();
    $table->timestamps();
});
```

### `event_ad_spaces` (Step 4 — "Advertising Spaces", same repeatable pattern, cut off in screenshot but implied)

```php
Schema::create('event_ad_spaces', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->cascadeOnDelete();
    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2)->nullable();
    $table->timestamps();
});
```

### Step 5 — Audience: normalized lookup + pivot tables (chosen approach, enables sponsor-side search/filter)

Since sponsors will eventually filter/search events by audience attributes, use lookup tables + pivots instead of JSON blobs. This lets you do `Event::whereHas('audienceTypes', fn($q) => $q->where('slug', 'students'))` cleanly, and add/remove options from an admin panel without a deploy.

```php
// Lookup tables (seed once, admin-editable)
Schema::create('audience_types', function (Blueprint $table) {
    $table->id();
    $table->string('slug')->unique();  // students, college_youth, working_professionals...
    $table->string('label');
    $table->timestamps();
});

Schema::create('age_groups', function (Blueprint $table) {
    $table->id();
    $table->string('slug')->unique(); // below_18, 18_24, 25_34, 35_44, 45_54, 55_plus
    $table->string('label');
    $table->unsignedTinyInteger('sort_order')->default(0);
    $table->timestamps();
});

Schema::create('industries', function (Blueprint $table) {
    $table->id();
    $table->string('slug')->unique(); // technology, finance, education, health_fitness...
    $table->string('label');
    $table->timestamps();
});

// Single row per event for the non-multi fields
Schema::create('event_audience', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->cascadeOnDelete();
    $table->string('gender_composition')->nullable();  // mostly_male | mostly_female | balanced
    $table->string('income_level')->nullable();
    $table->timestamps();
});

// Pivot tables for the checkbox groups
Schema::create('event_audience_type', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->cascadeOnDelete();
    $table->foreignId('audience_type_id')->constrained()->cascadeOnDelete();
    $table->unique(['event_id', 'audience_type_id']);
});

Schema::create('event_age_group', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->cascadeOnDelete();
    $table->foreignId('age_group_id')->constrained()->cascadeOnDelete();
    $table->unique(['event_id', 'age_group_id']);
});

Schema::create('event_industry', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->cascadeOnDelete();
    $table->foreignId('industry_id')->constrained()->cascadeOnDelete();
    $table->unique(['event_id', 'industry_id']);
});
```

### Model relationships

```php
// Event.php
public function audience()        { return $this->hasOne(EventAudience::class); }
public function audienceTypes()   { return $this->belongsToMany(AudienceType::class, 'event_audience_type'); }
public function ageGroups()       { return $this->belongsToMany(AgeGroup::class, 'event_age_group'); }
public function industries()      { return $this->belongsToMany(Industry::class, 'event_industry'); }
```

### Sponsor-side filter example this unlocks

```php
Event::whereHas('audienceTypes', fn ($q) => $q->whereIn('slug', ['students', 'college_youth']))
     ->whereHas('ageGroups', fn ($q) => $q->where('slug', '18_24'))
     ->whereHas('industries', fn ($q) => $q->where('slug', 'technology'))
     ->where('status', 'live')
     ->get();
```

### Draft storage caveat
While the wizard is still a **draft** (before final submit), you don't have an `event_id` yet to attach pivot rows to. Two options:
1. Keep the draft's Step 5 selections as plain arrays of IDs inside `event_drafts.data` (e.g. `data.audience_type_ids = [1,4,7]`), and only write real pivot rows at final submit time. **(Recommended — simplest.)**
2. Create the `Event` row immediately on Step 1 with `status = draft`, so every step can write directly to real relational tables from the start. More "real-time" but means partially-filled events exist in your main table (filter them out with `where('status', '!=', 'draft')` everywhere).

Go with option 1 unless you have a strong reason to persist relationally mid-wizard.

### `event_media` (Step 6 — images + optional YouTube URL)

```php
Schema::create('event_media', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->cascadeOnDelete();
    $table->string('type'); // 'image' | 'video'
    $table->string('path')->nullable();        // storage path for images
    $table->string('youtube_url')->nullable(); // for video
    $table->unsignedTinyInteger('sort_order')->default(0); // first image = cover
    $table->timestamps();
});
```

### `plans` (Step 7 — pricing tiers; lookup table so admin can edit prices without code changes)

```php
Schema::create('plans', function (Blueprint $table) {
    $table->id();
    $table->string('slug'); // basic, featured, homepage
    $table->string('name');
    $table->decimal('price', 10, 2);
    $table->unsignedTinyInteger('image_limit');
    $table->string('analytics_level'); // basic | advanced
    $table->boolean('featured_badge')->default(false);
    $table->boolean('priority_listing')->default(false);
    $table->boolean('social_promotion')->default(false);
    $table->boolean('homepage_featured')->default(false);
    $table->unsignedSmallInteger('listing_duration_days')->default(90);
    $table->timestamps();
});
```
Seed 3 rows matching the screenshot: Basic ₹999, Featured ₹2,999, Homepage ₹4,999.

---

## 3. Field-by-Field Logic (per step)

### Step 1 — Basic Info
| Field | Input type | Validation |
|---|---|---|
| Event Title | text | `required\|string\|max:150` |
| Event Description | textarea | `required\|string\|max:2000` |
| Category | select (from `categories` lookup table or enum) | `required\|exists:categories,id` |
| Event Start Date | `<input type="date">` | `required\|date\|after_or_equal:today` |
| Start Time | select (dropdown of time slots, e.g. 30-min increments) | `nullable\|date_format:H:i` |
| Event End Date | date | `nullable\|date\|after_or_equal:start_date` |
| End Time | select | `nullable\|date_format:H:i` |

> Note only Title, Description, Category, Start Date are marked `*` (required) in the screenshot — Start/End Time and End Date are optional.

### Step 2 — Location
| Field | Input type | Validation |
|---|---|---|
| Venue Name | text | `required\|max:150` |
| Venue Address | textarea | `nullable\|max:500` |
| Country | select (default "India") | `required` |
| City | searchable select (Algolia/typeahead, or a `cities` table filtered by country) | `required` — plus a "Can't find your city?" link that opens a free-text fallback input |

Implementation tip for City: use a Livewire `wire:model.live` on a search input hitting a `cities` table (`WHERE country_id = ? AND name LIKE ?`), or an Alpine.js + `x-data` combobox calling a lightweight `/api/cities?q=` endpoint.

### Step 3 — Sponsorship
| Field | Input type | Validation |
|---|---|---|
| Expected Audience Size | number input | `nullable\|integer\|min:1` |
| Sponsorship Budget Range | select (predefined ranges) | `nullable` |
| Sponsorship Type | radio group (Cash / Barter / Paid+Barter) — styled as cards | `required\|in:cash,barter,paid_barter` |
| Available Sponsorship Levels | checkbox group (Title/Co-Sponsor/Associate/Powered By/Media Partner) — styled as cards | `nullable|array` → saved to `event_sponsorship_levels` |

### Step 4 — Add-Ons (all optional, all repeatable "add item" patterns)
Each of Stalls / F&B / Ad Spaces uses the same repeater UI:
- Empty state: icon + "No X added yet" + "Add Your First X" button
- Clicking "Add Stall" opens a modal or inline form (Name, Description, Price) → pushes a new row into a Livewire array property → renders as a card with an edit/delete icon.
- On save, each becomes a row in `event_stalls` / `event_fnb_options` / `event_ad_spaces`.

### Step 5 — Audience
| Field | Input type | Validation |
|---|---|---|
| Audience Type | checkbox grid (12 options) | `nullable\|array` |
| Age Groups | multi-select pill buttons | `nullable\|array` |
| Gender Composition | select | `nullable\|in:mostly_male,mostly_female,balanced` |
| Income / Spending Capacity | select | `nullable` |
| Interest/Industry Alignment | checkbox grid | `nullable\|array` |

None of these are marked `*` — this whole step is optional (helps sponsors, not a hard gate).

### Step 6 — Media
| Field | Input type | Validation |
|---|---|---|
| Event Images (max 10) | drag-drop/click uploader, first image = cover | `nullable\|array\|max:10`, each `image\|mimes:jpg,jpeg,png,webp\|max:5120` (5MB) |
| YouTube Video URL | text/url input | `nullable\|url\|regex:/youtube\.com|youtu\.be/` |

Image count is later **capped by the selected plan** (Basic=3, Featured=5, Homepage=5) — so validate against `plans.image_limit` at final submit time, not just client-side.

### Step 7 — Plan
- Renders 3 `plans` records as pricing cards.
- Radio-style selection (click card → border highlights, like "Basic" selected with red border in your screenshot).
- "What happens after submission?" static info box.
- **Submit Event** button:
  1. Validates all previous steps again server-side (defense in depth).
  2. Converts `event_drafts.data` JSON → creates real rows in `events`, `event_sponsorship_levels`, `event_stalls`, `event_fnb_options`, `event_audience`, `event_media`.
  3. Sets `events.status = pending_review`, `events.plan = <selected>`.
  4. Deletes/archives the `event_drafts` row.
  5. Redirects to a "Thanks, we'll review within 24–48 hours" confirmation page + fires a notification/email to admin.

---

## 4. Controller + Route Setup

```php
// routes/web.php
Route::middleware('auth')->group(function () {
    Route::get('/submit-event', [EventWizardController::class, 'show'])->name('events.wizard');
    Route::post('/submit-event/draft', [EventWizardController::class, 'saveDraft'])->name('events.wizard.save');
    Route::post('/submit-event/draft/clear', [EventWizardController::class, 'clearDraft'])->name('events.wizard.clear');
    Route::post('/submit-event/submit', [EventWizardController::class, 'submit'])->name('events.wizard.submit');
    Route::get('/api/cities', [CityController::class, 'search']); // for the City typeahead
});
```

```php
// app/Http/Controllers/EventWizardController.php
class EventWizardController extends Controller
{
    public function show()
    {
        $draft = EventDraft::firstOrCreate(
            ['user_id' => auth()->id()],
            ['current_step' => 1, 'data' => []]
        );

        return view('events.wizard', [
            'draft'          => $draft,
            'plans'          => Plan::all(),
            'audienceTypes'  => AudienceType::all(),
            'ageGroups'      => AgeGroup::orderBy('sort_order')->get(),
            'industries'     => Industry::all(),
        ]);
    }

    // Called by Alpine on debounced field change AND on step change
    public function saveDraft(Request $request)
    {
        $draft = EventDraft::firstOrCreate(['user_id' => auth()->id()]);

        $draft->update([
            'data'         => array_merge($draft->data ?? [], $request->input('data', [])),
            'current_step' => $request->input('current_step', $draft->current_step),
        ]);

        return response()->json(['status' => 'saved', 'saved_at' => now()->toIso8601String()]);
    }

    public function clearDraft(Request $request)
    {
        EventDraft::where('user_id', auth()->id())->delete();
        return response()->json(['status' => 'cleared']);
    }

    public function submit(Request $request)
    {
        $draft = EventDraft::where('user_id', auth()->id())->firstOrFail();
        $data = $draft->data;

        $validated = $this->validateFullPayload($data); // per-step rules, all steps at once

        DB::transaction(function () use ($validated, $draft) {
            $event = Event::create([
                ...Arr::only($validated, [
                    'title','description','category_id','start_date','start_time',
                    'end_date','end_time','venue_name','venue_address','country','city',
                    'expected_audience_size','sponsorship_budget_range','sponsorship_type','plan',
                ]),
                'user_id' => auth()->id(),
                'status'  => 'pending_review',
            ]);

            $event->sponsorshipLevels()->createMany(
                collect($validated['sponsorship_levels'] ?? [])->map(fn ($level) => ['level' => $level])
            );
            $event->stalls()->createMany($validated['stalls'] ?? []);
            $event->fnbOptions()->createMany($validated['fnb_options'] ?? []);
            $event->adSpaces()->createMany($validated['ad_spaces'] ?? []);

            $event->audience()->create([
                'gender_composition' => $validated['gender_composition'] ?? null,
                'income_level'       => $validated['income_level'] ?? null,
            ]);
            $event->audienceTypes()->sync($validated['audience_type_ids'] ?? []);
            $event->ageGroups()->sync($validated['age_group_ids'] ?? []);
            $event->industries()->sync($validated['industry_ids'] ?? []);

            // media: images already uploaded to temp storage during Step 6; move + create rows here
            foreach ($validated['media_paths'] ?? [] as $i => $path) {
                $event->media()->create(['type' => 'image', 'path' => $path, 'sort_order' => $i]);
            }
            if (!empty($validated['youtube_url'])) {
                $event->media()->create(['type' => 'video', 'youtube_url' => $validated['youtube_url']]);
            }

            $draft->delete();
        });

        return response()->json(['status' => 'submitted', 'redirect' => route('events.submitted')]);
    }
}
```

## 5. Alpine.js Wizard Shell (Blade + Alpine)

```blade
{{-- resources/views/events/wizard.blade.php --}}
<div x-data="eventWizard(@js($draft->data), {{ $draft->current_step }})" x-init="init()">

    <div class="flex items-center justify-between mb-4">
        <span x-show="saving" class="text-sm text-gray-500">Saving...</span>
        <span x-show="!saving && lastSaved" class="text-sm text-gray-400">Saved</span>
        <button @click="clearDraft" class="text-sm text-gray-500 flex items-center gap-1">
            <x-icon name="trash" /> Clear Draft
        </button>
    </div>

    {{-- Step tracker --}}
    <div class="flex items-center gap-2 mb-6">
        <template x-for="(label, i) in steps" :key="i">
            <button @click="goToStep(i + 1)" :disabled="i + 1 > maxStepReached"
                class="flex items-center gap-2"
                :class="i + 1 === step ? 'text-red-500' : (i + 1 < maxStepReached ? 'text-red-500' : 'text-gray-400')">
                <span class="w-8 h-8 rounded-full border-2 flex items-center justify-center"
                    :class="i + 1 < maxStepReached ? 'bg-red-500 border-red-500 text-white' : (i + 1 === step ? 'border-red-500' : 'border-gray-300')">
                    <span x-show="i + 1 < maxStepReached">✓</span>
                </span>
                <span x-text="label"></span>
            </button>
        </template>
    </div>

    {{-- Step panels --}}
    <div x-show="step === 1">@include('events.wizard-steps.basic-info')</div>
    <div x-show="step === 2">@include('events.wizard-steps.location')</div>
    <div x-show="step === 3">@include('events.wizard-steps.sponsorship')</div>
    <div x-show="step === 4">@include('events.wizard-steps.add-ons')</div>
    <div x-show="step === 5">@include('events.wizard-steps.audience')</div>
    <div x-show="step === 6">@include('events.wizard-steps.media')</div>
    <div x-show="step === 7">@include('events.wizard-steps.plan')</div>

    <div class="flex justify-between mt-6">
        <button @click="previousStep" x-show="step > 1" class="px-4 py-2 border rounded-lg">Previous</button>
        <button @click="step < 7 ? nextStep() : submit()" class="px-4 py-2 bg-red-500 text-white rounded-lg">
            <span x-text="step < 7 ? 'Next' : 'Submit Event'"></span>
        </button>
    </div>
</div>

<script>
function eventWizard(initialData, initialStep) {
    return {
        step: initialStep,
        maxStepReached: initialStep,
        data: initialData || {},
        saving: false,
        lastSaved: null,
        saveTimeout: null,
        steps: ['Basic Info','Location','Sponsorship','Add-Ons','Audience','Media','Plan'],

        init() {
            // debounce autosave on any change to `data`
            this.$watch('data', () => {
                clearTimeout(this.saveTimeout);
                this.saveTimeout = setTimeout(() => this.saveDraft(), 800);
            });
        },

        async saveDraft() {
            this.saving = true;
            const res = await fetch('{{ route('events.wizard.save') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ data: this.data, current_step: this.step }),
            });
            this.saving = false;
            this.lastSaved = res.ok ? new Date() : this.lastSaved;
        },

        validateStep(n) {
            // minimal client-side gate; server re-validates fully at submit
            if (n === 1) return this.data.title && this.data.description && this.data.category_id && this.data.start_date;
            if (n === 2) return this.data.venue_name && this.data.city;
            if (n === 3) return !!this.data.sponsorship_type;
            return true; // steps 4-6 optional
        },

        nextStep() {
            if (!this.validateStep(this.step)) return alert('Please fill required fields.');
            this.step++;
            this.maxStepReached = Math.max(this.maxStepReached, this.step);
            this.saveDraft();
        },

        previousStep() { this.step--; },

        goToStep(n) { if (n <= this.maxStepReached) this.step = n; },

        async clearDraft() {
            if (!confirm('Clear this draft?')) return;
            await fetch('{{ route('events.wizard.clear') }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            });
            this.data = {}; this.step = 1; this.maxStepReached = 1;
        },

        async submit() {
            if (!this.validateStep(7)) return;
            const res = await fetch('{{ route('events.wizard.submit') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ data: this.data }),
            });
            const json = await res.json();
            if (res.ok) window.location = json.redirect;
        },
    }
}
</script>
```

Each `wizard-steps/*.blade.php` partial just needs inputs bound with `x-model="data.field_name"`, e.g.:
```blade
<input type="text" x-model="data.title" class="w-full border rounded-lg px-4 py-2" placeholder="Enter your event title">
```
For checkbox groups (audience types, industries), bind to an array: `x-model="data.audience_type_ids"` with `<input type="checkbox" value="3" x-model="data.audience_type_ids">`.

---

## 6. Suggested File Structure

```
routes/web.php
app/Http/Controllers/EventWizardController.php
app/Http/Controllers/CityController.php
app/Models/{Event,EventDraft,EventStall,EventFnbOption,EventAdSpace,EventAudience,EventMedia,
            AudienceType,AgeGroup,Industry,Plan,EventSponsorshipLevel}.php
resources/views/events/wizard.blade.php
resources/views/events/wizard-steps/{basic-info,location,sponsorship,add-ons,audience,media,plan}.blade.php
database/migrations/... (one per table above)
database/seeders/{PlanSeeder,AudienceTypeSeeder,AgeGroupSeeder,IndustrySeeder}.php
```

---

## 7. Notes / Recommendations
- Keep validation logic in a single **Form Request or dedicated `EventWizardValidator` class** with per-step rule sets, so you can reuse the same rules for both `saveDraft` (partial, lenient) and `submit` (full, strict).
- Store images via **`Storage::disk('public')`**, using a temp folder while in draft state (`draft-uploads/{draft_id}/...`) and moving them to `events/{event_id}/...` on final submit — this avoids orphaned files if a user abandons the wizard, since you can garbage-collect `draft-uploads/` for drafts older than N days via a scheduled command.
- Enforce the selected plan's `image_limit` server-side in `submit()`, not just client-side.
- For the City typeahead, debounce the Alpine input (300ms) and hit `/api/cities?q=` filtered by the selected country.
- Because `event_drafts.data` is JSON, add a **daily scheduled job** to purge abandoned drafts (e.g. `updated_at < now()->subDays(30)`) to keep the table lean.
