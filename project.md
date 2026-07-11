# PROJECT.md — Events Domain

> Single source of truth for all AI agents working on this codebase.
> This file replaces repeated codebase analysis. Read this first, always.

---

## 1. Project Identity

| Field | Value |
|---|---|---|
| **Project Name** | Events Domain |
| **Local URL** | `http://vm.site` |
| **Production URL** | `https://eventsdomain.com` |
| **Platform Type** | Connect Events with Brands, Sponsors & Partners |
| **NOT** | An event ticketing system |
| **Core Purpose** | Connect Event Organizers with Sponsors, Partners, and Service Providers |
| **Contact Email** | `eventsdomain.com@gmail.com` |
| **Contact Phone** | `+91 9725098250` |
| **Company** | Events Domain Platform |

---

## 2. Overview

Events Domain is a professional B2B Event Sponsorship & Partnership Marketplace designed to connect Event Organizers, Sponsors, Brands, Corporates, Institutions, Government Bodies, and Service Partners on a single platform.

### Market Position
| Not This | This |
|---|---|
| ❌ Not a ticketing platform | ✅ **Sponsorship & Partnership Intelligence Platform** |
| ❌ Not a social event app | ✅ Focused on sponsorship matchmaking |
| ❌ Not a listing directory | ✅ Multi-role ecosystem with structured categories |

### Differentiation
- **Sponsorship matchmaking** — smart discovery of relevant opportunities
- **Structured event categories** — 3-tier taxonomy (Business, Entertainment, Festivals & Community)
- **Multi-role ecosystem** — Organizers, Sponsors, Partners on one platform
- **Business-first approach** — not consumer entertainment, not social media

### Brand Promise
> **"We make event sponsorship discovery fast, structured, and profitable."**

## 3. Problem Statement

### The Problem
| Pain Point | Description |
|---|---|
| 🎤 **Organizers struggle** | Finding the right sponsors is manual, slow, and unreliable. Cold outreach has < 5% response rate |
| 🏢 **Sponsors lack visibility** | No centralized way to discover relevant events that match their brand, audience, and budget |
| 🤝 **Partnerships are fragmented** | No platform exists for event vendors (venue, sound, media, catering, etc.) to offer services |
| 🔗 **No centralized platform** | Everything is done via emails, spreadsheets, and personal networks |

### The Solution

Events Domain connects three sides of the event ecosystem through a unified marketplace:

```
🎤 Event Organizers    🏢 Sponsors & Brands    🤝 Service Partners
       │                       │                       │
       └───────────────────────┼───────────────────────┘
                               ▼
              Unified Sponsorship & Partnership Platform
```

Events Domain solves this by being the **intermediary marketplace** where:
- Organizers publish sponsorship opportunities and partner requirements
- Sponsors discover events by industry, location, audience, budget, and objectives
- Partners offer services (venue, sound, catering, security, etc.) with flexible pricing models
- Connections happen instantly via platform messaging

---

## 4. How It Works

### Platform Flow
```
Organizers create events & sponsorship packages
             │
             ▼
Sponsors discover relevant opportunities via search & filters
             │
             ▼
Partners offer services (venue, sound, media, catering, security, etc.)
             │
             ▼
Connections happen instantly via in-platform messaging & requests
```

### 3-Step User Journey

| Step | Organizer | Sponsor | Partner |
|---|---|---|---|
| **1. Create / Discover** | List event details, set sponsorship tiers | Browse events by category, budget, location | List services with pricing & availability |
| **2. Connect** | Receive enquiries, review sponsor profiles | Send sponsorship interest or buy packages | Bid on organizer requests, accept contracts |
| **3. Collaborate** | Manage sponsors & partners via dashboard | Track sponsored events & ROI | Fulfill service contracts, get reviews |

---

## 5. Platform Users & Roles

### 5.1 Event Organizer

Creates events and publishes sponsorship opportunities.

**Capabilities:**
- Create / Publish / Draft events
- Build sponsorship packages (Title Sponsor, Powered By, Associate, Stall Space)
- Invite sponsors
- Receive and manage sponsorship requests
- Request services from partners
- Track sponsorship status
- View analytics dashboard
- Manage team members

### 5.2 Sponsors

Includes Brands, Corporate Companies, Institutions, Government Organizations, Brand Owners, and Clients.

**Capabilities:**
- Discover and filter events
- Submit sponsorship interest / inquiries
- Send counter-proposals or buy pre-set packages
- Chat with organizers
- Track sponsored events
- Manage sponsorship budget
- View ROI metrics (impressions, logo placements, activations)

### 5.3 Partners (Vendors, Contractors, Venues)

Service providers: Venue Owners, Sound Providers, Stage Providers, Lighting, Photography, Videography, Security, Catering, Decoration, Printing, Digital Marketing, Influencers, Artists, Anchors, Performers.

**Partnership Models:**
| Model | Description |
|---|---|
| **Cost-Based** | Standard financial quotes |
| **Barter** | Services in exchange for brand placement / event access |
| **Hybrid** | Mix of monetary payment and barter |

**Capabilities:**
- List services with pricing and availability
- Receive partnership requests
- Quote pricing
- Accept barter opportunities
- Manage availability calendar
- Bid on public organizer requests

### 5.4 Admin Panel

Manages the complete platform.

**Responsibilities:**
- User verification and role assignments
- Category management
- Event approval workflow
- Sponsorship moderation
- Partner verification
- CMS management
- Analytics and reports
- Roles & Permissions (Spatie)
- System configuration

---

## 6. Event Categories (3-Tier Taxonomy)

### Business
Conferences, Seminars, Workshops, Trade Shows, Exhibitions, Product Launches, Networking Events, Business Summits, Corporate Meetings, Awards & Recognition, Investor Events

### Entertainment
Music Concerts, Live Shows, Comedy Shows, Theatre & Drama, Fashion Shows, Film Screenings, Nightlife, Esports & Gaming, Sports Events, Fitness & Wellness, Adventure Activities

### Festivals & Community
Music Festivals, Food Festivals, Cultural Festivals, Religious Festivals, Literature Festivals, Art Festivals, Film Festivals, Shopping Festivals, Government Events, Charity & Fundraising, Awareness Campaigns, Career Fairs, Educational Events, Science & Technology Events, Book Fairs, Community Events

---

## 7. Core Modules

| Module | Description |
|---|---|
| **Authentication** | Registration, Login, Social Login (Future), Email Verification, Password Reset, Profile Completion |
| **User Profiles** | Separate profile types: Organizer, Sponsor, Partner |
| **Events** | CRUD, Publish, Draft, Gallery, Schedule, Venue, Audience, Budget, Sponsorship Requirements |
| **Sponsorship** | Packages, Goals, Benefits, Pricing, Available Slots, Branding Opportunities |
| **Partner Marketplace** | Services, Pricing, Availability, Portfolio, Experience, Reviews |
| **Discovery & Search** | FULLTEXT indexing on Category, Location, Industry, Budget, Audience Size, Date, Sponsorship Value, Event Type |
| **Communication** | Direct Messaging, Notifications, Sponsorship/Partnership Requests, Email Notifications |
| **Dashboard** | Separate dashboards: Organizer, Sponsor, Partner, Admin — each with stats, activities, pending items, analytics |
| **ROI Calculator** | Sponsorship ROI estimation with factors: investment, audience, event type, branding benefits, viral potential, celebrity presence, media coverage |

---

## 8. Market Opportunity & Business Model

### Market Opportunity
| Metric | Context |
|---|---|
| 📈 **Events Industry Growth** | Rapid growth globally in live events, conferences, festivals, and brand activations |
| 💰 **Experiential Marketing** | Rising brand spending on experiential marketing and event sponsorships year-over-year |
| 🔍 **Digital Discovery Demand** | Increasing demand for digital platforms to discover sponsorship opportunities |
| 🌏 **Global Reach** | Events across sports, music, business, festivals, and community — all need sponsorship |

### Business Model

| Stream | Description |
|---|---|
| **Featured Event Listings** | Organizers pay for premium placement, featured badges, homepage visibility |
| **Sponsor Promotion Plans** | Brands pay for enhanced profiles, priority matching, advanced analytics |
| **Partner Subscriptions** | Service partners pay for listing services, bidding access, portfolio showcase |
| **Commission on Sponsorships** | Percentage fee on successful sponsorship deals facilitated through platform |
| **Premium Analytics Tools** | Advanced ROI tracking, audience insights, benchmarking reports |

### Target Users
- Event Organizers (conferences, festivals, sports, cultural events)
- Brands & Corporates (seeking sponsorship opportunities)
- Institutions & Government Bodies
- Service Partners (venues, sound, lighting, catering, media, security, etc.)

---

## 9. Vision & Call to Action

### Vision
> **To become the global infrastructure for event sponsorships and partnerships.**

### Call to Action
Join us in transforming how events find sponsors and partners worldwide.

| Role | CTA |
|---|---|
| 🎤 **Event Organizers** | List your event, create sponsorship packages, and attract the right sponsors |
| 🏢 **Sponsors & Brands** | Discover relevant events, connect with organizers, and track your sponsorship ROI |
| 🤝 **Service Partners** | Showcase your services, bid on opportunities, and grow your event business |

---

## 10. Technology Stack

| Layer | Technology |
|---|---|
| **Backend** | Laravel 12, PHP 8.2+, Spatie Permission, Laravel Scout Ready |
| **Frontend** | Blade + Tailwind CSS v3 + Alpine.js 3 + Vite |
| **Database** | MySQL 8, InnoDB, FULLTEXT Search Index |
| **Environment** | XAMPP, Windows, Apache Port 80 |
| **PHP Path** | `C:\xampp\php\php.exe` |

### 10.1 AI Development Skills

| Skill | Purpose | Status |
|---|---|---|
| **tailwind-4-docs** | Comprehensive Tailwind CSS v4 documentation snapshot for answering v4 questions, selecting utilities/variants, configuring Tailwind v4, or migrating from v3 to v4 | Installed |

#### Tailwind CSS v4 Docs Skill

- **Location:** `.agents/skills/tailwind-4-docs/`
- **Source:** `Lombiq/Tailwind-Agent-Skills` (GitHub)
- **Purpose:** Use when answering Tailwind v4 questions, selecting utilities/variants, configuring Tailwind v4, or migrating projects from v3 to v4 with official docs and gotcha checks
- **Requirements:** git, Python 3, internet access (for initial docs snapshot)

**Key Features:**
- Local Tailwind CSS v4 documentation snapshot
- Migration checklist (v3 → v4)
- Engineering playbook for implementation, refactor, and review
- Common gotchas and breaking changes

**Initialization (required once):**
```bash
python .agents/skills/tailwind-4-docs/scripts/sync_tailwind_docs.py --accept-docs-license
```

**Common Entry Points:**
- Migration: `references/docs/upgrade-guide.mdx`, `references/docs/compatibility.mdx`
- Implementation: `references/engineering-playbook.md`
- Gotchas: `references/gotchas.md`
- Configuration: `references/docs/functions-and-directives.mdx`

---

## 11. Authentication System

### Login Options
| Provider | Protocol | Laravel Package |
|---|---|---|
| **Google** | OAuth 2.0 (Gmail) | Socialite `laravel/socialite` |
| **LinkedIn** | OAuth 2.0 (OpenID Connect) | Socialite `laravel/socialite` |

### Implementation Requirements
- Use `Laravel Socialite` for all OAuth integration
- Store: name, email, profile picture, provider name, provider_id
- **Account linking** — if the same email exists from a different provider, link accounts rather than creating duplicates
- Session handling via `Laravel Sanctum` (API) or Laravel Auth (web)
- Email + password registration/login also available (standard Laravel Auth)

### Database Schema (users table additions)
```php
Schema::table('users', function (Blueprint $table) {
    $table->string('avatar')->nullable()->after('email');
    $table->string('provider')->nullable();          // 'google' | 'linkedin'
    $table->string('provider_id')->nullable();
    $table->text('provider_token')->nullable();      // encrypted
    $table->text('provider_refresh_token')->nullable();
});
```

### Account Linking Flow
```
User logs in via Google (first time)
    → Creates account with provider=google
User logs in via LinkedIn (same email)
    → Finds existing user by email
    → Links LinkedIn provider_id to same user record
    → User can now login with either provider
```

### Registration & Verification

#### 1. Registration Flow
Users register with: **Full Name**, **Email Address**, **Mobile Number**. After submission, user must verify identity via one of:

| Method | Channel | Delivery |
|---|---|---|
| **OTP** (preferred) | SMS or WhatsApp | Twilio, MSG91, Fast2SMS |
| **Email Link** | Email | Laravel Mail (signed URL) |

#### 2. OTP Verification
| Setting | Value |
|---|---|
| OTP length | 4–6 digits |
| Expiry | 5–10 minutes |
| Max retry attempts | 3 |
| Backoff | 60s between resends |

```php
Schema::create('otp_verifications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('otp_code');       // hashed
    $table->string('channel');        // sms | whatsapp | email
    $table->timestamp('expires_at');
    $table->integer('attempts')->default(0);
    $table->timestamp('verified_at')->nullable();
    $table->timestamps();
});
```

#### 3. Email Verification
- Generate secure signed verification URL (Laravel signed route)
- Link expires in 30–60 minutes (configurable)
- Uses `Illuminate\Auth\Notifications\VerifyEmail` or custom notification

#### 4. Service Layer
```
app/Services/Auth/
├── OtpService.php                 # generate, send, verify OTP
├── SmsService.php                 # SMS gateway (Twilio/MSG91)
├── WhatsAppService.php            # WhatsApp API sender
└── EmailVerificationService.php   # signed URL email verification
```

```php
class OtpService
{
    public function generate(): string;      // 4-6 digit code
    public function send(User $user, string $channel): void;
    public function verify(User $user, string $code): bool;
}
```

#### 5. API Endpoints
| Method | Path | Purpose |
|---|---|---|
| POST | `/api/register` | Register with name, email, mobile |
| POST | `/api/send-verification` | Resend OTP or email link |
| POST | `/api/verify-otp` | Verify OTP (mobile/email + code) |
| GET | `/api/verify-email/{token}` | Verify signed email link |

#### 6. Security
- OTP hashed before storage (optional but recommended)
- Rate limit: 1 OTP request per 60 seconds (`RateLimiter`)
- Lock account after 3 failed OTP attempts
- Signed URLs for email verification
- All tokens properly expired after use

#### 7. User Experience Flow
```
User registers (name, email, mobile)
    ↓
System sends OTP (SMS/WhatsApp) OR email verification link
    ↓
User enters OTP OR clicks email link
    ↓
System verifies identity
    ↓
Account activated → redirect to dashboard
    ↓
(Optional) Resend OTP button with cooldown timer
```

#### 8. Database Columns (users table additions)
```php
Schema::table('users', function (Blueprint $table) {
    $table->string('mobile')->nullable()->after('email');
    $table->timestamp('mobile_verified_at')->nullable();
    $table->boolean('is_verified')->default(false);
});
```

#### 9. Optional Enhancements
- Resend OTP button with cooldown timer
- Auto-detect country code for mobile
- WhatsApp fallback if SMS fails
- Magic link login (skip OTP after first verification)
- Audit logs for verification attempts

## 12. Event Management System

### Event CRUD
| Field | Type | Rules |
|---|---|---|
| Title | string, 255 | Required, unique per organizer |
| Description | text | Required |
| Date & Time | datetime | Required, must be future |
| Location | string | Required (physical address or virtual link) |
| Banner Image | image (jpeg, png, webp) | Max 2MB, 16:9 ratio |
| Tags | array of strings | Optional, max 5 |
| Category | foreignId | Required, references categories table |

