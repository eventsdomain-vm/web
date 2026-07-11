# Memory — API

## Style
Minimal API surface. Most interactions are server-rendered Blade views. APIs are primarily for AJAX/Alpine.js interactions.

## Endpoints

### Authentication
```
GET /auth/{provider}/redirect ...
POST /auth/link/{provider} ...

POST /api/register
  Body: { name, email, mobile }
  Response: { user_id, message: "Verification code sent" }
  Rate: 3 per minute

POST /api/send-verification
  Body: { user_id, channel: sms|whatsapp|email }
  Response: { message: "Code sent" }
  Rate: 1 per 60 seconds

POST /api/verify-otp
  Body: { user_id, otp_code }
  Response: { verified: true, redirect: "/dashboard" }
  Note: Max 3 attempts, locks account after failures

GET /api/verify-email/{token}
  Query: signed URL (expires 30-60 min)
  Response: Redirect to dashboard on success
```

### Social Accounts
```
GET /user/social-accounts
  Response: [{ id, provider, name, avatar, created_at }]
  Auth: Authenticated

DELETE /user/social-accounts/{id}
  Response: 204 No Content
  Auth: Owner only
  Note: Revokes local token storage

POST /social/{provider}/redirect
  Provider: linkedin | facebook | instagram | youtube
  Response: Redirect to platform OAuth
  Auth: Authenticated

GET /social/{provider}/callback
  Response: { connected: true, account_name }
  Auth: Authenticated
  Note: Stores encrypted tokens in social_accounts
```

### Events (Organizer)
```
POST /events
  Body: { title, description, start_date, end_date, location_type, location, banner_image, tags, category_id }
  Auth: Organizer only

PUT /events/{id}
  Body: { title?, description?, ... }
  Auth: Owner only

DELETE /events/{id}
  Auth: Owner only
  Note: Soft delete (fails if active sponsorships)

PATCH /events/{id}/publish
  Auth: Owner only
  Note: draft → pending → published

PATCH /events/{id}/unpublish
  Auth: Owner only
```

### Social Posts
```
POST /events/{id}/posts
  Body: { platforms: [...], content: { platform: { headline, body, cta_url } }, scheduled_at? }
  Response: { post_id, status: "queued" }
  Auth: Event owner
  Note: Dispatches PublishSocialPostJob per platform

GET /events/{id}/posts
  Response: [{ id, platforms, status, post_logs: [...] }]
  Auth: Event owner

POST /events/{id}/posts/{postId}/regenerate
  Body: { platforms: [...] }
  Response: { content: { platform: { headline, body, cta_url } } }
  Note: AI-regenerate post content

GET /events/{id}/posts/{postId}/preview/{platform}
  Response: { rendered_preview_html }
```

### Messages (Real-time)
```
POST /api/messages/send
  Body: { conversation_id, content, attachment? }
  Response: { message: {...}, conversation_id }
  Auth: Any authenticated user (participant check)
  Rate: 30 per minute

GET /api/messages/{conversation_id}
  Query: ?page=1&per_page=50&before=timestamp
  Response: { messages: [...], has_more: bool }
  Auth: Conversation participant

POST /api/messages/typing
  Body: { conversation_id, is_typing: bool }
  Response: 204 No Content
  Broadcasting: Laravel Reverb event
```

### Search
```
GET /api/search/events
  Query: ?q=keyword&category=X&city=Y&budget_min=Z&budget_max=W&type=paid|barter|hybrid&page=1
  Response: { data: [...], pagination: {...} }
```

### Upload
```
POST /api/upload
  Body: multipart/form-data file
  Response: { url: "https://...", filename: "..." }
  Max: 10MB per file
  Types: jpg, png, webp, pdf, mp4
```

### Enquiry (from Sponsor to Organizer)
```
POST /api/enquiry/send
  Body: { event_id, message, package_id?, budget_offer? }
  Response: { success: true, enquiry_id }
  Auth: Sponsor only
```

### ROI Calculator
```
POST /api/roi/calculate
  Body: { investment, audience_size, event_type, duration, city_tier, venue_type, sponsorship_level, benefits: [...], celebrity, viral_potential, media_coverage, organizer_verified, past_events, social_following, testimonials }
  Response: { roi_percentage, estimated_impressions, estimated_reach, score }
  Auth: None (public)
```

### Filters
```
GET /api/filters/categories
  Response: [{ id, name, slug, children: [...] }]

GET /api/filters/cities
  Response: ["Mumbai", "Delhi", "Bangalore", ...]
```
