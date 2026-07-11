# Memory — Project Overview

> **Source of truth:** `project.md` Sections 1-9 (Identity, Overview, Problem, How It Works, Users, Categories, Modules, Market, Vision).
> This file is a condensed runtime reference. For full details, read `project.md` first.
> Keep this synced with `project.md` when updating project identity.

## Project Name
Events Domain

## URL
- Local: http://vm.site
- Production: https://eventsdomain.com

## Contact
- Email: eventsdomain.com@gmail.com
- Phone: +91 9725098250

## Platform Type
Connect Events with Brands, Sponsors & Partners

## Overview
Events Domain is a professional B2B Event Sponsorship & Partnership Marketplace designed to connect Event Organizers, Sponsors, Brands, Corporates, Institutions, Government Bodies, and Service Partners on a single platform.

## Market Position
- ❌ NOT a ticketing platform
- ❌ NOT a social event app
- ❌ NOT a listing directory
- ✅ Sponsorship & Partnership Intelligence Platform
- ✅ Sponsorship matchmaking with structured categories
- ✅ Multi-role ecosystem (Organizers + Sponsors + Partners)
- ✅ Business-first approach (not consumer entertainment)

## Brand Promise
"We make event sponsorship discovery fast, structured, and profitable."

## Vision
To become the global infrastructure for event sponsorships and partnerships.

## Naming Strategy
| Module | Name |
|---|---|
| Platform | Events Domain |
| Sponsor Module | Sponsor Hub |
| Partner Module | Partner Network |

## Core Purpose
Connect Event Organizers with Sponsors, Partners, and Service Providers.

## NOT
An event ticketing system.

## How It Works
1. Organizers create events & sponsorship packages
2. Sponsors discover relevant opportunities
3. Partners offer services (venue, sound, media, etc.)
4. Connections happen instantly via platform

## Business Model
- Featured event listings
- Sponsor promotion plans
- Partner subscriptions
- Commission on successful sponsorships
- Premium analytics tools

## Problem Solved
Finding the right sponsors and business partners for an event. Eliminates cold outreach, improves match relevance, and centralizes communication.

## Current Phase
Initial build — Laravel 12 + Blade + Tailwind CSS v3 + Alpine.js 3

## Key Users
1. Event Organizer — Creates events, manages sponsorship
2. Sponsor — Discovers and invests in events
3. Partner — Provides event services (vendors)
4. Admin — Moderates and manages platform

## Key Modules
- Authentication & User Profiles
- Events CRUD with gallery/schedule
- Sponsorship Package Builder
- Partner Marketplace
- Discovery & Search (FULLTEXT)
- Direct Messaging & Notifications
- Role-based Dashboards (4 roles)
- Admin moderation & CMS
- ROI Calculator

## FAQ & SEO
- Full FAQ content in `project.md` Section 27
- FAQ JSON-LD schema markup ready for `/faq` page
- Knowledge hub topics: sponsorship proposals, event marketing guides, ROI calculators
- Competitor SEO strategy analyzed (SponsorshipSearch.com)

## SEO Keywords (India 2026)
- Full keyword database in `project.md` Section 28
- 15 keyword categories: Homepage, Organizer, Sponsor, Packages, Virtual, Festival, College, Sports, Startup, Location, Corporate, Blog, High-Converting, Programmatic, Priority
- Programmatic SEO pages planned (location + event type combinations)
- Highest priority targets: event sponsorship, find sponsors, event sponsorship platform, festival sponsorship, college fest sponsorship

## AI Development Skills
- **tailwind-4-docs**: Tailwind CSS v4 documentation snapshot for v4 questions, utilities, variants, config, and v3→v4 migration
- Location: `.agents/skills/tailwind-4-docs/`
- Requires initialization: `python .agents/skills/tailwind-4-docs/scripts/sync_tailwind_docs.py --accept-docs-license`

## Cloudflare Pages SEO
- `_headers` file blocks indexing on `*.pages.dev` URLs, allows indexing on `eventsdomain.com`
- `_robots.txt` configured for production domain only
- Canonical tags, structured data, and redirects documented
- File location: `public/_headers` (Laravel/Vite project)
- Verification: `curl -I https://eventsdomain.pages.dev/` should show `X-Robots-Tag: noindex, nofollow`

## AdSense & Technical SEO
- Required pages: Privacy Policy, Terms & Conditions, About Us, Contact Us
- All four pages must be linked in footer and header
- `robots.txt` with sitemap link
- `sitemap.xml` with all URLs (dynamic generation possible)
- Error pages: 404, 500 (custom styled, not default)
- Google Analytics tracking code (config-driven)
- Git workflow: commit before/after each feature
- AdSense checklist in `project.md` Section 30

## Implementation Plans
- **00-project-overview.md**: Complete project overview, phases, tech stack, database schema, route summary, design system
- **01-frontend-implementation.md**: Blade components, page layouts, Alpine.js, Tailwind CSS, responsive design
- **02-middleware-implementation.md**: Auth, role-based access, custom middleware, Spatie Permission
- **03-backend-implementation.md**: Services, controllers, policies, form requests, migrations, seeders, testing