### Event States
```
Draft → Pending Approval → Published → Completed → Archived
                   ↓
               Rejected (with reason)
```

### Organizer Actions
| Action | Description |
|---|---|
| **Create** | Multi-step wizard with validation |
| **Edit** | Modify any field before event goes live |
| **Delete** | Soft delete (only if no active sponsorships) |
| **View List** | Paginated list with status filters (draft/pending/published/completed/archived) |
| **Publish** | Change status from draft → pending approval → published |
| **Unpublish** | Take event offline (hide from public listing) |

### Database Table
```php
Schema::create('events', function (Blueprint $table) {
    $table->id();
    $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete();
    $table->string('title');
    $table->text('description');
    $table->datetime('start_date');
    $table->datetime('end_date')->nullable();
    $table->string('location_type');        // 'physical' | 'virtual' | 'hybrid'
    $table->string('location')->nullable();
    $table->string('banner_image')->nullable();
    $table->json('tags')->nullable();
    $table->foreignId('category_id')->constrained();
    $table->string('status')->default('draft');  // draft, pending, published, completed, archived, rejected
    $table->text('rejection_reason')->nullable();
    $table->softDeletes();
    $table->timestamps();
});
```

---

## 13. Social Media Integration

### Supported Platforms
| Platform | API | OAuth | Scope |
|---|---|---|---|
| **LinkedIn** | LinkedIn Marketing API | OAuth 2.0 | `w_member_social`, `r_liteprofile` |
| **Facebook** | Meta Graph API | OAuth 2.0 | `pages_manage_posts`, `pages_read_engagement` |
| **Instagram** | Meta Graph API (via Facebook Page) | OAuth 2.0 | `instagram_basic`, `instagram_content_publish` |
| **YouTube** | YouTube Data API v3 | OAuth 2.0 | `https://www.googleapis.com/auth/youtube.upload` |

### Database Tables
```php
Schema::create('social_accounts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('provider');              // 'linkedin' | 'facebook' | 'instagram' | 'youtube'
    $table->string('provider_id');
    $table->string('name');                  // account display name
    $table->string('email')->nullable();
    $table->string('avatar')->nullable();
    $table->text('access_token');            // encrypted
    $table->text('refresh_token')->nullable(); // encrypted
    $table->timestamp('token_expires_at')->nullable();
    $table->timestamps();
});

Schema::create('event_posts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->json('platforms');               // ['linkedin', 'facebook', ...]
    $table->json('content');                 // per-platform content {platform: {headline, body, cta_url}}
    $table->string('status')->default('draft'); // draft, scheduled, publishing, published, partial, failed
    $table->timestamp('scheduled_at')->nullable();
    $table->timestamps();
});

Schema::create('post_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_post_id')->constrained()->cascadeOnDelete();
    $table->string('platform');
    $table->string('status');                // success | failed
    $table->text('response')->nullable();
    $table->string('error_message')->nullable();
    $table->string('post_url')->nullable();  // URL of the published post
    $table->timestamp('published_at')->nullable();
    $table->timestamps();
});
```

### Service Layer Architecture
```
app/Services/SocialMedia/
├── SocialMediaServiceInterface.php   (contract)
├── LinkedInService.php
├── FacebookService.php
├── InstagramService.php
└── YouTubeService.php
```

```php
interface SocialMediaServiceInterface
{
    public function post(string $accessToken, array $content): array;
    public function validateToken(string $accessToken): bool;
    public function refreshToken(string $refreshToken): array;
    public function getAccountInfo(string $accessToken): array;
}
```

### Posting Workflow
```
Event Created / Updated
    ↓
Prompt: "Publish to social media?"
    ↓
Yes → Show platform selection (checkboxes for connected accounts)
    ↓
Auto-generate post content per platform:
    Title → Post headline
    Description → Post body
    Event link → CTA URL
    ↓
Allow manual editing per platform (headline, body, CTA)
    ↓
Preview per platform (rendered preview simulating platform appearance)
    ↓
Publish (dispatch queue job per platform)
    ↓
Store post_logs (success/fail per platform with response message)
    ↓
Show summary:
    ✅ LinkedIn — Published
    ✅ Facebook — Published
    ❌ Instagram — Token expired (reconnect required)
    ❌ YouTube — API quota exceeded
```

### Content Auto-Generation
```php
class PostContentGenerator
{
    public function generate(Event $event, string $platform): array
    {
        return match ($platform) {
            'linkedin' => [
                'headline' => $event->title,
                'body' => $event->description . "\n\nJoin us: " . route('events.show', $event),
                'cta_url' => route('events.show', $event),
            ],
            'facebook' => [
                'headline' => $event->title,
                'body' => $event->description,
                'cta_url' => route('events.show', $event),
            ],
            'instagram' => [
                'headline' => null,  // IG uses image + caption
                'body' => Str::limit($event->title . "\n\n" . $event->description, 2200),
                'image' => $event->banner_image,
            ],
            'youtube' => [
                'headline' => $event->title,
                'body' => $event->description . "\n\n" . route('events.show', $event),
            ],
        };
    }
}
```

### Queue & Retry
```php
class PublishSocialPostJob implements ShouldQueue
{
    public $timeout = 120;
    public $tries = 3;
    public $backoff = [30, 120]; // 30s, 120s delay between retries

    public function handle(): void
    {
        // Resolve service based on platform
        // Call service->post()
        // Log result in post_logs
        // On failure: throw exception for retry
    }
}
```

### Social Media Account Management
| Action | Description |
|---|---|
| **Connect** | OAuth flow per platform → store encrypted tokens in `social_accounts` |
| **Disconnect** | Revoke access locally (delete `social_accounts` row) + optionally call platform revoke endpoint |
| **List Connected** | `GET /user/social-accounts` → show provider name, account name, avatar, connection date |
| **Token Refresh** | Check `token_expires_at` on each use; auto-refresh via platform refresh_token endpoint |
| **Rate Limits** | Per-platform throttling (LinkedIn: 100k/day, Meta: 200 calls/hour/user, YouTube: 10k/day) |

### Security
- All OAuth tokens stored **encrypted** (Laravel `encrypt()` / `Crypt::encryptString()`)
- Queue jobs for posting — never block the HTTP request
- Rate limit: max 10 social posts per minute per user
- Validate API payloads per platform before sending
- Log all external API interactions (`post_logs` table)

### Optional Enhancements
- AI-generated captions (via OpenAI/Claude)
- Hashtag suggestions based on event tags
- Scheduled posting (future date/time)
- Analytics dashboard (impressions, clicks, engagement per post per platform)

---

## 14. SEO & AI Search Architecture

### Architecture Overview
```
User Query
    ↓
Middleware (LogSearchQueries, RateLimitSearch, TrackUserBehavior)
    ↓
SearchController
    ↓
├── SeoSearchService (MySQL — keyword match + ranking)
│   └── RankingService (keyword score + title score + freshness + authority)
│
├── AiSearchService (Vector DB + LLM)
│   └── Embedding → Vector Search → LLM Answer Generation
│
└── Result Fusion Layer (merge SEO + AI results)
    ↓
Final Response (JSON or View)
```

### Folder Structure
```
app/
├── Http/Controllers/
│   ├── SearchController.php
│   ├── CrawlController.php
│   └── AiSearchController.php
├── Http/Middleware/
│   ├── LogSearchQueries.php
│   ├── RateLimitSearch.php
│   └── TrackUserBehavior.php
├── Services/
│   ├── SeoSearchService.php
│   ├── AiSearchService.php
│   ├── CrawlService.php
│   └── RankingService.php
├── Jobs/
│   ├── CrawlWebsiteJob.php
│   └── IndexContentJob.php
├── Models/
│   ├── Page.php
│   ├── Keyword.php
│   ├── SearchLog.php
│   └── CrawlJob.php
```

### 14.1 SEO Search (MySQL Engine)

**Database Tables:**
```php
pages: id, url, title, content, meta_description, score (int), image_url, created_at, updated_at
keywords: id, keyword (string), page_id (FK), frequency (int), created_at
backlinks: id, source_url, target_url, authority_score (int)
search_logs: id, query, result_count, duration_ms, created_at
```

**Ranking Algorithm:**
```php
class RankingService
{
    public function score(Page $page, string $query): int
    {
        $keywordMatch = str_contains($page->content, $query) ? 30 : 0;
        $titleMatch = str_contains($page->title, $query) ? 40 : 0;
        $freshness = now()->diffInDays($page->created_at) < 30 ? 10 : 0;

        return $keywordMatch + $titleMatch + $freshness + $page->score;
    }
}
```

### 14.2 AI Search (Vector + LLM)

**Stack Choices:**
| Component | Options |
|---|---|
| Embeddings | OpenAI `text-embedding-3-small`, Ollama `nomic-embed-text` |
| Vector DB | Pinecone, Weaviate, Redis Stack, FAISS |
| LLM | OpenAI GPT-4o, Claude, Ollama LLaMA |

**Service Implementation:**
```php
class AiSearchService
{
    public function search(string $query): array
    {
        $embedding = $this->getEmbedding($query);
        $vectorResults = $this->vectorSearch($embedding, 5);
        return $this->generateAnswer($query, $vectorResults);
    }

    private function getEmbedding(string $text): array { /* OpenAI / Ollama */ }
    private function vectorSearch(array $embedding, int $limit): array { /* Pinecone / Redis */ }
    private function generateAnswer(string $query, array $docs): string { /* GPT / Claude */ }
}
```

### 14.3 Hybrid Search Flow
```
User Query
    ↓
SEO Search (fast, structured, keyword-based)
    ↓
AI Search (semantic, context-aware)
    ↓
Result Fusion Layer
    ├── SEO results sorted by ranking score
    └── AI answer with source citations
    ↓
Final Response: { ai_answer: "...", results: [...seo...] }
```

### 14.4 Crawling System
```php
class CrawlWebsiteJob implements ShouldQueue
{
    public $timeout = 300;

    public function handle(): void
    {
        $html = file_get_contents($this->url);
        $content = $this->extractText($html);
        
        DB::transaction(fn() => Page::create([
            'url' => $this->url,
            'title' => $this->extractTitle($html),
            'content' => $content,
            'meta_description' => $this->extractMeta($html),
        ]));
    }
}
```

### 14.5 Middleware Layer
```php
class LogSearchQueries
{
    public function handle($request, Closure $next)
    {
        SearchLog::create(['query' => $request->q, 'ip' => $request->ip()]);
        return $next($request);
    }
}

class RateLimitSearch
{
    public function handle($request, Closure $next)
    {
        $key = 'search_limit:' . $request->ip();
        if (Cache::has($key)) abort(429, 'Too many search requests');
        Cache::put($key, true, 60);  // 1 request per minute
        return $next($request);
    }
}
```

### 14.6 Search Response Format
```json
{
  "ai_answer": "SEO (Search Engine Optimization) is the process of improving website visibility...",
  "results": [
    {
      "title": "What is SEO",
      "url": "/blog/what-is-seo",
      "snippet": "SEO is the practice of optimizing web pages...",
      "score": 85
    }
  ],
  "query": "what is seo",
  "total": 12,
  "took_ms": 145
}
```

---

## 15. Development Standards

### Lightweight Philosophy
"Every millisecond matters. Every kilobyte matters." The platform must feel instant on mobile, smooth on low-end devices, and focused on business actions.

| Principle | Rule |
|---|---|
| **Blade First** | Laravel Blade is the primary rendering engine. No React/Vue/Angular |
| **Minimal JS** | If it can be done in Blade or CSS → do NOT use JS |
| **Alpine.js Only** | Reserve JS for: dropdowns, modals, tabs, filters, mobile nav, small interactions only |
| **Component-Based UI** | Every reusable UI unit → Blade component. Stateless where possible |
| **Tailwind Purge** | Only compile what is used. Content paths must include all Blade/JS files |

### Backend (Laravel 12 & PHP 8.2+)
- `declare(strict_types=1)` at top of every class
- Spatie Permission enforced at model, controller, and route group middleware levels
- Service Layer pattern — keep controllers thin
- Form Requests for validation
- Policies for authorization
- Resource Controllers
- Eloquent Relationships (no raw SQL unless necessary) — always use `with()` for eager loading
- Database Transactions for multi-step operations
- Queue Jobs for async work
- RESTful Routing
- PSR-12 coding standards
- **Never query inside loops** — use eager loading + collection methods
- **Always paginate** — never load full datasets (`paginate(10-20)` on mobile)
- **N+1 prevention** — `Event::with(['organizer', 'category', 'sponsors'])->paginate(10)`

### Frontend (Tailwind CSS v3 & Alpine.js 3)
- Native Blade views — no SPA framework
- Tailwind utility classes only — no custom CSS unless absolutely necessary
- Alpine.js for client-side reactivity (multi-step forms, dynamic filters, toggles)
- No SPA overhead — handle DOM reactivity locally
- Semantic HTML components
- Clean typography, generous white spacing
- Micro-interactions on CTAs
- **If it can be done in Blade or CSS → do NOT use JS**
- **Heroicons (SVG)** for all UI icons — inline SVGs, no external heavy icon packs
- **Simple CSS transitions only** — no large animation libraries
- **Pure Blade + Tailwind + Alpine** for every UI block

### Database
- MySQL 8 InnoDB engine
- FULLTEXT indexing on: event descriptions, tags, category terms, sponsorship descriptions
- Indexed execution plans for all queries
- Laravel Scout structures prepared for complex full-text querying
- **Keep tables normalized but not over-normalized**
- **Add indexes on:** `event_category_id`, `location`, `event_date`, `sponsorship_status`
- **Avoid** JSON-heavy queries for filters and deep nested joins without caching

