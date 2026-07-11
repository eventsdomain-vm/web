# Memory — Database

> **Note**: Complete schema definitions have been moved to `project.md` Section 15 (Development Standards → Full Schema Reference). This file is now a condensed quick-reference. For authoritative schema, see `project.md`.

## Engine
MySQL 8.0+ InnoDB — all tables

## Key Tables

### Users & Auth
```sql
users — id, name, email, mobile, password, role (organizer|sponsor|partner|admin), email_verified_at, mobile_verified_at, is_verified, avatar, phone, provider, provider_id, provider_token (encrypted), provider_refresh_token (encrypted), created_at, updated_at
profiles — id, user_id, role_type, company_name, description, website, social_links, location, is_verified, created_at, updated_at
role_user — (Spatie) role_id, user_id, model_type
permissions — (Spatie) id, name, guard_name

otp_verifications — id, user_id (FK), otp_code (hashed), channel (sms|whatsapp|email), expires_at, attempts, verified_at, created_at, updated_at
```

### Social Media
```sql
social_accounts — id, user_id, provider (linkedin|facebook|instagram|youtube), provider_id, name, email, avatar, access_token (encrypted), refresh_token (encrypted), token_expires_at, created_at, updated_at

event_posts — id, event_id, user_id, platforms (json), content (json — per-platform headline/body/cta_url), status (draft|scheduled|publishing|published|partial|failed), scheduled_at, created_at, updated_at

post_logs — id, event_post_id, platform, status (success|failed), response, error_message, post_url, published_at, created_at, updated_at
```

### Search & AI
```sql
pages — id, url, title, content, meta_description, score (int), image_url, created_at, updated_at
keywords — id, keyword, page_id (FK), frequency (int), created_at
backlinks — id, source_url, target_url, authority_score (int)
search_logs — id, query, result_count, duration_ms, ip, created_at
crawl_jobs — id, url, status (pending|processing|completed|failed), depth, pages_crawled, error, started_at, completed_at, created_at
```

### Events
```sql
events — id, organizer_id, title, slug, tagline, description, category_id, subcategory_id, event_type (physical|virtual|hybrid), venue, address, city, state, country, start_date, end_date, registration_deadline, expected_audience, audience_description, budget_min, budget_max, sponsorship_type, is_featured, is_published, status (draft|pending|approved|rejected|live|completed|cancelled), views_count, logo, cover_image, website_url, video_url, previous_edition_stats, created_at, updated_at

event_gallery — id, event_id, image_url, caption, sort_order, created_at
event_schedule — id, event_id, title, description, start_time, end_time, speaker, venue, sort_order, created_at
event_team — id, event_id, user_id, role, created_at
```

### Categories
```sql
categories — id, name, slug, icon, parent_id (nullable), sort_order, is_active, created_at
```

### Sponsorships
```sql
sponsorship_packages — id, event_id, title, description, price, slots_available, slots_filled, is_active, sort_order, created_at, updated_at
sponsorship_benefits — id, package_id, benefit_text, created_at

sponsorship_requests — id, event_id, sponsor_id, package_id, status (pending|accepted|rejected|negotiating), custom_proposal, budget_offer, message, created_at, updated_at
sponsorship_contracts — id, request_id, status (active|completed|terminated), terms, amount, start_date, end_date, created_at, updated_at
```

### Partners
```sql
partner_services — id, partner_id, category_id, title, description, price, price_type (fixed|hourly|negotiable), pricing_model (cost|barter|hybrid), is_available, availability_calendar, min_notice_days, portfolio_images, created_at, updated_at
partner_service_reviews — id, service_id, event_id, organizer_id, rating, review, created_at

partner_requests — id, event_id, organizer_id, service_id, pricing_model, budget, message, status (pending|quoted|accepted|rejected|completed), created_at, updated_at
partner_bids — id, event_id, partner_id, service_id, quote_amount, quote_note, status, created_at
```

### Communication
```sql
conversations — id, event_id (nullable), type (direct|sponsorship|partnership), created_at, updated_at
conversation_participants — id, conversation_id, user_id, last_read_at
messages — id, conversation_id, sender_id, content, attachment_url, read_at, created_at

notifications — id, user_id, type, title, body, data (json), read_at, created_at
```

### Admin & System
```sql
activity_logs — id, user_id, event_type, description, properties (json), created_at
cms_pages — id, title, slug, content, meta_title, meta_description, is_published, created_at, updated_at
platform_settings — id, key, value, created_at, updated_at
```

## Indexes
- FULLTEXT on: events(title, description, tags), sponsorship_packages(title, description), partner_services(title, description)
- B-tree on: foreign keys, status columns, created_at, category_id, city
- Composite: (status, is_featured, created_at), (category_id, city, status)

## Migrations
- All migrations in database/migrations/
- Use `php artisan make:migration` for all schema changes
- Always include `up()` and `down()` methods
- Foreign keys use `constrained()->cascadeOnDelete()`
