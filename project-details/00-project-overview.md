# EventsDomain — Complete Project Overview Plan

> Master implementation plan for all AI agents. Read `project.md` first, then this file.

---

## 1. Project Summary

| Field | Value |
|---|---|
| **Project Name** | Events Domain |
| **Production URL** | https://eventsdomain.com |
| **Local URL** | http://vm.site |
| **Platform Type** | B2B Event Sponsorship & Partnership Marketplace |
| **Tech Stack** | Laravel 12 + Blade + Tailwind CSS v3 + Alpine.js 3 + Vite + MySQL 8 |
| **Contact** | eventsdomain.com@gmail.com / +91 9725098250 |

---

## 2. Platform Vision

```
🎤 Event Organizers    🏢 Sponsors & Brands    🤝 Service Partners
       │                       │                       │
       └───────────────────────┼───────────────────────┘
                               ▼
              Unified Sponsorship & Partnership Platform
```

**Mission:** Connect Event Organizers with Sponsors, Partners, and Service Providers through a structured, searchable marketplace.

**NOT:** An event ticketing system, a social event app, or a listing directory.

---

## 3. User Roles & Capabilities

| Role | Purpose | Key Capabilities |
|---|---|---|
| **Organizer** | Create events, manage sponsorships | Event CRUD, package builder, sponsor/partner management, analytics |
| **Sponsor** | Discover events, invest in sponsorships | Browse/filter events, send enquiries, track ROI, manage budget |
| **Partner** | Provide event services | List services, bid on opportunities, manage contracts, portfolio |
| **Admin** | Moderate platform | User verification, event approval, CMS, reports, system config |

---

## 4. Implementation Phases

### Phase 1: Foundation (Weeks 1-3)
| Task | Priority | Status |
|---|---|---|
| Laravel project setup | HIGH | Pending |
| Database migrations (all tables) | HIGH | Pending |
| Authentication system (register, login, OTP, email verify) | HIGH | Pending |
| Spatie Permission setup (roles + permissions) | HIGH | Pending |
| User profiles (organizer, sponsor, partner) | HIGH | Pending |
| Blade layouts (guest, organizer, sponsor, partner, admin) | HIGH | Pending |
| Tailwind CSS + Alpine.js setup | HIGH | Pending |
| Heroicons integration | HIGH | Pending |

### Phase 2: Core Modules (Weeks 4-6)
| Task | Priority | Status |
|---|---|---|
| Event CRUD (multi-step wizard) | HIGH | Pending |
| Sponsorship package builder | HIGH | Pending |
| Category management (3-tier taxonomy) | HIGH | Pending |
| Event gallery management | MEDIUM | Pending |
| Event schedule management | MEDIUM | Pending |
| Public event listing + filters | HIGH | Pending |
| Event detail page | HIGH | Pending |

### Phase 3: Marketplace (Weeks 7-9)
| Task | Priority | Status |
|---|---|---|
| Sponsor dashboard | HIGH | Pending |
| Partner dashboard | HIGH | Pending |
| Organizer dashboard | HIGH | Pending |
| Partner service CRUD | HIGH | Pending |
| Sponsorship enquiry system | HIGH | Pending |
| Partner bidding system | MEDIUM | Pending |
| Discovery & search (FULLTEXT) | HIGH | Pending |

### Phase 4: Communication (Weeks 10-11)
| Task | Priority | Status |
|---|---|---|
| Direct messaging (Laravel Reverb) | HIGH | Pending |
| Notification system | HIGH | Pending |
| Email notifications (Laravel Mail) | MEDIUM | Pending |
| Typing indicators | LOW | Pending |

### Phase 5: Advanced Features (Weeks 12-14)
| Task | Priority | Status |
|---|---|---|
| ROI Calculator | MEDIUM | Pending |
| Social media integration | LOW | Pending |
| AI search (Vector + LLM) | LOW | Pending |
| Admin dashboard | HIGH | Pending |
| CMS pages | MEDIUM | Pending |
| Analytics & reports | MEDIUM | Pending |

### Phase 6: SEO & Launch (Weeks 15-16)
| Task | Priority | Status |
|---|---|---|
| FAQ page with JSON-LD | HIGH | Pending |
| Privacy Policy, Terms, About, Contact pages | HIGH | Pending |
| robots.txt + sitemap.xml | HIGH | Pending |
| _headers (Cloudflare Pages noindex) | HIGH | Pending |
| Google Analytics | MEDIUM | Pending |
| Error pages (404, 500) | HIGH | Pending |
| AdSense compliance check | MEDIUM | Pending |

---

## 5. Technology Stack