#### Full Schema Reference
```sql
-- Users & Auth
users — id, name, email, mobile, password, role (organizer|sponsor|partner|admin), email_verified_at, mobile_verified_at, is_verified, avatar, phone, provider, provider_id, provider_token, provider_refresh_token, created_at, updated_at
profiles — id, user_id, role_type, company_name, description, website, social_links, location, is_verified, created_at, updated_at
otp_verifications — id, user_id, otp_code, channel (sms|whatsapp|email), expires_at, attempts, verified_at, created_at, updated_at

-- Roles (Spatie)
roles — id, name, guard_name, created_at, updated_at
permissions — id, name, guard_name, created_at, updated_at
role_has_permissions — permission_id, role_id
model_has_roles — role_id, model_type, model_id

-- Events
events — id, organizer_id, title, slug, tagline, description, category_id, subcategory_id, event_type (physical|virtual|hybrid), venue, address, city, state, country, start_date, end_date, registration_deadline, expected_audience, audience_description, budget_min, budget_max, sponsorship_type, is_featured, is_published, status (draft|pending|approved|rejected|live|completed|cancelled), views_count, logo, cover_image, banner_image, website_url, video_url, previous_edition_stats, tags, created_at, updated_at
event_gallery — id, event_id, image_url, caption, sort_order, created_at
event_schedule — id, event_id, title, description, start_time, end_time, speaker, venue, sort_order, created_at
event_team — id, event_id, user_id, role, created_at

-- Categories
categories — id, name, slug, icon, parent_id, sort_order, is_active, created_at

-- Sponsorships
sponsorship_packages — id, event_id, title, description, price, slots_available, slots_filled, is_active, sort_order, created_at, updated_at
sponsorship_benefits — id, package_id, benefit_text, created_at
sponsorship_requests — id, event_id, sponsor_id, package_id, status (pending|accepted|rejected|negotiating), custom_proposal, budget_offer, message, created_at, updated_at
sponsorship_contracts — id, request_id, status (active|completed|terminated), terms, amount, start_date, end_date, created_at, updated_at

-- Partners
partner_services — id, partner_id, category_id, title, description, price, price_type (fixed|hourly|negotiable), pricing_model (cost|barter|hybrid), is_available, availability_calendar, min_notice_days, portfolio_images, created_at, updated_at
partner_service_reviews — id, service_id, event_id, organizer_id, rating, review, created_at
partner_requests — id, event_id, organizer_id, service_id, pricing_model, budget, message, status (pending|quoted|accepted|rejected|completed), created_at, updated_at
partner_bids — id, event_id, partner_id, service_id, quote_amount, quote_note, status, created_at

-- Social Media
social_accounts — id, user_id, provider (linkedin|facebook|instagram|youtube), provider_id, name, email, avatar, access_token, refresh_token, token_expires_at, created_at, updated_at
event_posts — id, event_id, user_id, platforms, content, status (draft|scheduled|publishing|published|partial|failed), scheduled_at, created_at, updated_at
post_logs — id, event_post_id, platform, status (success|failed), response, error_message, post_url, published_at, created_at, updated_at

-- Communication
conversations — id, event_id, type (direct|sponsorship|partnership), created_at, updated_at
conversation_participants — id, conversation_id, user_id, last_read_at
messages — id, conversation_id, sender_id, content, attachment_url, read_at, created_at
notifications — id, user_id, type, title, body, data, read_at, created_at

-- Search & AI
pages — id, url, title, content, meta_description, score, image_url, created_at, updated_at
keywords — id, keyword, page_id, frequency, created_at
backlinks — id, source_url, target_url, authority_score, created_at
search_logs — id, query, result_count, duration_ms, ip, created_at
crawl_jobs — id, url, status (pending|processing|completed|failed), depth, pages_crawled, error, started_at, completed_at, created_at

-- Admin & System
activity_logs — id, user_id, event_type, description, properties, created_at
cms_pages — id, title, slug, content, meta_title, meta_description, is_published, created_at, updated_at
platform_settings — id, key, value, created_at, updated_at

-- Indexes
FULLTEXT on: events(title, description, tags), sponsorship_packages(title, description), partner_services(title, description)
B-tree on: foreign keys, status columns, created_at, category_id, city
Composite: (status, is_featured, created_at), (category_id, city, status)
```

### Caching Strategy
```php
// Static data — long TTL
Cache::remember('categories', 86400, fn() => Category::all());
Cache::remember('cities', 86400, fn() => Event::distinct('city')->pluck('city'));

// Dynamic data — short TTL
Cache::remember('events_home', 300, fn() => Event::latest()->take(20)->get());
Cache::remember("dashboard_stats_{$userId}", 300, fn() => ...);
```

| Data | TTL | Invalidation |
|---|---|---|
| Categories, Cities, Settings | 24 hours (86400s) | On admin edit |
| Event listings | 5 minutes (300s) | On event create/update |
| Dashboard stats | 5 minutes (300s) | On any status change |
| Sponsor/Partner lists | 10 minutes (600s) | On profile update |

### Pagination Strategy
- **Default:** `paginate(15)` for all list endpoints
- **Mobile event listings:** `paginate(10)` with infinite scroll
- **Desktop tables:** `paginate(20)` with numbered pagination
- **Never:** `->get()` without `->take()` limit on unbounded queries

### Network Optimization
- Enable gzip compression on Apache/Nginx
- Set HTTP caching headers on static assets (Cache-Control: public, max-age=31536000)
- Combine API calls where possible (batch endpoints)
- Reduce external HTTP requests — self-host fonts/icons where feasible

### Security

| Concern | Rule |
|---|---|
| SQL Injection | Use Eloquent ORM, parameter binding — never raw queries |
| XSS | Use Blade `{{ }}` escaping, never `{!! !!}` without sanitization |
| CSRF | `@csrf` on all forms, `csrf_token()` on AJAX headers |
| Auth | Laravel's built-in auth — never custom auth logic |
| Authorization | Spatie Permission gates + Policies + Form Request `authorize()` |
| Secret Exposure | `.env` only, never commit secrets, use `config/` files |
| Validation | Always Form Requests or `Validator` facade |
| File Upload | Validate mime type + size, store in `storage/app/`, serve via Storage facade |
| Mass Assignment | `$fillable` on all models, never `$guarded` alone |
| Rate Limiting | Apply on all API routes (60/min auth, 30/min guests), auth attempts, form submissions |
| HTTPS | Force in production |
| Passwords | bcrypt hashed (Laravel default), min 8 chars |
| Email Verification | Required for all accounts before platform access |
| Admin Routes | Additional IP whitelist (configurable) |
| Session | HTTP-only, secure, SameSite=Lax |
| OTP | Hashed before storage, max 3 retry attempts, 60s cooldown via `RateLimiter` |

### Testing

| Category | Standard |
|---|---|
| Framework | PHPUnit (Laravel default) |
| Feature Tests | Required for all API endpoints and critical user flows |
| Unit Tests | Required for all Service classes, Form Requests, and Policies |
| Test Naming | `{method}_{scenario}_{expectedBehavior}` — e.g. `test_createEvent_withValidData_returns201()` |
| Database Tests | Use `RefreshDatabase` trait, factory states for test data |
| Coverage Goal | Minimum 70% code coverage for Service layer |
| CI/CD | Tests run on every push (GitHub Actions / GitLab CI) |
| Pre-commit | Run `php artisan test` before every commit |
| HTTP Tests | Test response status, structure, and validation errors |
| Browser Tests | Laravel Dusk for critical user flows (registration, event creation, posting) |

### Route Map Reference

The full route map is maintained in `project-brain/memory/routing.md` (173 routes). Summary by group:

| Group | Routes | Middleware |
|---|---|---|
| Public | Home, events, categories, blog, contact, pages | guest |
| Auth | Login, register, password reset, email verification | guest |
| Organizer | Dashboard, events CRUD, packages, sponsors, partners, schedule, gallery, analytics, messages, team, profile, settings | auth + role:organizer |
| Sponsor | Dashboard, discover, saved, enquiries, sponsored, messages, notifications, profile, settings | auth + role:sponsor |
| Partner | Dashboard, services CRUD, opportunities, bids, contracts, availability, portfolio, reviews, messages, notifications, profile, settings | auth + role:partner |
| Admin | Dashboard, events moderation, users, categories, sponsorships, partners, reports, CMS, roles, settings, logs | auth + role:admin |
| API | Messages (send/fetch/typing), upload, enquiry, search, filters, ROI calculator | varies |
- ❌ Heavy SPA architecture (React/Vue/Angular for this project)
- ❌ Overusing JavaScript (Blade + CSS first)
- ❌ Loading all data at once (always paginate)
- ❌ Large image assets (>200KB per image)
- ❌ Complex animations (simple CSS transitions only)
- ❌ Uncached queries on static/frequently accessed data
- ❌ Duplicate Blade layouts (extend shared components)
- ❌ Multiple CSS frameworks (Tailwind only)
- ❌ External heavy icon packs (use Heroicons SVG inline)
- ❌ Querying inside loops (eager load everything)

### Build & Deploy
```bash
npm run build    # Minified CSS + JS, tree-shaking enabled
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan migrate
```

---

## 16. Design System — Terracotta Theme

| Token | Hex | Usage |
|---|---|---|
| **Primary** | `#E35336` | Core CTAs, highlighted statuses, major emphasis |
| **Secondary** | `#FFB0A1` | Light accent tint, hover states |
| **Dark** | `#9E3A26` | Headers, borders, deep shade |
| **Background** | `#451911` | Heavy contrast, background dark accent |

### UI Principles
- Clean, minimal, professional
- Dashboard-style interface
- Mobile-first responsive design
- Large white space
- Excellent typography
- Accessibility-first
- Cards, dashboards, tables, badges, filters, modern form components

### Icon & Animation Standards
| Standard | Choice |
|---|---|
| **Icon Pack** | Heroicons (SVG) — inline SVGs, no external font-based icon packs |
| **Animations** | Simple CSS transitions only (`transition`, `transform`, `opacity`) |
| **Avoid** | Lottie, GSAP, Framer Motion, or any large animation library |
| **Loaders** | Skeleton UI placeholders (preferred over spinners) |
| **Transitions** | Alpine.js `x-transition` for modals/drawers — native-feel, lightweight |

---

## 17. Mobile Optimization & Responsiveness

### 17.1 Responsive Breakpoints

| Device | Width | Tailwind Prefix |
|---|---|---|
| Mobile Small | 320px | (base) |
| Mobile | 375px | (base) |
| Mobile Large | 425px | `sm:` |
| Tablet | 768px | `md:` |
| Laptop | 1024px | `lg:` |
| Desktop | 1280px | `xl:` |
| Large Desktop | 1536px | `2xl:` |

### 17.2 Mobile-First Design Principles

| Principle | Rule |
|---|---|
| **Mobile First** | Design for mobile screens first; desktop layouts are enhancements, not separate designs. Use base classes for mobile (`w-full`, `flex-col`) and scale up (`md:flex-row`, `lg:grid-cols-3`) |
| **Touch Friendly** | Minimum hit target: **44×44px** for all actionable elements. Adequate spacing between buttons |
| **One-Hand Navigation** | Primary actions (Save, Submit, Contact, Sponsor, Apply, Send Message) near bottom of screen |
| **Performance** | Lazy loading, responsive images, SVG icons, Vite optimized assets, skeleton loading, infinite scrolling where appropriate |

### 17.3 Global Mobile Layout

#### Header
| Desktop | Mobile |
|---|---|
| Logo \| Navigation \| Search \| Notifications \| Profile | ☰ Menu \| Logo \| Search Icon \| Notification \| Avatar |

#### Mobile Navigation (Bottom Tab Bar)
Sticky bottom navigation bar with 5 tabs: **Home** | **Explore** | **Events** | **Messages** | **Profile**

#### Drawer Menu (Hamburger)
- Triggered by ☰ icon in header
- Alpine.js controlled (`x-data="{ mobileMenuOpen: false }"`)
- Slides in as off-canvas drawer (80% width or full-screen)
- Background: `#451911` or `#9E3A26` with white/`#FFB0A1` typography
- Page scroll locked (`overflow-hidden`) when open
- **Contents:** Dashboard, My Events, Sponsors, Partners, Messages, Notifications, Settings, Logout

#### Viewport Configuration
```html
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
```

### 17.4 Responsive Component Specifications

#### Search & Filtering
| Breakpoint | Layout |
|---|---|
| Desktop | Sidebar with all categories & subcategories visible |
| Tablet | Collapsible sidebar |
| Mobile | Sticky bottom action bar / floating button: `"Filter Events (3)"` in Primary `#E35336`. Click → slide-up bottom sheet overlay with all filter options. Alpine.js `x-transition:enter`/`x-transition:leave` for native-feel animations |

#### Tables & Data Views
- Never use horizontal page scrolling for `<table>` elements
- **Desktop:** Standard table inside `overflow-x-auto` container
- **Mobile:** Transform multi-column rows into stacked vertical cards
  - `hidden md:table-row` / `block md:hidden`
- **Admin tables:** Everything becomes responsive cards on mobile

#### Event Listing
| Breakpoint | Layout |
|---|---|
| Desktop | Grid: 3-4 cards with sidebar filters |
| Tablet | Grid: 2 cards |
| Mobile | Single card list, sticky filter button, bottom sheet filters, infinite scroll |

**Each Event Card:** Banner, Category, Location, Date, Audience, Sponsor Needed badge, Organizer, Apply/Favorite/Share buttons

#### Event Detail
| Breakpoint | Layout |
|---|---|
| Desktop | Hero + Gallery + Sidebar + Sponsor Packages + Organizer info |
| Mobile | Image slider → Basic Details → Sponsor Packages → Organizer Card → Partner Requirements → **Sticky Bottom Button:** "Sponsor This Event" |

#### Dashboard
| Breakpoint | Layout |
|---|---|
| Desktop | Cards in 4 columns, Charts, Recent Activity, Quick Actions, Tables |
| Mobile | Cards become vertical, Charts swipeable, Tables become cards, Activity becomes timeline, Quick Actions become grid |

#### Authentication
| Breakpoint | Layout |
|---|---|
| Desktop (Login) | Two-column: Illustration (left) + Login Form (right) |
| Mobile (Login) | Logo → Welcome → Form → Forgot Password → Register link |
| Mobile (Register) | Multi-step wizard: Step 1 Basic Info → Step 2 Business Info → Step 3 Verification → Step 4 Complete Profile |

#### Messaging
| Breakpoint | Layout |
|---|---|
| Desktop | 3-panel: Conversation List \| Chat Window \| Profile |
| Mobile | WhatsApp-style: Conversation List → Chat Screen. Sticky input with Attachment, Voice, Image Upload |

#### Notifications
- Grouped by: Today, Yesterday, This Week
- Unread badge on each group
- Swipe to delete on mobile

#### Search
| Breakpoint | Layout |
|---|---|
| Desktop | Search bar + sidebar filters |
| Mobile | Full-screen search overlay, voice search ready, bottom sheet filter, recent searches, popular searches |

#### Sponsorship Packages
- Cards: Package Name, Price, Benefits, Available Slots, Sponsor Button
- **Mobile:** Horizontal swipeable cards

#### Create Event Wizard (8 Steps)
Each step is mobile-friendly:
1. Basic Details → 2. Venue → 3. Audience → 4. Budget → 5. Sponsors Required → 6. Partners Required → 7. Gallery → 8. Publish

#### Admin Panel
| Breakpoint | Layout |
|---|---|
| Desktop | Sidebar + Content + Widgets |
| Tablet | Collapsible sidebar |
| Mobile | Drawer navigation, cards instead of tables, everything responsive |

#### Profile Pages (All Roles)
| Breakpoint | Layout |
|---|---|
| Desktop | Cover + Profile + Tabs |
| Mobile | Cover → Avatar → Summary → Statistics → Tabs (About, Events, Reviews, Gallery) |

#### Modals
| Breakpoint | Layout |
|---|---|
| Desktop | Centered modal |
| Mobile | Bottom sheet or full-screen modal |

#### File Upload
| Breakpoint | Layout |
|---|---|
| Desktop | Drag & Drop |
| Mobile | Tap to upload, camera support, gallery support |

#### Maps
| Breakpoint | Layout |
|---|---|
| Desktop | Large map + sidebar |
| Mobile | Compact map, expand to full-screen |

#### Calendar
| Breakpoint | Layout |
|---|---|
| Desktop | Month view |
| Mobile | Agenda view or week view, swipe navigation |

#### Charts
| Breakpoint | Layout |
|---|---|
| Desktop | Large charts |
| Mobile | Swipeable charts with summary cards below |

### 17.5 Forms
- Single column on mobile
- Large inputs for touch targets
- Large buttons (minimum 44px height)
- `autocomplete`, `autocapitalize="none"`, appropriate `type="number|email|tel"`
- Bottom sheet selectors instead of dropdowns on mobile
- Date picker optimized for touch

### 17.6 Images & Assets
- Native lazy loading: `loading="lazy"` on all banners and logos
- Responsive images with `srcset`
- WebP format preferred
- Progressive loading with placeholder blur
- SVG icons for UI elements (no raster icons)

