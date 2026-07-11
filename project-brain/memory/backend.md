# Memory — Backend

## Framework
Laravel 12 on PHP 8.2+

## PHP Configuration
- declare(strict_types=1) at top of every class
- PSR-12 coding standards
- Service Layer pattern
- Resource Controllers
- Form Requests for validation
- Policies for authorization
- Spatie Permission for roles

## Key Packages
| Package | Purpose |
|---|---|
| spatie/laravel-permission | Role-based access control |
| laravel/socialite | OAuth (Google, LinkedIn) |
| laravel/scout | Full-text search (ready, not yet active) |
| laravel/reverb | WebSocket broadcasting (real-time chat) |
| laravel/horizon | Queue management (future) |

## Service Layer
```
app/Services/
├── EventService.php
├── SponsorshipService.php
├── PartnerService.php
├── MessageService.php
├── NotificationService.php
├── SearchService.php
├── AnalyticsService.php
├── RoiCalculatorService.php
├── Auth/
│   ├── SocialAuthService.php              # OAuth login linking
│   ├── OtpService.php                     # generate, send, verify OTP
│   ├── SmsService.php                     # SMS gateway (Twilio/MSG91)
│   ├── WhatsAppService.php                # WhatsApp API sender
│   └── EmailVerificationService.php       # signed URL email verification
├── SocialMedia/
│   ├── SocialMediaServiceInterface.php     # Contract
│   ├── LinkedInService.php
│   ├── FacebookService.php
│   ├── InstagramService.php
│   └── YouTubeService.php
├── Search/
│   ├── SeoSearchService.php                # MySQL keyword search
│   ├── AiSearchService.php                 # Vector + LLM search
│   ├── RankingService.php                  # Scoring algorithm
│   ├── CrawlService.php                    # Web crawler
│   └── PostContentGenerator.php            # Auto-generate social posts
└── Jobs/
    ├── PublishSocialPostJob.php
    ├── CrawlWebsiteJob.php
    └── IndexContentJob.php
```

## Middleware
| Middleware | Purpose |
|---|---|
| auth | Authenticated users only |
| role:organizer | Organizer-only routes |
| role:sponsor | Sponsor-only routes |
| role:partner | Partner-only routes |
| role:admin | Admin-only routes |
| verified | Email-verified users only |