### Backend
| Component | Technology |
|---|---|
| Framework | Laravel 12 |
| PHP | 8.2+ |
| Permissions | Spatie Permission |
| Search | MySQL FULLTEXT + Laravel Scout Ready |
| Real-time | Laravel Reverb (WebSocket) |
| Queue | Laravel Queue (database driver) |
| Mail | Laravel Mail (queue jobs) |
| Storage | Local + S3 Ready |

### Frontend
| Component | Technology |
|---|---|
| Templating | Laravel Blade |
| CSS | Tailwind CSS v3 |
| JS | Alpine.js 3 |
| Build | Vite |
| Icons | Heroicons (SVG inline) |
| Layout | Component-based Blade components |

### Database
| Component | Technology |
|---|---|
| Engine | MySQL 8 InnoDB |
| FULLTEXT | events, sponsorship_packages, partner_services |
| Indexes | Foreign keys, status, created_at, category_id, city |

### Infrastructure
| Component | Technology |
|---|---|
| Local Server | XAMPP (Apache Port 80) |
| Production | Cloudflare Pages + Custom Domain |
| Version Control | Git + GitHub |
| CI/CD | GitHub Actions |

---

## 6. Database Schema Summary

### Core Tables (22 tables)
```
users, profiles, otp_verifications
roles, permissions, role_has_permissions, model_has_roles
events, event_gallery, event_schedule, event_team
categories
sponsorship_packages, sponsorship_benefits, sponsorship_requests, sponsorship_contracts
partner_services, partner_service_reviews, partner_requests, partner_bids
social_accounts, event_posts, post_logs
conversations, conversation_participants, messages, notifications
pages, keywords, backlinks, search_logs, crawl_jobs
activity_logs, cms_pages, platform_settings
```

---

## 7. Route Summary (173 routes)

| Group | Routes | Middleware |
|---|---|---|
| Public | Home, events, categories, blog, contact, pages | guest |
| Auth | Login, register, password reset, email verification | guest |
| Organizer | Dashboard, events CRUD, packages, sponsors, partners, schedule, gallery, analytics, messages, team, profile, settings | auth + role:organizer |
| Sponsor | Dashboard, discover, saved, enquiries, sponsored, messages, notifications, profile, settings | auth + role:sponsor |
| Partner | Dashboard, services CRUD, opportunities, bids, contracts, availability, portfolio, reviews, messages, notifications, profile, settings | auth + role:partner |
| Admin | Dashboard, events moderation, users, categories, sponsorships, partners, reports, CMS, roles, settings, logs | auth + role:admin |
| API | Messages (send/fetch/typing), upload, enquiry, search, filters, ROI calculator | varies |

---

## 8. Design System

### Color Tokens
| Token | Hex | Usage |
|---|---|---|
| Primary | `#E35336` | Core CTAs, highlighted statuses |
| Secondary | `#FFB0A1` | Light accent, hover states |
| Dark | `#9E3A26` | Headers, borders |
| Background | `#451911` | Heavy contrast, dark accent |

### UI Principles
- Clean, minimal, professional
- Dashboard-style interface
- Mobile-first responsive design
- Large white space
- Excellent typography
- Accessibility-first
- Heroicons (SVG) for all icons
- Simple CSS transitions only

---

## 9. Development Standards

### Backend Rules
- `declare(strict_types=1)` on all classes
- Service Layer pattern — thin controllers
- Form Requests for validation
- Policies for authorization
- Eloquent with eager loading (`with()`)
- Database transactions for multi-step ops
- Queue jobs for async work
- PSR-12 coding standards
- Never query inside loops
- Always paginate (10-20 on mobile)

### Frontend Rules
- Blade first — no React/Vue/Angular
- Minimal JS — Alpine.js only for reactivity
- Tailwind utility classes only
- Component-based UI (Blade components)
- Semantic HTML
- Micro-interactions on CTAs
- Skeleton UI for loading states

---

## 10. File Structure

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
│   │   └── errors/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   ├── api.php
│   └── console.php
├── config/
├── public/
│   ├── _headers
│   ├── _redirects
│   ├── robots.txt
│   └── sitemap.xml
└── project-brain/
    ├── system/
    ├── graph/
    ├── memory/
    ├── tasks/
    ├── standards/
    ├── reviews/
    ├── templates/
    ├── runtime/
    └── cache/
```

---

## 11. Success Metrics

| Metric | Target |
|---|---|
| Page Load Time | < 2 seconds |
| Lighthouse Performance | > 95 |
| Lighthouse Accessibility | > 95 |
| Lighthouse SEO | > 95 |
| Code Coverage (Services) | > 70% |
| Mobile Responsive | 100% |
| AdSense Approval | Yes |

---

*Last updated: 2026-06-30*
*This plan governs all implementation. Follow the execution pipeline from project.md Section 24.*