### 17.7 Cards & Buttons
| Element | Desktop | Mobile |
|---|---|---|
| Cards | Hover effect | Tap animation, no hover |
| Primary Button | Terracotta `#E35336` | Same + full-width where appropriate |
| Secondary Button | Outline style | Same |
| Danger | Red | Same |
| Success | Green | Same |

### 17.8 Accessibility
- Keyboard navigation support
- Screen reader support (ARIA labels)
- Visible focus states (`focus:ring-2 focus:ring-[#E35336]`)
- Contrast ratio ≥ 4.5:1 for text
- Touch accessibility (adequate spacing)

### 17.9 Performance Targets

| Metric | Target |
|---|---|
| First Contentful Paint (FCP) | < 2s |
| Largest Contentful Paint (LCP) | < 2.5s |
| Cumulative Layout Shift (CLS) | < 0.1 |
| Lighthouse Performance | > 95 |
| Lighthouse Accessibility | > 95 |
| Lighthouse SEO | > 95 |
| Lighthouse Best Practices | > 95 |

### 17.10 Reusable Blade Components for Responsiveness

Create and maintain these responsive Blade components:

```
Navbar, MobileNavigation, Sidebar, BottomNavigation,
Card, Modal, Drawer, TableCard,
FormInput, FormSelect, SearchBox, FilterDrawer,
Pagination, Badge, Avatar, NotificationItem,
EventCard, SponsorCard, PartnerCard,
DashboardWidget, StatisticsCard,
EmptyState, LoadingSkeleton, Toast, ConfirmationDialog
```

### 17.12 Loading Strategy

| Priority | Load Immediately | Lazy Load |
|---|---|---|
| **Critical** | Header, Event list, CTA buttons | — |
| **High** | Page shell, skeleton UI | — |
| **Medium** | — | Images, sponsor logos, partner cards |
| **Low** | — | Analytics charts, historical data |

- **Skeleton UI** — Use lightweight CSS placeholders instead of spinners. No spinner animations on initial load

### 17.13 Event Card Rules (Mobile)
- **Max 1 column** — single-card vertical scroll, no multi-column grids
- **No heavy shadows** — `shadow-sm` max, avoid `shadow-lg`/`shadow-xl`
- **Image size** — target < 200KB per card image. Use WebP + responsive srcset
- **Tap target** — each card is a single tap target (no nested tiny buttons)
- **Info density** — show only: Banner, Category, Location, Date, Audience, Price. Secondary info in detail view

### 17.14 Desktop → Mobile Rendering Strategy

| Feature | Desktop | Mobile |
|---|---|---|
| Tables | Full table with columns | Card layout |
| Filters | Sidebar with all filters | Bottom sheet, tap to open |
| Sidebar | Always visible | Drawer, tap hamburger |
| Modals | Centered overlay | Full screen takeover |
| Charts | Large interactive charts | Simple summary cards + swipe |
| Grids | 3-4 card columns | 1 card column, infinite scroll |

### 17.15 Final Rule
Every new page, Blade view, and admin module **must be fully responsive by default**. No desktop-only layouts are permitted. Responsive behavior must be validated at all defined breakpoints with consistent spacing, typography, and navigation across the entire application.

---

## 18. Landing Page Structure & Naming Strategy

### UI Landing Page Flow

```
┌─────────────────────────────────────────────────┐
│ 1. Hero Section                                 │
│    Headline + Subheading + CTA Buttons          │
│    Search Bar (Events / Sponsors / Partners)    │
├─────────────────────────────────────────────────┤
│ 2. Trust Indicators                             │
│    Events Listed | Sponsors Onboarded |         │
│    Brands Connected | Partnerships Formed       │
├─────────────────────────────────────────────────┤
│ 3. How It Works (3 steps)                       │
│    Create / Discover → Connect → Collaborate    │
├─────────────────────────────────────────────────┤
│ 4. Core Categories                              │
│    Business Events | Entertainment | Community  │
├─────────────────────────────────────────────────┤
│ 5. Featured Events                              │
│    Horizontal scroll cards with key details     │
├─────────────────────────────────────────────────┤
│ 6. Sponsor Section                              │
│    "Find Sponsorship Opportunities"             │
│    Brand logos grid + CTA: Become a Sponsor     │
├─────────────────────────────────────────────────┤
│ 7. Partner Section                              │
│    Service categories (venue, sound, media...)  │
│    CTA: Join as Partner                         │
├─────────────────────────────────────────────────┤
│ 8. Why Events Domain                            │
│    Faster discovery | Verified ecosystem        │
│    Smart filtering | Direct communication       │
├─────────────────────────────────────────────────┤
│ 9. Testimonials (Future)                        │
│    Organizers | Sponsors | Partners             │
├─────────────────────────────────────────────────┤
│ 10. Final CTA Section                           │
│    Start Your Event | Become a Sponsor |        │
│    Join as Partner                              │
└─────────────────────────────────────────────────┘
```

### Mobile Landing Priority
On mobile, sections reorder by importance:
1. Search bar (top, always visible)
2. Categories (quick navigation)
3. Featured events (immediate value)
4. CTA buttons (conversion)

### Naming Strategy
| Module | Name |
|---|---|
| Platform | **Events Domain** |
| Sponsor Module | **Sponsor Hub** |
| Partner Module | **Partner Network** |

### Key Metrics to Display
| Metric | Purpose |
|---|---|
| Events listed | Social proof for organizers |
| Sponsors onboarded | Social proof for brands |
| Partnerships created | Platform activity indicator |
| Cities covered | Geographic reach |

### 18.1 Competitive Improvements (from SponsorshipSearch Analysis)

Based on analysis of sponsorshipsearch.com's event listing, event detail, and page structure, the following improvements have been implemented:

| Area | SponsorshipSearch | EventsDomain Implementation |
|---|---|---|
| **Event Cards** | Base card with category badge, no views | Premium cards with cover image, featured/sponsorship type badges, view count overlay, budget range display |
| **Event Filters** | Country, City, Category, Budget Range, Sponsorship Type | Same filters + Search + Sort (Latest/Popular/Budget High-Low) + Clear button |
| **Event Detail Hero** | Basic header with title | Full hero with cover image background, gradient overlay, category badges, featured badge, sponsorship type badge, view count, budget range, full metadata bar |
| **Event Detail — Target Audience** | Not present | Dedicated section with 3 stat cards (expected attendees, target demographics, geographic reach) + audience profile text |
| **Event Detail — Sidebar** | Basic contact info | Full sidebar: CTA card, event stats table, organizer card with avatar, share buttons (X, Facebook, WhatsApp, Copy Link) |
| **Sponsor Event Detail** | Basic page with description + packages | Premium redesign matching public event detail: hero card, about section, event details grid, target audience, tags, package cards with benefits grid, event stats sidebar, organizer card |
| **Organizer Event Detail** | Basic page with description + packages | Premium redesign with hero card, full details grid, packages with benefits, statistics, sponsorship requests list, actions |
| **Organizer Create/Edit Form** | Single-section form | 4-step wizard layout: Basic Info, Date & Location, Audience & Budget, Media & Branding — with all new fields (sponsorship_type, tags, audience_description, website_url, video_url, registration_deadline) |
| **JSON-LD Structured Data** | Not visible | Full schema.org/Event markup with @@type escape for Blade compatibility |
| **View Count Display** | On event card only | On hero badge, listing card overlay, sidebar stat — everywhere visible |
| **Sort Options** | Newest only | Latest, Most Viewed, Budget High-to-Low, Budget Low-to-High |

### 18.2 Remaining Gaps vs SponsorshipSearch

| Feature | Priority | Notes |
|---|---|---|
| ROI Calculator | Medium | SponsorshipSearch has advanced ROI calculator with 10+ factors — valuable for sponsor decision-making |
| Pricing Tiers | Medium | Their Basic/Featured/Homepage $19-$59 model could generate revenue |
| Blog/Guides | Low | Content marketing for SEO — lower priority than core features |
| Past Events Archive | Low | Simple addition once events have `end_date < now()` |
| Event Gallery Management | Medium | Multi-image upload with categories — needed for premium events |

---

## 19. Competitor Analysis — SponsorshipSearch.com

### 19.1 Overview
- **URL:** https://sponsorshipsearch.com
- **Based in:** Mumbai, Maharashtra, India
- **Managed by:** Ajooba Infotech
- **Size:** ~3 employees, 63 LinkedIn followers
- **Industry:** Marketing Services / B2B Marketplace
- **Tech Stack:** Supabase (storage/database), likely React/Next.js frontend
- **Claim:** "Trusted by 2,500+ Event Organizers"

### 19.2 Competitor Features

#### Public-Facing Pages
| Page | Purpose |
|---|---|
| `/` (Home) | Hero with category/city search, featured events, category browser, how-it-works steps, stats counter |
| `/events` | Event listing with advanced filters (country, city, category, budget range, sponsorship type, level, featured toggle) |
| `/events/{slug}` | Individual event detail page with views counter |
| `/past-events` | Archive of past events |
| `/pricing` | 3-tier pricing: Basic ($19), Featured ($39), Homepage ($59) — one-time per event |
| `/roi-calculator` | Advanced ROI calculator with 10+ factors |
| `/blog` | Content marketing blog with guides |
| `/auth` | Authentication (login/register) |
| `/dashboard` | Organizer dashboard |
| `/contact` | Contact form |
| `/about` | About page |
| `/faq` | FAQ page |
| `/privacy`, `/terms`, `/refund` | Legal pages |

#### How It Works (SponsorshipSearch)
1. **Submit Event** — Fill details, upload images, set sponsorship budget range
2. **Choose a Plan** — Select Basic/Featured/Homepage listing plan
3. **Get Approved** — Event goes live after team approval (~48hrs average)
4. **Get Discovered** — Sponsors browse and find events
5. **Receive Enquiries** — Direct enquiries from sponsors to inbox

#### Pricing Model (SponsorshipSearch)
| Plan | Price | Key Features |
|---|---|---|
| **Basic** | $19/one-time | Event listing, email enquiries, mobile optimized, category placement, basic analytics |
| **Featured** | $39/one-time | + Featured badge, priority search, advanced analytics, social share boost, email support |
| **Homepage** | $59/one-time | + Homepage display, top priority, detailed analytics dashboard, priority support, social media promotion, video showcase |

**Free Listing:** Available if you appoint SponsorshipSearch as exclusive sponsorship partner (pay on results only).

#### ROI Calculator Inputs
- Sponsorship Investment (INR/USD)
- Expected Audience Size
- Event Type, Duration
- City Tier (Tier 1/2/3)
- Venue Type
- Sponsorship Level
- Branding Benefits (12+ types: logo on backdrop, print materials, stage announcements, social media, email, website, video, booth, speaking opportunity, product sampling, merch, category exclusivity)
- Special Factors: Celebrity/VIP presence, Viral potential, Media coverage, Organizer credibility, Past events count, Social following, Sponsor testimonials

#### Event Listing Filters
- Country, City
- Category (11 categories)
- Budget Range (6 tiers from Under ₹1 Lakh to ₹50 Lakhs+)
- Sponsorship Type (Paid, Barter/In-Kind, Paid+Barter)
- Sponsorship Level
- Featured Events Only toggle
- Sort by: Newest

#### Dashboard Flow (SponsorshipSearch — Inferred from URL Structure, Blog, and Pricing)

**Authentication:** `/auth` — Email + Password login, Forgot Password flow, Email Verification via code

**Organizer Dashboard Routes:**
| Route | Purpose |
|---|---|
| `/dashboard` | Main hub — stats overview, recent activity, pending items |
| `/dashboard/events` | List all organizer's events (draft, pending, active, expired) |
| `/dashboard/events/new?plan=basic\|featured\|homepage` | Create new event — plan selection happens at creation time |
| `/dashboard/events/{id}` | Edit/manage specific event |
| `/dashboard/enquiries` | View and respond to sponsor enquiries |
| `/dashboard/analytics` | Event performance analytics (tier-dependent) |
| `/dashboard/profile` | Organizer profile management |
| `/dashboard/settings` | Account settings |

**Sponsor Dashboard Routes (inferred from footer):**
| Route | Purpose |
|---|---|
| `/dashboard` | Main hub — saved events, recent enquiries |
| `/dashboard/saved` | Bookmarked/saved events |
| `/dashboard/enquiries` | Sent enquiries and their status |
| `/dashboard/profile` | Brand/sponsor profile |

**Dashboard Flow — Organizer Journey:**
```
Register/Login
    ↓
Dashboard Home (empty state — CTA to create first event)
    ↓
Create Event (/dashboard/events/new?plan=basic)
    ↓
Step 1: Event Details
    - Event Name
    - Event Description
    - Category (11 categories)
    - Subcategory
    - Event Date(s)
    - Expected Audience Size
    - City / Location
    - Venue Name
    - Event Type (Physical/Virtual/Hybrid)
    ↓
Step 2: Media
    - Upload Event Images (gallery)
    - Upload Logo/Brand Assets
    - Video URL (optional — Homepage plan only)
    ↓
Step 3: Sponsorship Setup
    - Budget Range (Under ₹1L / 1-5L / 5-10L / 10-25L / 25-50L / 50L+)
    - Sponsorship Type (Paid / Barter / Paid+Barter)
    - Sponsorship Tiers (optional — not detailed in public pages)
    - Branding Benefits Included (checklist)
    ↓
Step 4: Plan Selection
    - Basic ($19) / Featured ($39) / Homepage ($59)
    - Payment processing
    ↓
Step 5: Submit for Review
    - Event enters "Pending Approval" state
    - Admin reviews (~48hrs average)
    - Email notification on approval/rejection
    ↓
Event Goes Live
    ↓
Sponsors discover via /events (filters, search)
    ↓
Sponsor sends enquiry (email-based — no in-platform chat)
    ↓
Organizer receives enquiry in /dashboard/enquiries
    ↓
Organizer responds via email (external to platform)
```

**Dashboard Analytics (tier-dependent):**
| Feature | Basic | Featured | Homepage |
|---|---|---|---|
| Basic Analytics | ✅ | ✅ | ✅ |
| Advanced Analytics | ❌ | ✅ | ✅ |
| Detailed Analytics Dashboard | ❌ | ❌ | ✅ |
| Views count on event card | ✅ | ✅ | ✅ |
| Enquiry count | ✅ | ✅ | ✅ |
| Conversion metrics | ❌ | ✅ | ✅ |
| Social share tracking | ❌ | ✅ | ✅ |

**Key Observations about SponsorshipSearch Dashboard:**
1. **Enquiry-based, not chat-based** — Sponsors send enquiries (like email), no real-time messaging
2. **Plan-gated features** — Analytics depth depends on which plan you purchased
3. **No package builder visible** — Events have budget ranges, not structured multi-tier packages
4. **No team/multi-user** — Single organizer per account
5. **No event schedule/agenda** — Just date(s), no detailed schedule management
6. **No gallery management** — Image upload, no structured gallery with categories
7. **No partner/vendor section** — Dashboard is purely Organizer ↔ Sponsor
8. **Manual approval workflow** — Events go through admin review before going live
9. **No draft autosave mentioned** — Unclear if drafts persist
10. **No notification center** — Email-only notifications inferred

