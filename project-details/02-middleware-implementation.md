# EventsDomain — Middleware Implementation Plan

> Middleware architecture and implementation guide. Read `project.md` and `00-project-overview.md` first.

---

## 1. Middleware Architecture Overview

```
Request
    ↓
Global Middleware (runs on every request)
    ↓
Route Middleware (runs on specific routes)
    ↓
Controller
    ↓
Response
```

---

## 2. Global Middleware

Runs on every HTTP request. Defined in `app/Http/Kernel.php` (Laravel 12) or `bootstrap/app.php`.

| Middleware | Priority | Purpose |
|---|---|---|
| `TrustProxies` | 1 | Trust proxy headers (Cloudflare) |
| `PreventRequestsDuringMaintenance` | 2 | 503 during maintenance mode |
| `ValidatePostSize` | 3 | Limit POST body size |
| `TrimStrings` | 4 | Trim whitespace from inputs |
| `ConvertEmptyStringsToNull` | 5 | Convert empty strings to null |
| `AddQueuedCookiesToResponse` | 6 | Add queued cookies |
| `StartSession` | 7 | Start session for auth |
| `ShareErrorsFromSession` | 8 | Share errors with views |
| `VerifyCsrfToken` | 9 | CSRF protection |

---

## 3. Route Middleware

### 3.1 Authentication Middleware

| Middleware | Alias | Purpose |
|---|---|---|
| `Authenticate` | `auth` | Redirect to login if not authenticated |
| `RedirectIfAuthenticated` | `guest` | Redirect to dashboard if already authenticated |

#### Implementation
```php
// app/Http/Middleware/Authenticate.php
class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
```

### 3.2 Role-Based Access Control (Spatie)

| Middleware | Purpose |
|---|---|
| `role:organizer` | Allow only organizers |
| `role:sponsor` | Allow only sponsors |
| `role:partner` | Allow only partners |
| `role:admin` | Allow only admins |
| `role:organizer|sponsor` | Allow multiple roles |
| `permission:create-events` | Check specific permission |

#### Route Group Usage
```php
// routes/web.php

// Organizer routes
Route::middleware(['auth', 'role:organizer'])->prefix('organizer')->group(function () {
    Route::get('/dashboard', [OrganizerDashboardController::class, 'index'])->name('organizer.dashboard');
    Route::resource('events', OrganizerEventController::class);
    // ... more routes
});

// Sponsor routes
Route::middleware(['auth', 'role:sponsor'])->prefix('sponsor')->group(function () {
    Route::get('/dashboard', [SponsorDashboardController::class, 'index'])->name('sponsor.dashboard');
    Route::resource('discover', SponsorDiscoverController::class)->only(['index', 'show']);
    // ... more routes
});

// Partner routes
Route::middleware(['auth', 'role:partner'])->prefix('partner')->group(function () {
    Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('partner.dashboard');
    Route::resource('services', PartnerServiceController::class);
    // ... more routes
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // ... more routes
});
```

### 3.3 Email Verification Middleware

| Middleware | Purpose |
|---|---|
| `verified` | Ensure user has verified email |

```php
Route::middleware(['auth', 'verified'])->group(function () {
    // All authenticated routes require verified email
});
```

---

## 4. Custom Middleware

### 4.1 EnsureProfileComplete

**Purpose:** Force users to complete their profile before accessing the platform.

```php
<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$this->isProfileComplete($user)) {
            return redirect()->route('profile.complete')
                ->with('warning', 'Please complete your profile to continue.');
        }

        return $next($request);
    }

    private function isProfileComplete($user): bool
    {
        // Check if user has completed required profile fields
        if (!$user->profile) {
            return false;
        }

        $requiredFields = ['company_name', 'description', 'location'];

        foreach ($requiredFields as $field) {
            if (empty($user->profile->$field)) {
                return false;
            }
        }

        return true;
    }
}
```

**Register in Kernel:**
```php
// app/Http/Kernel.php
protected $middlewareAliases = [
    'profile.complete' => \App\Http\Middleware\EnsureProfileComplete::class,
];
```

**Usage:**
```php
Route::middleware(['auth', 'profile.complete'])->group(function () {
    // Dashboard routes
});
```

### 4.2 EnsureEventOwnership

**Purpose:** Ensure organizer can only access their own events.

