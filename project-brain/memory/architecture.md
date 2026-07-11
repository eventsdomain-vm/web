# Memory — Architecture

> **Source of truth:** `project.md` Sections 15, 24 (Development Standards, Project Brain).
> This file is a condensed runtime reference. Keep synced with `project.md`.

## Pattern
Laravel 12 monolithic web application with Blade frontend. No SPA. No API-first architecture (except for AJAX endpoints).

## Authentication & Social Auth
- **Registration**: name, email, mobile → OTP (SMS/WhatsApp) or email verification link
- **OTP**: 4-6 digit code, 5-10 min expiry, max 3 retry attempts, 60s resend cooldown
- **OTP Services**: `OtpService` (generate/send/verify) + `SmsService` (Twilio/MSG91) + `WhatsAppService`
- **Email Verification**: Signed URL via Laravel Mail, 30-60 min expiry
- Race limit: 1 OTP/60s per user via `RateLimiter`
- **Laravel Socialite** handles Google + LinkedIn OAuth
- **Account linking**: same email across providers → single user record
- **Social accounts**: per-user connected platforms stored in `social_accounts` table (encrypted tokens)
- Token refresh handled per-platform via `token_expires_at` check

## Social Media Posting
- **Content auto-generation**: `PostContentGenerator` maps event fields → per-platform post structure
- **Manual editing**: User can override auto-generated content before publishing
- **Async posting**: `PublishSocialPostJob` dispatched per platform via Laravel Queue
- **Retry mechanism**: 3 tries with exponential backoff (30s, 120s)
- **Post tracking**: `event_posts` (aggregate) + `post_logs` (per-platform)

## Search Architecture
- **Hybrid search**: SEO (MySQL keyword) + AI (Vector DB + LLM)
- **SEO Engine**: `SeoSearchService` + `RankingService` — full-text search on `pages` table with keyword + title + freshness scoring
- **AI Engine**: `AiSearchService` — embeddings → vector search → LLM answer generation
- **Crawling**: `CrawlService` + `CrawlWebsiteJob` — extracts title, content, meta from target URLs
- **Middleware**: `LogSearchQueries`, `RateLimitSearch`, `TrackUserBehavior`
- **Result fusion**: Merge SEO results (ranked) with AI answer (semantic + citations)

## Partner Marketplace
- **Service listing model**: Partners create services with pricing models (fixed/hourly/negotiable), availability, portfolio
- **Discovery**: Organizers browse/filter services by category, price, rating
- **Booking flow**: Request → quote/accept/reject → contract → review
- **Bidding**: Partners bid on event-specific opportunities posted by organizers
- **Service layer**: `PartnerService` handles core operations

## Communication System
- **Conversation-based messaging**: Conversations with typed participants (direct/sponsorship/partnership), messages with attachments
- **Real-time**: Laravel Reverb for instant message delivery
- **Notifications**: In-app + email, triggered by sponsorship/partner/event status changes
- **Service layer**: `MessageService` + `NotificationService`

## Layers

```
Routes (web.php, api.php)
    ↓
Controllers (thin — delegates to Services)
    ↓
Form Requests (validation + authorization)
    ↓
Services (business logic)
    ↓
Models (Eloquent ORM)
    ↓
Database (MySQL 8 InnoDB)
```

## Frontend Architecture
```
Blade Layouts
    ├── Guest Layout (auth pages)
    ├── Organizer Layout
    ├── Sponsor Layout
    ├── Partner Layout
    └── Admin Layout
        └── Blade Components (reusable)
            └── Alpine.js (client-side state)
```

## Key Principles
- Controllers are thin — logic lives in Service classes
- Form Requests handle validation and authorization gates
- Policies enforce per-model authorization
- Spatie Permission handles role-based access at route/middleware level
- Database transactions for multi-step operations
- Queue jobs for async tasks (email, notifications)
- FULLTEXT indexes for search/discovery