### 19.3 Competitor Strengths
- Clean, professional UI with terracotta-adjacent branding
- Advanced ROI calculator with 10+ amplification factors
- Clear 3-tier pricing model
- Blog content marketing (guides for college fests, marathons, etc.)
- Featured event badges and homepage placement as premium upsell
- Free listing option as lead magnet
- Supabase backend for fast deployment

### 19.4 Competitor Weaknesses (Our Opportunities)
- **No Partner/Vendor marketplace** — SponsorshipSearch is Organizer ↔ Sponsor only. No vendor services, no barter system, no service provider profiles
- **No direct messaging** — Only email enquiries, no in-platform chat
- **No real-time notifications** — Email-only communication
- **Limited sponsorship package builder** — No multi-tier package creation with deliverable mapping
- **No team collaboration** — No multi-user organizer dashboards
- **No event schedule/gallery management** — Basic event listing only
- **No ROI tracking post-sponsorship** — Calculator is pre-decision only
- **No verification system for partners** — Only organizer verification mentioned
- **Small team** — 3 employees limits feature velocity
- **No admin panel transparency** — Cannot assess moderation depth

### 19.5 Our Competitive Advantages (Events Domain)
| Feature | SponsorshipSearch | Events Domain |
|---|---|---|
| Partner/Vendor Marketplace | ❌ | ✅ Full marketplace with barter/hybrid |
| In-Platform Chat | ❌ | ✅ Direct messaging |
| Sponsorship Package Builder | Basic | ✅ Multi-tier with deliverable mapping |
| Team Collaboration | ❌ | ✅ Multi-user dashboards |
| Event Schedule/Gallery | ❌ | ✅ Full management |
| Post-Sponsorship ROI | ❌ | ✅ Live tracking |
| Partner Verification | ❌ | ✅ Admin-verified profiles |
| 3 Partnership Models | Paid only | ✅ Paid / Barter / Hybrid |
| Service Provider Profiles | ❌ | ✅ Portfolio, reviews, availability |
| Bidding System | ❌ | ✅ Partners bid on organizer requests |

---

## 20. Events Domain — Dashboard Architecture

### 20.1 Organizer Dashboard

**Routes:**
| Route | Purpose |
|---|---|
| `/organizer/dashboard` | Main hub — stats, activity feed, pending actions |
| `/organizer/events` | All events (draft, pending, active, completed, archived) |
| `/organizer/events/create` | Multi-step event creation wizard |
| `/organizer/events/{id}/edit` | Edit event details |
| `/organizer/events/{id}/packages` | Manage sponsorship packages for this event |
| `/organizer/events/{id}/sponsors` | View/manage sponsor relationships |
| `/organizer/events/{id}/partners` | View/manage partner relationships |
| `/organizer/events/{id}/schedule` | Event schedule/agenda builder |
| `/organizer/events/{id}/gallery` | Event gallery (photos, videos, documents) |
| `/organizer/events/{id}/analytics` | Event performance analytics |
| `/organizer/messages` | Direct messaging inbox |
| `/organizer/notifications` | Notification center |
| `/organizer/team` | Team member management |
| `/organizer/profile` | Organizer profile |
| `/organizer/settings` | Account settings |

**Dashboard Home Widgets:**
```
┌─────────────────────────────────────────────────────────┐
│  Welcome back, {name}                    [Create Event] │
├─────────────┬─────────────┬─────────────┬───────────────┤
│ Active      │ Total       │ Enquiries   │ Sponsorship   │
│ Events: 3   │ Events: 12  │ Pending: 8  │ Value: ₹45L   │
├─────────────┴─────────────┴─────────────┴───────────────┤
│ Recent Activity                                         │
│ • New enquiry from TechCorp for "Startup Expo"         │
│ • Sponsorship confirmed: BrandX → Music Festival       │
│ • Partner request: SoundPro for "Tech Summit"          │
│ • Event "AI Conference" approved and now live          │
├─────────────────────────────────────────────────────────┤
│ Pending Actions                                         │
│ • 3 new sponsorship requests to review                 │
│ • 2 partner bids to evaluate                           │
│ • 1 event pending admin approval                       │
│ • 5 unread messages                                    │
├─────────────────────────────────────────────────────────┤
│ Quick Stats (Last 30 Days)                             │
│ • Profile Views: 234        • Enquiry Conversion: 18%  │
│ • Event Views: 1,847        • Avg Response Time: 4hrs │
└─────────────────────────────────────────────────────────┘
```

**Event Creation Wizard (Multi-Step):**
```
Step 1: Basics
    - Event Name (text)
    - Event Tagline (short subtitle)
    - Category (select from 3-tier taxonomy)
    - Subcategory (dynamic based on category)
    - Event Dates (start + end, recurring support)
    - Registration Deadline
    ↓
Step 2: Location & Audience
    - Venue Name
    - Address (Google Maps integration)
    - City, State, Country
    - Event Type: Physical / Virtual / Hybrid
    - Expected Audience Size (number)
    - Target Audience Description (demographics)
    - Previous Edition (toggle — if yes, show past stats)
    ↓
Step 3: Description & Media
    - Event Description (rich text / markdown)
    - Highlights (bullet points)
    - Event Logo (upload)
    - Cover Image (upload)
    - Gallery Images (multi-upload)
    - Video URL (YouTube/Vimeo embed)
    - Website URL
    - Social Media Links
    ↓
Step 4: Sponsorship Setup
    - Sponsorship Budget Range (select tier)
    - Sponsorship Type: Paid / Barter / Hybrid
    - Sponsorship Packages (multi-tier builder):
        ┌──────────────────────────────────────┐
        │ Package: Title Sponsor               │
        │ Price: ₹10,00,000                    │
        │ Slots Available: 1                   │
        │ Benefits:                            │
        │   ☑ Logo on stage backdrop           │
        │   ☑ Logo on all print materials      │
        │   ☑ Stage naming rights              │
        │   ☑ 10 social media posts            │
        │   ☑ Booth space (20x20)              │
        │   ☑ Speaking opportunity             │
        │   ☑ Category exclusivity             │
        │   ☑ Logo on website                  │
        │   ☑ Email newsletter feature         │
        │   [+ Add More Benefit]               │
        │                                      │
        │ Package: Powered By                  │
        │ Price: ₹5,00,000                     │
        │ ...                                  │
        │                                      │
        │ [+ Add Package]                      │
        └──────────────────────────────────────┘
    - Custom Sponsorship Notes (textarea)
    ↓
Step 5: Team & Partners
    - Add Team Members (email invite)
    - Partner Requirements (services needed):
        ☑ Venue / ☑ Sound / ☑ Lighting / ☑ Catering / ☑ Security
        ☑ Photography / ☑ Videography / ☑ Decoration / ☑ Other
    ↓
Step 6: Review & Submit
    - Preview event listing
    - Select Plan (if monetized)
    - Submit for Admin Approval
    - Save as Draft
```

**Sponsorship Package Builder (Alpine.js Component):**
```html
<!-- Each package is a card with inline editing -->
<!-- Benefits are checkboxes mapped to predefined list -->
<!-- Custom benefits can be added via text input -->
<!-- Drag-and-drop reordering of packages -->
<!-- Price, slots, and validity per package -->
<!-- Real-time preview of how package looks to sponsors -->
```

**Event Listing Card (What Sponsors See):**
```
┌─────────────────────────────────────┐
│ [Event Image]                       │
│                                     │
│ 🏷️ Featured Badge (if applicable)   │
│                                     │
│ Event Name                          │
│ Category > Subcategory              │
│ 📍 City, Country                    │
│ 📅 Start Date - End Date            │
│ 👥 Expected: 5,000 attendees        │
│ 💰 Sponsorship: ₹10-25 Lakhs       │
│ 🏷️ Type: Paid + Barter             │
│                                     │
│ Views: 2,345  Enquiries: 12        │
│                                     │
│ [View Details]  [Send Enquiry]      │
└─────────────────────────────────────┘
```

### 20.2 Sponsor Dashboard

**Routes:**
| Route | Purpose |
|---|---|
| `/sponsor/dashboard` | Main hub — saved events, recommendations, enquiries |
| `/sponsor/discover` | Browse/search events (full filter system) |
| `/sponsor/discover/{event}` | Event detail + send enquiry |
| `/sponsor/saved` | Bookmarked events |
| `/sponsor/enquiries` | Sent enquiries with status tracking |
| `/sponsor/sponsored` | Currently sponsored events + ROI tracking |
| `/sponsor/messages` | Direct messaging inbox |
| `/sponsor/notifications` | Notification center |
| `/sponsor/profile` | Brand profile (industry, budget, goals) |
| `/sponsor/settings` | Account settings |

**Sponsor Dashboard Home:**
```
┌─────────────────────────────────────────────────────────┐
│  Welcome back, {brand_name}                             │
├─────────────┬─────────────┬─────────────┬───────────────┤
│ Saved       │ Active      │ Enquiries   │ Sponsored     │
│ Events: 15  │ Enquiries: 3│ Sent: 7     │ Events: 2     │
├─────────────┴─────────────┴─────────────┴───────────────┤
│ Recommended For You (based on profile + history)        │
│ • Tech Conference Mumbai — matches your industry       │
│ • Startup Expo Delhi — matches your budget range       │
│ • Music Festival Goa — similar to past sponsorships    │
├─────────────────────────────────────────────────────────┤
│ Recent Enquiry Status                                   │
│ • "AI Summit" — Viewed ✅ Responded 💬                 │
│ • "Food Festival" — Pending ⏳                         │
│ • "Sports League" — Accepted ✅                        │
├─────────────────────────────────────────────────────────┤
│ Upcoming Sponsored Events                               │
│ • Tech Summit 2026 — Jul 15 (Booth + Logo)            │
│ • Music Festival — Aug 20 (Stage Naming)               │
└─────────────────────────────────────────────────────────┘
```

### 20.3 Partner Dashboard

**Routes:**
| Route | Purpose |
|---|---|
| `/partner/dashboard` | Main hub — service views, bid opportunities, active contracts |
| `/partner/services` | Manage listed services |
| `/partner/services/create` | Add new service |
| `/partner/opportunities` | Browse organizer requests / open bids |
| `/partner/contracts` | Active and past contracts |
| `/partner/availability` | Calendar-based availability management |
| `/partner/portfolio` | Portfolio showcase |
| `/partner/reviews` | Reviews from organizers |
| `/partner/messages` | Direct messaging inbox |
| `/partner/profile` | Partner/company profile |
| `/partner/settings` | Account settings |

**Partner Dashboard Home:**
```
┌─────────────────────────────────────────────────────────┐
│  Welcome back, {company_name}                           │
├─────────────┬─────────────┬─────────────┬───────────────┤
│ Services    │ Active      │ Bids        │ Monthly       │
│ Listed: 5   │ Contracts: 2│ Pending: 4  │ Earnings: ₹8L │
├─────────────┴─────────────┴─────────────┴───────────────┤
│ Open Opportunities (matching your services)             │
│ • "Startup Expo" needs Sound + Lighting — Bid Now      │
│ • "Music Festival" needs Security — Bid Now            │
│ • "Corporate Summit" needs Catering — Bid Now          │
├─────────────────────────────────────────────────────────┤
│ Active Contracts                                        │
│ • Tech Summit — Sound Setup (Jul 15-17) — ₹1,50,000  │
│ • Wedding Expo — Photography (Aug 5) — ₹45,000       │
├─────────────────────────────────────────────────────────┤
│ Availability This Week                                  │
│ Mon ✅ Tue ✅ Wed ❌ Thu ✅ Fri ✅ Sat ❌ Sun ✅      │
│ [Update Availability]                                   │
└─────────────────────────────────────────────────────────┘
```

### 20.4 Admin Dashboard

**Routes:**
| Route | Purpose |
|---|---|
| `/admin/dashboard` | Platform overview — key metrics, health |
| `/admin/events` | All events (approve, reject, flag) |
| `/admin/events/pending` | Pending approval queue |
| `/admin/users` | User management (organizers, sponsors, partners) |
| `/admin/users/verify` | Verification queue |
| `/admin/categories` | Category/subcategory management |
| `/admin/sponsorships` | Sponsorship oversight |
| `/admin/partners` | Partner verification and listings |
| `/admin/reports` | Platform reports and analytics |
| `/admin/cms` | Content management |
| `/admin/roles` | Roles & Permissions (Spatie) |
| `/admin/settings` | System configuration |
| `/admin/logs` | Audit logs |

**Admin Dashboard Home:**
```
┌─────────────────────────────────────────────────────────┐
│  Admin Dashboard — Events Domain                       │
├─────────────┬─────────────┬─────────────┬───────────────┤
│ Total Users │ Active      │ Revenue     │ Pending       │
│ 1,247       │ Events: 89  │ ₹12.5L/mo   │ Approvals: 7 │
├─────────────┴─────────────┴─────────────┴───────────────┤
│ Approval Queue                                          │
│ • 4 events pending review                               │
│ • 3 partner verifications pending                       │
│ • 2 sponsorship disputes                               │
├─────────────────────────────────────────────────────────┤
│ Platform Health                                         │
│ • Events created this month: 23                        │
│ • Sponsorships facilitated: 12                         │
│ • Partner contracts: 8                                 │
│ • Avg approval time: 18hrs                             │
├─────────────────────────────────────────────────────────┤
│ User Growth (30 days)                                   │
│ • Organizers: +15  • Sponsors: +28  • Partners: +9    │
├─────────────────────────────────────────────────────────┤
│ Recent Flags                                            │
│ • Event "XYZ" reported — inappropriate content         │
│ • Partner "ABC" — verification documents expired       │
└─────────────────────────────────────────────────────────┘
```

### 20.5 Communication System

**Direct Messaging (All Roles):**
```
Organizer ←→ Sponsor: Discuss sponsorship details
Organizer ←→ Partner: Discuss service requirements
Sponsor ←→ Partner: (future — for co-sponsorship)

Message Thread Structure:
├── Thread ID
├── Participants (2+ users)
├── Event Reference (optional)
├── Messages[]
│   ├── Sender ID
│   ├── Content (text + optional file attachment)
│   ├── Timestamp
│   └── Read status
└── Status (active, archived)
```

**Notification System:**
| Trigger | Recipient | Channel |
|---|---|---|
| New enquiry received | Organizer | In-app + Email |
| Enquiry responded to | Sponsor | In-app + Email |
| Sponsorship request accepted | Sponsor | In-app + Email |
| Sponsorship request rejected | Sponsor | In-app + Email |
| Partner bid received | Organizer | In-app + Email |
| Bid accepted | Partner | In-app + Email |
| Event approved by admin | Organizer | In-app + Email |
| Event rejected by admin | Organizer | In-app + Email (with reason) |
| New message received | Participant | In-app |
| Team member added | Organizer | In-app + Email |
| Event going live soon | Organizer | In-app |

---

## 21. Partner Marketplace

### Overview
Partners (vendors, contractors, venues) list services that event organizers can discover, compare, and book. The marketplace uses a service-listing model with bidding and review capabilities.

### Service Management (Partner CRUD)
| Field | Type | Rules |
|---|---|---|
| Title | string | Required |
| Description | text | Required |
| Category | foreignId | Required, references categories |
| Price | decimal | Required |
| Price Type | enum | `fixed` \| `hourly` \| `negotiable` |
| Pricing Model | enum | `cost` \| `barter` \| `hybrid` |
| Availability | boolean | Toggle on/off |
| Availability Calendar | json | Optional blackout dates |
| Min Notice Days | integer | Required |
| Portfolio Images | json | Array of image URLs, max 10 |