```php
<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Event;

class EnsureEventOwnership
{
    public function handle(Request $request, Closure $next)
    {
        $eventId = $request->route('id') ?? $request->route('event');
        $event = Event::findOrFail($eventId);

        if ($event->organizer_id !== $request->user()->id) {
            abort(403, 'You do not have permission to access this event.');
        }

        // Share event with controller
        request()->merge(['event' => $event]);

        return $next($request);
    }
}
```

### 4.3 EnsureServiceOwnership

**Purpose:** Ensure partner can only access their own services.

```php
<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PartnerService;

class EnsureServiceOwnership
{
    public function handle(Request $request, Closure $next)
    {
        $serviceId = $request->route('id');
        $service = PartnerService::findOrFail($serviceId);

        if ($service->partner_id !== $request->user()->id) {
            abort(403, 'You do not have permission to access this service.');
        }

        request()->merge(['service' => $service]);

        return $next($request);
    }
}
```

### 4.4 LogSearchQueries

**Purpose:** Log all search queries for analytics.

```php
<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SearchLog;

class LogSearchQueries
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('q')) {
            SearchLog::create([
                'query' => $request->q,
                'ip' => $request->ip(),
                'user_id' => $request->user()?->id,
            ]);
        }

        return $next($request);
    }
}
```

### 4.5 RateLimitSearch

**Purpose:** Rate limit search requests to prevent abuse.

```php
<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RateLimitSearch
{
    public function handle(Request $request, Closure $next)
    {
        $key = 'search_limit:' . $request->ip();

        if (Cache::has($key)) {
            return response()->json([
                'error' => 'Too many search requests. Please wait a moment.'
            ], 429);
        }

        Cache::put($key, true, 60); // 1 request per minute

        return $next($request);
    }
}
```

### 4.6 TrackUserBehavior

**Purpose:** Track user behavior for analytics and recommendations.

```php
<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackUserBehavior
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()) {
            // Track page views, events viewed, etc.
            $this->trackActivity($request);
        }

        return $next($request);
    }

    private function trackActivity(Request $request): void
    {
        $user = $request->user();
        $route = $request->route()->getName();

        // Store in session for batch processing
        $activities = session('user_activities', []);
        $activities[] = [
            'route' => $route,
            'timestamp' => now()->toIso8601String(),
        ];
        session(['user_activities' => $activities]);
    }
}
```

### 4.7 AdminIpWhitelist

**Purpose:** Restrict admin access to specific IP addresses.

```php
<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminIpWhitelist
{
    private array $allowedIps = [];

    public function __construct()
    {
        $this->allowedIps = explode(',', config('admin.allowed_ips', ''));
    }

    public function handle(Request $request, Closure $next)
    {
        if (empty($this->allowedIps)) {
            return $next($request); // No IP restriction if empty
        }

        $clientIp = $request->ip();

        if (!in_array($clientIp, $this->allowedIps)) {
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}
```

---

## 5. Middleware Registration

### 5.1 Kernel Registration (Laravel 12)

```php
// app/Http/Kernel.php

// Global middleware (runs on every request)
protected $middleware = [
    \App\Http\Middleware\TrustProxies::class,
    \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
    \App\Http\Middleware\ValidatePostSize::class,
    \App\Http\Middleware\TrimStrings::class,
    \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
];

// Middleware groups
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],

    'api' => [
        \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];

// Route middleware aliases
protected $middlewareAliases = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
    'signed' => \Illuminate\Http\Middleware\ValidateSignature::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

    // Custom middleware
    'role' => \Spatie\Permission\Http\Middleware\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Http\Middleware\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Http\Middleware\RoleOrPermissionMiddleware::class,
    'profile.complete' => \App\Http\Middleware\EnsureProfileComplete::class,
    'event.ownership' => \App\Http\Middleware\EnsureEventOwnership::class,
    'service.ownership' => \App\Http\Middleware\EnsureServiceOwnership::class,
    'search.log' => \App\Http\Middleware\LogSearchQueries::class,
    'search.rate_limit' => \App\Http\Middleware\RateLimitSearch::class,
    'track.behavior' => \App\Http\Middleware\TrackUserBehavior::class,
    'admin.ip' => \App\Http\Middleware\AdminIpWhitelist::class,
];
```

---

## 6. Middleware Application Map

### 6.1 Global Middleware (Every Request)
```
TrustProxies → PreventMaintenance → ValidatePostSize → TrimStrings → ConvertEmpty
```