### Discovery & Booking Flow
```
Organizer browses partner services (filtered by category, price, rating)
    ↓
Organizer submits service request (message + budget)
    ↓
Partner receives notification → can accept, quote, or reject
    ↓
If accepted → contract formed (terms, amount, dates)
    ↓
After event → organizer leaves review (rating + text)
```

### Partner Bidding
- Partner can bid on event-specific opportunities posted by organizers
- Bid includes: quote amount, notes, timeline
- Organizer can accept/reject bids
- Competitive: multiple partners can bid on the same opportunity

### Database Schema
```sql
partner_services — id, partner_id, category_id, title, description, price, price_type (fixed|hourly|negotiable), pricing_model (cost|barter|hybrid), is_available, availability_calendar, min_notice_days, portfolio_images, created_at, updated_at
partner_service_reviews — id, service_id, event_id, organizer_id, rating, review, created_at
partner_requests — id, event_id, organizer_id, service_id, pricing_model, budget, message, status (pending|quoted|accepted|rejected|completed), created_at, updated_at
partner_bids — id, event_id, partner_id, service_id, quote_amount, quote_note, status, created_at
```

### Routes
```
GET   /partner/services               → PartnerServiceController@index
GET   /partner/services/create        → PartnerServiceController@create
POST  /partner/services               → PartnerServiceController@store
GET   /partner/services/{id}/edit     → PartnerServiceController@edit
PUT   /partner/services/{id}          → PartnerServiceController@update
DELETE/partner/services/{id}          → PartnerServiceController@destroy
GET   /partner/opportunities          → PartnerOpportunityController@index
POST  /partner/opportunities/{id}/bid → PartnerOpportunityController@bid
GET   /partner/contracts              → PartnerContractController@index
GET   /partner/availability           → PartnerAvailabilityController@edit
PUT   /partner/availability           → PartnerAvailabilityController@update
GET   /partner/portfolio              → PartnerPortfolioController@index
POST  /partner/portfolio              → PartnerPortfolioController@store
DELETE/partner/portfolio/{id}         → PartnerPortfolioController@destroy
GET   /partner/reviews                → PartnerReviewController@index
```

### Service Layer
```php
app/Services/PartnerService.php          # Core partner operations
app/Services/SponsorshipService.php      # Core sponsorship operations
```

---

## 22. Communication & Notification System

### Overview
Platform-wide messaging and notification system connecting Organizers, Sponsors, Partners, and Admins via real-time channels and email digests.

### Direct Messaging
| Participants | Purpose |
|---|---|
| Organizer ↔ Sponsor | Discuss sponsorship details, contracts |
| Organizer ↔ Partner | Discuss service requirements, bids |
| Sponsor ↔ Partner | (future — co-sponsorship coordination) |

### Message Architecture
```
Conversation
├── id, type (direct|sponsorship|partnership), event_id (nullable)
├── Participants[]
│   └── user_id, last_read_at
└── Messages[]
    ├── sender_id, content, attachment_url
    ├── read_at, created_at
    └── Reverb event broadcast in real-time
```

### Database Schema
```sql
conversations — id, event_id (nullable), type (direct|sponsorship|partnership), created_at, updated_at
conversation_participants — id, conversation_id, user_id, last_read_at
messages — id, conversation_id, sender_id, content, attachment_url, read_at, created_at
notifications — id, user_id, type, title, body, data (json), read_at, created_at
```

### API Endpoints
```
POST /api/messages/send              → Body: { conversation_id, content, attachment? }
GET  /api/messages/{conversation_id} → Query: ?page=1&per_page=50&before=timestamp
POST /api/messages/typing            → Body: { conversation_id, is_typing }
POST /api/upload                     → Multipart file, returns URL
```

### Notification Triggers
| Trigger | Recipient | Channel |
|---|---|---|
| New enquiry received | Organizer | In-app + Email |
| Enquiry responded to | Sponsor | In-app + Email |
| Sponsorship accepted/rejected | Sponsor | In-app + Email |
| Partner bid received | Organizer | In-app + Email |
| Bid accepted/rejected | Partner | In-app + Email |
| Event approved/rejected | Organizer | In-app + Email |
| New message | Participant | In-app (Reverb) |
| Team member added | Organizer | In-app + Email |

### Service Layer
```php
app/Services/MessageService.php         # Conversation + message logic
app/Services/NotificationService.php    # In-app + email notification dispatch
```

### Technology
- **Real-time**: Laravel Reverb (WebSocket)
- **Email**: Laravel Mail (queue jobs)
- **Attachments**: UploadController → Storage facade → signed URL

---

## 23. AI Development Instructions

When generating code, features, or UI for this project:

- Follow Laravel 12 conventions strictly
- Use Blade + Tailwind CSS + Alpine.js — never introduce React, Vue, or other SPA frameworks
- Maintain modular architecture — Service classes, Form Requests, Policies
- Keep components reusable — Blade components for shared UI
- Prioritize performance and security
- Design for scalability (thousands of events/sponsors/partners)
- Consistent naming conventions (singular models, plural tables, snake_case columns)
- Production-ready features, not prototypes
- Preserve clean, modern, business-focused interface aligned with Terracotta brand
- Enforce strict typing with `declare(strict_types=1)`
- Use database transactions for multi-step operations
- Implement FULLTEXT search for discovery features
- Build for mobile-first responsive experience

---

## 24. Project Brain — AI Runtime Architecture

This section defines how AI agents interact with this codebase. It is NOT part of the application — it is the **engineering runtime** that governs AI behavior.

### 24.1 Core Principles
- Never analyze the entire codebase unless explicitly requested
- Always retrieve only the required context via graph retrieval
- Every prompt follows the same deterministic execution pipeline
- Memory is modular (separate files per domain)
- Graph retrieval is the primary source of project context
- Documentation updates automatically after accepted changes
- Knowledge grows incrementally with every completed task

### 24.2 Execution Pipeline (No Stage May Be Skipped)

```
User Prompt
    ↓
Task Classification
    ↓
Graph Retrieval
    ↓
Load Relevant Memory
    ↓
Planning
    ↓
Execution
    ↓
Static Validation (lint, typecheck, build, tests)
    ↓
AI Review
    ↓
Confidence Scoring (Overall ≥ 90 to accept)
    ↓
Knowledge Synchronization (incremental, not full regeneration)
    ↓
Response
```

### 24.3 Confidence Scoring
| Dimension | Threshold |
|---|---|
| Architecture | ≥ 90 |
| Performance | ≥ 90 |
| Security | ≥ 90 |
| Naming | ≥ 90 |
| Documentation | ≥ 90 |
| Testing | ≥ 90 |
| **Overall** | **≥ 90** |

If Overall < 90 → Improve → Review Again (loop until threshold met).

### 24.4 Static Validation Before AI Review
Always run deterministic tooling first to save tokens:
- `npm run lint`
- `php artisan typecheck` (or equivalent)
- `npm run build`
- `php artisan test` (or relevant test suite)

If any validation fails → skip AI review, return to coding phase.

### 24.5 Knowledge Synchronization Rules
After a task is accepted:
- Only affected knowledge files are updated
- Entire documentation is NEVER regenerated
- Possible updates: `overview.md`, `architecture.md`, `backend.md`, `frontend.md`, `database.md`, `patterns.md`, `mobile.md`, `routing.md`, `api.md`, `dependencies.md`, task history, graph metadata
- Incremental graph updates only (new node → update only connected edges)

---

## 25. File Structure Reference

```
events-domain/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Requests/
│   │   └── Middleware/
│   ├── Models/
│   ├── Services/
│   ├── Policies/
│   └── Exceptions/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── components/      (reusable Blade components)
│   │   ├── layouts/
│   │   ├── organizer/
│   │   ├── sponsor/
│   │   ├── partner/
│   │   ├── admin/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   ├── api.php
│   └── console.php
├── config/
├── public/
├── project-brain/           (AI runtime — NOT application code)
│   ├── system/
│   ├── graph/
│   ├── memory/
│   ├── tasks/
│   ├── standards/
│   ├── reviews/
│   ├── templates/
│   ├── runtime/
│   └── cache/
└── project-details/         (Implementation plans)
    ├── 00-project-overview.md
    ├── 01-frontend-implementation.md
    ├── 02-middleware-implementation.md
    └── 03-backend-implementation.md
```

---

## 26. Quick Reference — Key Decisions

| Decision | Choice | Reason |
|---|---|---|
| SPA vs MPA | MPA (Blade) | Performance, SEO, simplicity, no JS framework overhead |
| CSS Framework | Tailwind CSS v3 | Utility-first, rapid prototyping, consistent design |
| JS Interactivity | Alpine.js 3 | Lightweight, no build step complexity, pairs with Blade |
| Auth | Laravel Breeze / Fortify | Standard, secure, Spatie integration |
| Permissions | Spatie Permission | Industry standard, role-based access control |
| Search | MySQL FULLTEXT + Scout Ready | Full-text indexing for discovery, Scout for future scaling |
| Database | MySQL 8 InnoDB | ACID compliance, FULLTEXT support, reliability |
| Package Builder | Custom (Service + Alpine.js) | Multi-tier with deliverable mapping, real-time state |
| Chat | Laravel Reverb (WebSocket) | Real-time messaging between roles, native Laravel 12 |
| Storage | Local + S3 Ready | Start simple, scale to cloud storage |

---

---

## 27. EventsDomain.com — FAQ & SEO Strategy

### 27.1 FAQ Content (Public-Facing)

#### What is EventsDomain?
EventsDomain is an online marketplace that connects event organizers, sponsors, exhibitors, agencies, venues, and event service providers. Our platform helps organizers showcase events while enabling brands to discover sponsorship opportunities across multiple industries.

#### How does EventsDomain work?
EventsDomain allows event organizers to publish event details and sponsorship opportunities. Sponsors can browse events, evaluate sponsorship packages, contact organizers, and negotiate partnerships directly through the platform.

#### Is EventsDomain free to join?
Yes. Creating an account is free. Depending on your selected plan or premium services, additional features may be available for organizers, sponsors, or business partners.

#### How do I find sponsors for my event?
Create a detailed event profile including:
- Event description
- Target audience
- Expected attendance
- Sponsorship packages
- Brand benefits
- Marketing opportunities

Sponsors searching EventsDomain can discover and contact your event directly.

#### How do sponsors contact event organizers?
Sponsors can submit enquiries, send partnership requests, or communicate using the contact options provided within each event listing.

#### What types of events can be listed?
You can publish almost every professional event including:
- Conferences
- Trade Shows
- Business Summits
- Startup Events
- Tech Events
- Cultural Festivals
- Music Festivals
- Sports Events
- College Fests
- NGO Events
- Community Programs
- Award Ceremonies
- Workshops
- Exhibitions
- Networking Events

#### Can brands search events by category?
Yes. Sponsors can search events using filters like:
- Industry
- Category
- City
- Country
- Budget
- Audience Size
- Event Date
- Sponsorship Type

#### Does EventsDomain guarantee sponsorship?
No. EventsDomain connects organizers with potential sponsors but cannot guarantee sponsorship approval. Sponsorship decisions are made solely between organizers and sponsors.

#### What information should I include in my event listing?
A high-quality listing should include:
- Event overview
- Organizer information
- Event location
- Event dates
- Audience demographics
- Marketing reach
- Sponsorship opportunities
- Available branding assets
- Sponsorship pricing
- Contact details

#### Can international sponsors join?
Yes. Brands and companies from any country can register and explore sponsorship opportunities available worldwide.

#### Who can register on EventsDomain?
Our platform supports:
- Event Organizers
- Sponsors
- Exhibitors
- Venues
- Event Agencies
- Marketing Agencies
- Production Companies
- Event Vendors
- Artists
- Speakers
- Corporate Brands

#### Is my information secure?
Yes. We use secure technology and privacy practices to protect user accounts and business communications.

#### Can I edit my event after publishing?
Yes. Organizers can update event information, sponsorship packages, images, and contact information from their dashboard.

#### How do sponsors choose events?
Sponsors generally evaluate:
- Audience relevance
- Industry
- Brand exposure
- Sponsorship cost
- Marketing value
- Event reputation
- Organizer credibility
- Expected ROI

#### Can I promote multiple events?
Yes. You may manage multiple event listings from a single organizer account.

#### What sponsorship opportunities can I offer?
Examples include:
- Title Sponsor
- Gold Sponsor
- Silver Sponsor
- Bronze Sponsor
- Powered By Partner
- Associate Sponsor
- Digital Partner
- Media Partner
- Hospitality Partner
- Education Partner
- Technology Partner
- Food Partner
- Venue Partner
- Travel Partner
- Gift Partner

#### Why should sponsors use EventsDomain?
EventsDomain helps brands:
- Discover verified event opportunities
- Compare sponsorship packages
- Reach targeted audiences
- Connect directly with organizers
- Save time finding relevant events

#### Why should organizers use EventsDomain?
Organizers gain:
- Increased event visibility
- Sponsor discovery
- Partnership opportunities
- Business networking
- Higher sponsorship potential
- Easy event management

#### How do I get started?
Simply create an account, complete your profile, publish your event or sponsor profile, and begin connecting with potential business partners.

---

### 27.2 FAQ JSON-LD Schema Markup

Recommended FAQ JSON-LD for SEO (10-15 questions is Google's recommended range):

```html
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"FAQPage",
  "mainEntity":[
    {
      "@type":"Question",
      "name":"What is EventsDomain?",
      "acceptedAnswer":{
        "@type":"Answer",
        "text":"EventsDomain is an online marketplace connecting event organizers, sponsors, exhibitors, venues and event service providers to build successful event partnerships."
      }
    },
    {
      "@type":"Question",
      "name":"How does EventsDomain work?",
      "acceptedAnswer":{
        "@type":"Answer",
        "text":"Organizers publish events and sponsorship opportunities while sponsors browse listings, contact organizers and negotiate sponsorship partnerships."
      }
    },
    {
      "@type":"Question",
      "name":"Is EventsDomain free to join?",
      "acceptedAnswer":{
        "@type":"Answer",
        "text":"Yes. Registration is free. Premium plans and additional promotional services may also be available."
      }
    },
    {
      "@type":"Question",
      "name":"How do I find sponsors for my event?",
      "acceptedAnswer":{
        "@type":"Answer",
        "text":"Publish a detailed event profile including audience, sponsorship packages, marketing benefits and event information to attract sponsors."
      }
    },
    {
      "@type":"Question",
      "name":"What types of events can be listed?",
      "acceptedAnswer":{
        "@type":"Answer",
        "text":"You can list conferences, exhibitions, festivals, startup events, sports events, business summits, college fests, workshops, networking events and many more."
      }
    },
    {
      "@type":"Question",
      "name":"Does EventsDomain guarantee sponsorship?",
      "acceptedAnswer":{
        "@type":"Answer",
        "text":"No. EventsDomain facilitates connections between organizers and sponsors but sponsorship decisions remain entirely between both parties."
      }
    },
    {
      "@type":"Question",
      "name":"Can international sponsors join?",
      "acceptedAnswer":{
        "@type":"Answer",
        "text":"Yes. Sponsors and organizers from different countries can register and collaborate on sponsorship opportunities."
      }
    },
    {
      "@type":"Question",
      "name":"Can I edit my event after publishing?",
      "acceptedAnswer":{
        "@type":"Answer",
        "text":"Yes. Organizers can update event details, sponsorship packages, images and contact information from their dashboard."
      }
    },
    {
      "@type":"Question",
      "name":"Can I promote multiple events?",
      "acceptedAnswer":{
        "@type":"Answer",
        "text":"Yes. A single organizer account can manage multiple event listings."
      }
    },
    {
      "@type":"Question",
      "name":"Why should sponsors use EventsDomain?",
      "acceptedAnswer":{
        "@type":"Answer",
        "text":"Sponsors can discover targeted sponsorship opportunities, compare events, connect directly with organizers and maximize brand visibility."
      }
    }
  ]
}
</script>
```

---

### 27.3 SEO Strategy — Competitor-Informed Content Plan

SEO observations from competitor analysis (SponsorshipSearch.com and similar platforms):

The three reference sites focus primarily on transactional keywords such as:
- event sponsorship
- find sponsors
- find events to sponsor
- event organizers
- sponsorship opportunities

Their FAQs center on platform usage, pricing, listings, and sponsor-organizer interactions.

#### Recommended Knowledge Hub Topics for EventsDomain

A stronger SEO strategy builds a knowledge hub around high-intent topics in addition to marketplace pages:

| Content Topic | Target Keyword | Intent |
|---|---|---|
| How to Get Sponsorship for an Event | how to get sponsorship for an event | Informational |
| Event Sponsorship Proposal Template | event sponsorship proposal template | Transactional |
| Sponsorship Letter Examples | sponsorship letter examples | Informational |
| Event Sponsorship Packages | event sponsorship packages | Transactional |
| Corporate Sponsorship Opportunities | corporate sponsorship opportunities | Transactional |
| Event Marketing Guide | event marketing guide | Informational |
| Sponsorship ROI | sponsorship ROI | Informational |
| Event Planning Checklist | event planning checklist | Informational |
| Event Organizer Resources | event organizer resources | Informational |
| Brand Partnership Strategies | brand partnership strategies | Informational |

#### SEO Implementation Priority
1. **FAQ Page** — Implement JSON-LD schema on `/faq` page
2. **Knowledge Hub** — Create `/blog` or `/resources` section with the above topics
3. **Category Landing Pages** — Optimize each event category with unique meta descriptions
4. **Internal Linking** — Link FAQ answers to relevant marketplace pages (events, sponsors, partners)
5. **Schema Markup** — Add Organization, WebSite, and BreadcrumbList schemas alongside FAQPage

---

## 28. EventsDomain India — SEO Keywords (2026)

### 28.1 Top 15 Homepage Keywords

```
event sponsorship
event sponsorship india
find sponsors for events
event sponsorship platform
event sponsorship marketplace
find event sponsors
corporate event sponsorship
brand sponsorship opportunities
event sponsors india
event marketing platform
sponsor an event
event partnership platform
sponsorship opportunities india
event management platform
event sponsorship companies
```

---

### 28.2 Top 15 Event Organizer Keywords

```
how to get sponsors for an event
find sponsors for my event
event sponsorship proposal
event sponsorship proposal template
event sponsorship packages
event sponsorship package examples
event sponsorship deck
event sponsorship brochure
how to ask companies for sponsorship
sponsorship request letter
event sponsorship proposal PDF
college event sponsorship
cultural event sponsorship
school event sponsorship
event funding
```

---

### 28.3 Top 15 Sponsor Keywords

```
events to sponsor
find events to sponsor
corporate sponsorship opportunities
startup event sponsorship
conference sponsorship
college fest sponsorship
music festival sponsorship
sports event sponsorship
business summit sponsorship
tech conference sponsorship
education event sponsorship
brand activation events
festival sponsorship
NGO event sponsorship
marathon sponsorship
```

---

### 28.4 Top 15 Sponsorship Package Keywords

```
event sponsorship packages
event sponsorship package
sample sponsorship package
gold sponsorship package
silver sponsorship package
bronze sponsorship package
title sponsor
powered by sponsor
associate sponsor
presenting sponsor
event sponsorship pricing
event sponsorship levels
corporate sponsorship package
festival sponsorship package
conference sponsorship package
```

---

### 28.5 Top 15 Virtual Event Keywords

```
virtual event sponsorship
virtual event sponsorship package
virtual event sponsorship packages
virtual event sponsorship opportunities
virtual event sponsorship ideas
online conference sponsorship
webinar sponsorship
hybrid event sponsorship
digital sponsorship package
virtual summit sponsorship
online event sponsor
hybrid conference sponsorship
virtual expo sponsorship
digital event marketing
online networking event sponsorship
```

---

### 28.6 Top 15 Festival Event Keywords

```
festival sponsorship
music festival sponsorship
garba event sponsorship
navratri sponsorship
diwali event sponsorship
holi event sponsorship
ganesh utsav sponsorship
durga puja sponsorship
cultural festival sponsorship
food festival sponsorship
film festival sponsorship
art festival sponsorship
college fest sponsorship
religious event sponsorship
community festival sponsorship
```

---

### 28.7 Top 15 College & Education Keywords

```
college fest sponsorship
college event sponsorship
university event sponsorship
campus sponsorship
engineering college fest sponsors
MBA college fest sponsors
technical fest sponsorship
cultural fest sponsorship
hackathon sponsorship
youth festival sponsorship
school event sponsorship
education conference sponsorship
student event sponsorship
college sponsorship opportunities
college festival sponsors
```

---

### 28.8 Top 15 Sports Event Keywords

```
sports event sponsorship
marathon sponsorship
cricket tournament sponsorship
football tournament sponsorship
badminton tournament sponsorship
cycling event sponsorship
running event sponsorship
fitness event sponsorship
sports league sponsorship
kabaddi tournament sponsorship
school sports sponsorship
college sports sponsorship
sports festival sponsorship
esports sponsorship
corporate sports event sponsorship
```

---

### 28.9 Top 15 Startup & Business Keywords

```
startup event sponsorship
startup summit sponsorship
business conference sponsorship
entrepreneur summit sponsorship
tech conference sponsorship
innovation summit sponsorship
networking event sponsorship
startup expo sponsorship
investor summit sponsorship
AI conference sponsorship
developer conference sponsorship
business networking event
leadership summit sponsorship
corporate networking event
innovation event sponsorship
```

---

### 28.10 Top 15 India Location Keywords

```
event sponsorship india
event sponsors mumbai
event sponsors delhi
event sponsors bangalore
event sponsors hyderabad
event sponsors pune
event sponsors chennai
event sponsors ahmedabad
event sponsors kolkata
event sponsors surat
event sponsors jaipur
event sponsors lucknow
event sponsors kochi
event sponsors chandigarh
event sponsors goa
```

---

### 28.11 Top 15 Corporate Brand Keywords

```
corporate sponsorship
corporate event sponsorship
brand partnership
brand sponsorship
brand activation
marketing partnership
CSR sponsorship
business sponsorship
corporate branding events
company sponsorship
B2B sponsorship
B2C sponsorship
event marketing partnership
brand collaboration
promotional partnership
```

---

### 28.12 Top 15 SEO Blog Keywords

```
what is event sponsorship
how to get sponsors
how to write sponsorship proposal
how to ask for sponsorship
how event sponsorship works
event sponsorship benefits
event sponsorship ROI
event sponsorship examples
event sponsorship trends 2026
event marketing guide
festival sponsorship guide
conference sponsorship guide
college fest sponsorship guide
startup sponsorship guide
corporate sponsorship checklist
```

---

### 28.13 Top 15 High-Converting Keywords

```
find sponsors
find event sponsors
find sponsors for college fest
find sponsors for festival
event sponsorship platform
event sponsorship marketplace
best sponsorship platform
corporate event sponsors
festival sponsors
college fest sponsors
conference sponsors
startup event sponsors
music festival sponsors
sports sponsors
brand sponsors
```

---

### 28.14 Top 15 Programmatic SEO Pages

```
Sponsors for Tech Events in Bangalore
Sponsors for College Fest in Ahmedabad
Sponsors for Navratri Events
Sponsors for Garba Events
Sponsors for Startup Events in India
Sponsors for Conferences in Mumbai
Sponsors for Food Festivals
Sponsors for Music Festivals
Sponsors for Marathons
Sponsors for NGO Events
Sponsors for School Events
Sponsors for Cultural Events
Sponsors for Business Summits
Sponsors for Cricket Tournaments
Sponsors for Fashion Shows
```

---

### 28.15 Highest Priority Keywords (Initial SEO Targets)

These are the primary targets for immediate SEO implementation:

```
event sponsorship
event sponsorship india
find sponsors for events
find sponsors for my event
event sponsorship platform
event sponsorship marketplace
festival sponsorship
college fest sponsorship
corporate event sponsorship
music festival sponsorship
startup event sponsorship
conference sponsorship
sports event sponsorship
event sponsorship packages
brand sponsorship opportunities
```

---

### 28.16 Keyword Mapping by Page

| Page | Primary Keywords | Secondary Keywords |
|---|---|---|
| **Homepage** | event sponsorship, event sponsorship platform, find sponsors | event sponsorship india, event sponsorship marketplace, find event sponsors |
| **Events Listing** | find events to sponsor, events to sponsor, event sponsorship | corporate event sponsorship, brand sponsorship opportunities, event sponsors india |
| **Organizer Dashboard** | how to get sponsors, event sponsorship proposal, sponsorship request letter | event sponsorship packages, event sponsorship template, event funding |
| **Sponsor Dashboard** | corporate sponsorship opportunities, events to sponsor | startup event sponsorship, conference sponsorship, college fest sponsorship |
| **Partner Marketplace** | event partners, event services, vendor marketplace | event venue, event catering, event sound system |
| **FAQ Page** | event sponsorship, how event sponsorship works, event sponsorship benefits | event sponsorship platform, find sponsors, sponsorship opportunities |
| **Blog** | event sponsorship trends, how to write sponsorship proposal, event marketing guide | sponsorship ROI, event sponsorship examples, corporate sponsorship checklist |
| **Category Pages** | festival sponsorship, college fest sponsorship, sports event sponsorship | music festival sponsorship, tech conference sponsorship, marathon sponsorship |
| **Location Pages** | event sponsors mumbai, event sponsors delhi, event sponsors bangalore | event sponsors pune, event sponsors chennai, event sponsors hyderabad |

---

## 29. Cloudflare Pages — SEO & _headers Configuration

### 29.1 Domain Configuration

| Domain | Purpose | Indexing |
|---|---|---|
| `https://eventsdomain.com` | Production domain (custom) | ✅ Index |
| `https://eventsdomain.pages.dev` | Cloudflare Pages deployment URL | ❌ Noindex |
| `*.eventsdomain.pages.dev` | Preview deployments | ❌ Noindex |

### 29.2 _headers File

Create `_headers` file in the **public directory** of your project (the output/build directory served by Cloudflare Pages).

```_headers
# =============================================================================
# Cloudflare Pages _headers — SEO Duplicate Content Prevention
# =============================================================================
# Purpose: Block search engines from indexing pages.dev deployment URLs
# while allowing full indexing of the custom production domain.
# =============================================================================

# -----------------------------------------------------------------------------
# Rule 1: Block ALL pages.dev URLs (main + preview deployments)
# -----------------------------------------------------------------------------
# This covers:
#   - eventsdomain.pages.dev (main deployment)
#   - *.eventsdomain.pages.dev (branch preview deployments)
#   - Any other *.pages.dev subdomains
#
# Why: Prevents duplicate content between pages.dev and eventsdomain.com
# Cloudflare Pages preview URLs contain identical content to production.
# Without this, Google indexes both URLs, splitting SEO authority.
# -----------------------------------------------------------------------------
/*
  X-Robots-Tag: noindex, nofollow

# -----------------------------------------------------------------------------
# Rule 2: Explicitly allow indexing on the custom production domain
# -----------------------------------------------------------------------------
# This overrides the catch-all rule above for the custom domain.
# When a request comes through eventsdomain.com, Cloudflare Pages
# applies headers based on the Host header. The /* pattern matches
# all paths, but the custom domain rules take precedence.
#
# Why: Ensures eventsdomain.com is fully indexable and crawlable.
# -----------------------------------------------------------------------------
https://eventsdomain.com/*
  X-Robots-Tag: index, follow

# -----------------------------------------------------------------------------
# Rule 3: Security & Performance Headers (all domains)
# -----------------------------------------------------------------------------
# Best practice headers for all responses.
# -----------------------------------------------------------------------------
/*
  X-Content-Type-Options: nosniff
  X-Frame-Options: DENY
  Referrer-Policy: strict-origin-when-cross-origin
  Permissions-Policy: camera=(), microphone=(), geolocation=()

# -----------------------------------------------------------------------------
# Rule 4: Cache Control for Static Assets
# -----------------------------------------------------------------------------
# Long cache for hashed assets (Vite/webpack output).
# Adjust path pattern based on your build tool.
# -----------------------------------------------------------------------------
/assets/*
  Cache-Control: public, max-age=31536000, immutable

# -----------------------------------------------------------------------------
# Rule 5: HTML Pages — Short Cache
# -----------------------------------------------------------------------------
# HTML pages should have short cache to ensure fresh content
# while still benefiting from edge caching.
# -----------------------------------------------------------------------------
/*.html
  Cache-Control: public, max-age=300, must-revalidate

# -----------------------------------------------------------------------------
# Rule 6: Sitemap & Robots.txt — No Cache
# -----------------------------------------------------------------------------
# These files change frequently and should always be fresh.
# -----------------------------------------------------------------------------
/sitemap.xml
  Cache-Control: no-cache, no-store, must-revalidate

/robots.txt
  Cache-Control: no-cache, no-store, must-revalidate
```

### 29.3 robots.txt File

Create `robots.txt` in the **public directory** to complement the _headers configuration:

```robots.txt
# =============================================================================
# robots.txt — EventsDomain
# =============================================================================
# Allow indexing on production domain only.
# The _headers file handles the noindex for pages.dev URLs.
# This file provides additional crawl guidance.
# =============================================================================

User-agent: *
Allow: /

# Sitemap location (update with your actual sitemap URL)
Sitemap: https://eventsdomain.com/sitemap.xml

# Disallow admin and private paths
Disallow: /admin/
Disallow: /organizer/
Disallow: /sponsor/
Disallow: /partner/
Disallow: /api/
Disallow: /dashboard/
```

### 29.4 File Placement by Framework

| Framework | Location | Notes |
|---|---|---|
| **Static HTML** | Project root `/public/_headers` | Same directory as `index.html` |
| **Astro** | `public/_headers` | Astro serves `public/` at root |
| **Next.js (Static Export)** | `public/_headers` | Works with `output: 'export'` |
| **Next.js (SSR)** | Not applicable — use `next.config.js` headers | See note below |
| **Vite (Vue/React)** | `public/_headers` | Vite serves `public/` at root |
| **Nuxt (Static)** | `public/_headers` | Nuxt 3 serves `public/` at root |
| **Hugo** | `static/_headers` | Hugo copies `static/` to output root |
| **Gatsby** | `static/_headers` | Gatsby copies `static/` to output root |
| **Laravel (Vite)** | `public/_headers` | Laravel serves `public/` at root |

#### Next.js SSR Note

For Next.js SSR (not static export), use `next.config.js` instead:

```js
// next.config.js
module.exports = {
  async headers() {
    return [
      {
        // Block indexing on pages.dev domains
        source: '/:path*',
        has: [
          {
            type: 'host',
            value: 'eventsdomain.pages.dev',
          },
        ],
        headers: [
          { key: 'X-Robots-Tag', value: 'noindex, nofollow' },
        ],
      },
      {
        // Allow indexing on production domain
        source: '/:path*',
        has: [
          {
            type: 'host',
            value: 'eventsdomain.com',
          },
        ],
        headers: [
          { key: 'X-Robots-Tag', value: 'index, follow' },
        ],
      },
    ];
  },
};
```

### 29.5 Additional SEO Best Practices for Cloudflare Pages

#### 1. Redirect pages.dev to Custom Domain (Alternative Approach)

If you prefer redirects over noindex headers, add `_redirects` file:

```_redirects
# Redirect all pages.dev traffic to custom domain
# This is a server-side redirect (301) — search engines follow it
https://eventsdomain.pages.dev/* https://eventsdomain.com/:splat 301!
```

**Warning:** This may break preview deployments for your team. Use noindex headers if you need preview URLs accessible to humans but not search engines.

#### 2. Canonical Tags

Always include canonical tags in your HTML `<head>`:

```html
<!-- On eventsdomain.com — points to itself -->
<link rel="canonical" href="https://eventsdomain.com/current-page" />

<!-- On eventsdomain.pages.dev — points to production domain -->
<link rel="canonical" href="https://eventsdomain.com/current-page" />
```

**Laravel Blade implementation:**

```blade
{{-- resources/views/components/canonical.blade.php --}}
@php
    $path = request()->path();
    $canonical = "https://eventsdomain.com/{$path}";
@endphp
<link rel="canonical" href="{{ $canonical }}" />
```

#### 3. Cloudflare Page Rules (Dashboard)

In the Cloudflare Dashboard, create a Page Rule for the pages.dev domain:

| Setting | Value |
|---|---|
| **URL Pattern** | `eventsdomain.pages.dev/*` |
| **Setting** | SSL: Full |
| **Setting** | Browser Cache TTL: Bypass |

#### 4. Cloudflare Turnstile (Optional)

If using Cloudflare Turnstile for bot protection, it does not affect SEO headers.

#### 5. Structured Data on Custom Domain

Ensure all structured data (JSON-LD) is only served on the custom domain:

```blade
{{-- Only include JSON-LD on production domain --}}
@if(request()->getHost() === 'eventsdomain.com')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [...]
}
</script>
@endif
```

#### 6. Hreflang Tags (Future — Multi-Language)

If expanding to multiple languages:

```html
<link rel="alternate" hreflang="en" href="https://eventsdomain.com/page" />
<link rel="alternate" hreflang="hi" href="https://eventsdomain.com/hi/page" />
<link rel="alternate" hreflang="x-default" href="https://eventsdomain.com/page" />
```

### 29.6 Verification Checklist

After deploying the _headers file:

1. **Test pages.dev noindex:**
   ```bash
   curl -I https://eventsdomain.pages.dev/
   # Should show: X-Robots-Tag: noindex, nofollow
   ```

2. **Test custom domain indexing:**
   ```bash
   curl -I https://eventsdomain.com/
   # Should show: X-Robots-Tag: index, follow
   ```

3. **Google Search Console:**
   - Add both domains as properties
   - Submit sitemap for eventsdomain.com only
   - Use URL Inspection on pages.dev to confirm noindex

4. **Test with Google Rich Results Test:**
   - URL: https://search.google.com/test/rich-results
   - Test pages.dev URL — should show "Page is not indexed"

---

## 30. AdSense Approval & Technical SEO Requirements

### 30.1 Required Pages for AdSense Approval

Google AdSense will reject sites without these four pages. Each must be a **separate MPA route** for best SEO.

| Page | Route | Purpose |
|---|---|---|
| **Privacy Policy** | `/privacy-policy` | Legal compliance, data collection disclosure |
| **Terms & Conditions** | `/terms-and-conditions` | Service terms, user agreements |
| **About Us** | `/about` | Company/mission story, builds trust |
| **Contact Us** | `/contact` | Contact form, email, phone, address |

#### Content Requirements per Page

**Privacy Policy (`/privacy-policy`)**
- What data you collect (cookies, analytics, form submissions)
- How you use the data
- Third-party services (Google Analytics, Google AdSense)
- User rights (GDPR, CCPA compliance)
- Cookie policy
- Data retention periods
- Contact for privacy questions

**Terms & Conditions (`/terms-and-conditions`)**
- Service description
- User responsibilities
- Intellectual property rights
- Limitation of liability
- Dispute resolution
- Governing law
- Modification terms

**About Us (`/about`)**
- Company/mission story
- What EventsDomain does
- Team or founder info (optional but recommended)
- Contact information
- Social proof (logos, stats)

**Contact Us (`/contact`)**
- Contact form (name, email, subject, message)
- Email: `eventsdomain.com@gmail.com`
- Phone: `+91 9725098250`
- Response time expectation
- Physical address (if applicable)
- Social media links

---

### 30.2 Navigation Requirements

AdSense reviewers check that these pages are **clearly accessible** from the homepage.

#### Header Navigation

```blade
{{-- resources/views/components/header.blade.php --}}
<header>
  <nav>
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('events.index') }}">Events</a>
    <a href="{{ route('sponsors.index') }}">Sponsors</a>
    <a href="{{ route('partners.index') }}">Partners</a>
    <a href="{{ route('about') }}">About</a>
    <a href="{{ route('contact') }}">Contact</a>
  </nav>
</header>
```

#### Footer Navigation (Required for AdSense)

```blade
{{-- resources/views/components/footer.blade.php --}}
<footer>
  <div>
    <h4>Platform</h4>
    <a href="{{ route('events.index') }}">Browse Events</a>
    <a href="{{ route('sponsors.index') }}">Find Sponsors</a>
    <a href="{{ route('partners.index') }}">Partners</a>
    <a href="{{ route('faq') }}">FAQ</a>
  </div>
  <div>
    <h4>Company</h4>
    <a href="{{ route('about') }}">About Us</a>
    <a href="{{ route('contact') }}">Contact Us</a>
    <a href="{{ route('blog.index') }}">Blog</a>
  </div>
  <div>
    <h4>Legal</h4>
    <a href="{{ route('privacy') }}">Privacy Policy</a>
    <a href="{{ route('terms') }}">Terms & Conditions</a>
  </div>
  <div>
    <h4>Connect</h4>
    <a href="https://linkedin.com">LinkedIn</a>
    <a href="https://twitter.com">Twitter</a>
    <a href="https://instagram.com">Instagram</a>
  </div>
</footer>
```

---

### 30.3 robots.txt (Complete)

Create `public/robots.txt`:

```txt
# =============================================================================
# robots.txt — EventsDomain.com
# =============================================================================

User-agent: *
Allow: /
Disallow: /admin/
Disallow: /organizer/
Disallow: /sponsor/
Disallow: /partner/
Disallow: /api/
Disallow: /dashboard/

# Sitemap
Sitemap: https://eventsdomain.com/sitemap.xml

# AdSense review: Ensure all required pages are accessible
# Privacy Policy, Terms, About, Contact must NOT be blocked
```

---

### 30.4 sitemap.xml (Complete)

Create `public/sitemap.xml` or generate dynamically:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

  <!-- Main Pages -->
  <url>
    <loc>https://eventsdomain.com/</loc>
    <lastmod>2026-06-30</lastmod>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>https://eventsdomain.com/about</loc>
    <lastmod>2026-06-30</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>https://eventsdomain.com/contact</loc>
    <lastmod>2026-06-30</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc>https://eventsdomain.com/privacy-policy</loc>
    <lastmod>2026-06-30</lastmod>
    <changefreq>yearly</changefreq>
    <priority>0.5</priority>
  </url>
  <url>
    <loc>https://eventsdomain.com/terms-and-conditions</loc>
    <lastmod>2026-06-30</lastmod>
    <changefreq>yearly</changefreq>
    <priority>0.5</priority>
  </url>
  <url>
    <loc>https://eventsdomain.com/faq</loc>
    <lastmod>2026-06-30</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>

  <!-- Events -->
  <url>
    <loc>https://eventsdomain.com/events</loc>
    <lastmod>2026-06-30</lastmod>
    <changefreq>daily</changefreq>
    <priority>0.9</priority>
  </url>

  <!-- Sponsors -->
  <url>
    <loc>https://eventsdomain.com/sponsors</loc>
    <lastmod>2026-06-30</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>

  <!-- Partners -->
  <url>
    <loc>https://eventsdomain.com/partners</loc>
    <lastmod>2026-06-30</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>

  <!-- Blog -->
  <url>
    <loc>https://eventsdomain.com/blog</loc>
    <lastmod>2026-06-30</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>

</urlset>
```

#### Dynamic Sitemap Generation (Laravel)

```php
// app/Services/SitemapService.php
class SitemapService
{
    public function generate(): string
    {
        $urls = collect([
            ['url' => '/', 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['url' => '/about', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/contact', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => '/privacy-policy', 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['url' => '/terms-and-conditions', 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['url' => '/faq', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => '/events', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => '/sponsors', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/partners', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/blog', 'priority' => '0.8', 'changefreq' => 'weekly'],
        ]);

        // Add dynamic event URLs
        Event::where('status', 'published')->each(function ($event) use ($urls) {
            $urls->push([
                'url' => "/events/{$event->slug}",
                'priority' => '0.7',
                'changefreq' => 'monthly',
                'lastmod' => $event->updated_at->format('Y-m-d'),
            ]);
        });

        // Add dynamic blog URLs
        Post::where('is_published', true)->each(function ($post) use ($urls) {
            $urls->push([
                'url' => "/blog/{$post->slug}",
                'priority' => '0.6',
                'changefreq' => 'monthly',
                'lastmod' => $post->updated_at->format('Y-m-d'),
            ]);
        });

        return view('sitemap', ['urls' => $urls])->render();
    }
}
```

**Route:**
```php
Route::get('/sitemap.xml', function () {
    $sitemap = app(SitemapService::class)->generate();
    return response($sitemap, 200)
        ->header('Content-Type', 'application/xml');
});
```

---

### 30.5 Error Pages (404, 500)

#### 404 Page

```blade
{{-- resources/views/errors/404.blade.php --}}
@extends('layouts.app')

@section('title', 'Page Not Found - EventsDomain')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
  <div class="text-center px-6">
    <h1 class="text-9xl font-bold text-[#E35336]">404</h1>
    <h2 class="text-3xl font-semibold text-gray-800 mt-4">Page Not Found</h2>
    <p class="text-gray-600 mt-2">The page you're looking for doesn't exist or has been moved.</p>
    <div class="mt-8 space-x-4">
      <a href="{{ route('home') }}" class="bg-[#E35336] text-white px-6 py-3 rounded-lg hover:bg-[#9E3A26] transition">
        Go Home
      </a>
      <a href="{{ route('events.index') }}" class="border border-[#E35336] text-[#E35336] px-6 py-3 rounded-lg hover:bg-[#FFB0A1] transition">
        Browse Events
      </a>
    </div>
  </div>
</div>
@endsection
```

#### 500 Page

```blade
{{-- resources/views/errors/500.blade.php --}}
@extends('layouts.app')

@section('title', 'Server Error - EventsDomain')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
  <div class="text-center px-6">
    <h1 class="text-9xl font-bold text-[#E35336]">500</h1>
    <h2 class="text-3xl font-semibold text-gray-800 mt-4">Server Error</h2>
    <p class="text-gray-600 mt-2">Something went wrong on our end. Please try again later.</p>
    <div class="mt-8">
      <a href="{{ route('home') }}" class="bg-[#E35336] text-white px-6 py-3 rounded-lg hover:bg-[#9E3A26] transition">
        Go Home
      </a>
    </div>
  </div>
</div>
@endsection
```

**Laravel Exception Handler:**
```php
// app/Exceptions/Handler.php
public function register(): void
{
    $this->renderable(function (NotFoundHttpException $e, $request) {
        if ($request->is('api/*')) {
            return response()->json(['error' => 'Not Found'], 404);
        }
        return response()->view('errors.404', [], 404);
    });

    $this->renderable(function (HttpException $e, $request) {
        if ($request->is('api/*')) {
            return response()->json(['error' => 'Server Error'], 500);
        }
        return response()->view('errors.500', [], 500);
    });
}
```

---

### 30.6 Google Analytics Integration

#### Setup Steps

1. Go to [analytics.google.com](https://analytics.google.com)
2. Create a property for `eventsdomain.com`
3. Get your Measurement ID (format: `G-XXXXXXXXXX`)
4. Add tracking code to the site

#### Tracking Code (Add to Layout)

```blade
{{-- resources/views/layouts/app.blade.php --}}
{{-- Add in <head> section --}}

<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</script>

{{-- Replace G-XXXXXXXXXX with your actual Measurement ID --}}
```

#### Laravel Blade Component

```blade
{{-- resources/views/components/analytics.blade.php --}}
@if(config('app.analytics_enabled'))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('app.analytics_id') }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ config('app.analytics_id') }}');
</script>
@endif
```

**Config:**
```php
// config/app.php
'analytics_enabled' => env('GOOGLE_ANALYTICS_ENABLED', false),
'analytics_id' => env('GOOGLE_ANALYTICS_ID', ''),
```

**.env:**
```
GOOGLE_ANALYTICS_ENABLED=true
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
```

---

### 30.7 Git Workflow for Development

#### Recommended Commit Strategy

| When | Commit Message | Example |
|---|---|---|
| Add new page | `added [page name] page` | `added privacy policy page` |
| Fix bug | `fixed [issue description]` | `fixed header nav on mobile` |
| Update content | `updated [section] content` | `updated about us page` |
| Add feature | `added [feature name]` | `added FAQ section` |
| Deploy | `deployed to production` | `deployed to production` |

#### Git Commands (CLI)

```bash
# Stage all changes
git add .