### 6.2 Web Middleware Group
```
Global Middleware → AddCookies → StartSession → ShareErrors → VerifyCsrf → SubstituteBindings
```

### 6.3 Public Routes
```php
Route::middleware(['web'])->group(function () {
    // Public pages: home, events, blog, contact, about, faq, privacy, terms
    // Guest layout
});
```

### 6.4 Auth Routes
```php
Route::middleware(['web', 'guest'])->group(function () {
    // Login, register, password reset
    // Redirect to dashboard if already authenticated
});
```

### 6.5 Organizer Routes
```php
Route::middleware(['web', 'auth', 'verified', 'role:organizer', 'profile.complete'])->prefix('organizer')->group(function () {
    // Dashboard, events CRUD, packages, sponsors, partners, schedule, gallery, analytics, messages, team, profile, settings
});
```

### 6.6 Sponsor Routes
```php
Route::middleware(['web', 'auth', 'verified', 'role:sponsor', 'profile.complete'])->prefix('sponsor')->group(function () {
    // Dashboard, discover, saved, enquiries, sponsored, messages, notifications, profile, settings
});
```

### 6.7 Partner Routes
```php
Route::middleware(['web', 'auth', 'verified', 'role:partner', 'profile.complete'])->prefix('partner')->group(function () {
    // Dashboard, services CRUD, opportunities, bids, contracts, availability, portfolio, reviews, messages, notifications, profile, settings
});
```

### 6.8 Admin Routes
```php
Route::middleware(['web', 'auth', 'verified', 'role:admin', 'admin.ip'])->prefix('admin')->group(function () {
    // Dashboard, events moderation, users, categories, sponsorships, partners, reports, CMS, roles, settings, logs
});
```

### 6.9 API Routes
```php
Route::middleware(['api', 'throttle:api'])->group(function () {
    // Messages, upload, enquiry, search, filters, ROI calculator
});

Route::middleware(['api', 'search.log', 'search.rate_limit'])->group(function () {
    // Search endpoints only
});
```

---

## 7. Middleware Testing

### 7.1 Unit Tests
```php
// tests/Unit/Middleware/EnsureProfileCompleteTest.php
class EnsureProfileCompleteTest extends TestCase
{
    public function test_redirects_to_profile_when_incomplete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('organizer.dashboard'));

        $response->assertRedirect(route('profile.complete'));
    }

    public function test_allows_when_profile_complete()
    {
        $user = User::factory()->create();
        Profile::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get(route('organizer.dashboard'));

        $response->assertSuccessful();
    }
}
```

### 7.2 Feature Tests
```php
// tests/Feature/Middleware/RoleMiddlewareTest.php
class RoleMiddlewareTest extends TestCase
{
    public function test_organizer_can_access_organizer_routes()
    {
        $user = User::factory()->create();
        $user->assignRole('organizer');
        $this->actingAs($user);

        $response = $this->get(route('organizer.dashboard'));

        $response->assertSuccessful();
    }

    public function test_sponsor_cannot_access_organizer_routes()
    {
        $user = User::factory()->create();
        $user->assignRole('sponsor');
        $this->actingAs($user);

        $response = $this->get(route('organizer.dashboard'));

        $response->assertForbidden();
    }
}
```

---

## 8. Implementation Checklist

### Phase 1: Core Middleware
- [ ] Register global middleware
- [ ] Register web middleware group
- [ ] Register api middleware group
- [ ] Configure Spatie Permission middleware
- [ ] Test authentication middleware
- [ ] Test role middleware

### Phase 2: Custom Middleware
- [ ] Implement EnsureProfileComplete
- [ ] Implement EnsureEventOwnership
- [ ] Implement EnsureServiceOwnership
- [ ] Implement AdminIpWhitelist
- [ ] Test all custom middleware

### Phase 3: Search & Analytics Middleware
- [ ] Implement LogSearchQueries
- [ ] Implement RateLimitSearch
- [ ] Implement TrackUserBehavior
- [ ] Test search logging
- [ ] Test rate limiting

### Phase 4: Testing
- [ ] Unit tests for all middleware
- [ ] Feature tests for role-based access
- [ ] Integration tests for full request flow

---

*Last updated: 2026-06-30*
*This plan governs all middleware implementation. Follow the execution pipeline from project.md Section 24.*