# Stage specific files
git add resources/views/privacy-policy.blade.php

# Commit with message
git commit -m "added privacy policy page"

# Push to remote
git push origin main

# Check status
git status

# View commit history
git log --oneline -10
```

#### VS Code Source Control Workflow

1. Click the **Git icon** in the left sidebar
2. Review changes in the **Changes** section
3. Click **+** next to files to stage them
4. Enter commit message in the text box
5. Click **Commit** (checkmark icon)
6. Click **Sync Changes** to push

#### Branch Strategy (Recommended)

```
main (production)
  ├── develop (staging)
  │   ├── feature/privacy-policy
  │   ├── feature/terms-page
  │   └── feature/google-analytics
  └── hotfix/fix-nav-bug
```

---

### 30.8 AdSense Approval Checklist

Before applying to Google AdSense:

- [ ] Privacy Policy page created and accessible
- [ ] Terms & Conditions page created and accessible
- [ ] About Us page created and accessible
- [ ] Contact Us page created and accessible
- [ ] All four pages linked in footer
- [ ] All four pages linked in header (or at least footer)
- [ ] robots.txt created with sitemap link
- [ ] sitemap.xml created with all URLs
- [ ] 404 error page created
- [ ] 500 error page created
- [ ] Google Analytics tracking code added
- [ ] Site has sufficient content (10+ pages recommended)
- [ ] Original, valuable content (not thin or copied)
- [ ] Site is fully functional (no broken links)
- [ ] Mobile responsive
- [ ] Fast loading (< 3s)
- [ ] Custom domain connected
- [ ] SSL certificate active (HTTPS)
- [ ] Contact information visible
- [ ] Navigation is clear and accessible

---

*Last updated: 2026-06-30*
*This file is the single source of truth. All AI agents read this first. All changes flow through the execution pipeline.*
