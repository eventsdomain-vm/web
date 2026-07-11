# EventsDomain — Frontend Implementation Plan

> Detailed frontend implementation guide. Read `project.md` and `00-project-overview.md` first.

---

## 1. Frontend Stack

| Layer | Technology | Purpose |
|---|---|---|
| **Templating** | Laravel Blade | Server-side rendering, component-based UI |
| **CSS** | Tailwind CSS v3 | Utility-first styling |
| **JS** | Alpine.js 3 | Client-side reactivity |
| **Build** | Vite | Asset bundling, HMR |
| **Icons** | Heroicons | SVG inline icons |

---

## 2. Blade Component Architecture

### 2.1 Layout Components

| Component | File | Purpose |
|---|---|---|
| Guest Layout | `resources/views/layouts/guest.blade.php` | Public pages (home, events, blog) |
| Organizer Layout | `resources/views/layouts/organizer.blade.php` | Organizer dashboard |
| Sponsor Layout | `resources/views/layouts/sponsor.blade.php` | Sponsor dashboard |
| Partner Layout | `resources/views/layouts/partner.blade.php` | Partner dashboard |
| Admin Layout | `resources/views/layouts/admin.blade.php` | Admin panel |

### 2.2 Shared Components

```
resources/views/components/
├── navigation/
│   ├── header.blade.php           # Desktop header
│   ├── mobile-nav.blade.php       # Mobile bottom tab bar
│   ├── drawer.blade.php           # Hamburger menu drawer
│   └── sidebar.blade.php          # Dashboard sidebar
├── ui/
│   ├── button.blade.php           # Primary/Secondary/Danger buttons
│   ├── card.blade.php             # Content card wrapper
│   ├── badge.blade.php            # Status badges
│   ├── avatar.blade.php           # User avatar
│   ├── modal.blade.php            # Modal dialog
│   ├── drawer.blade.php           # Slide-out drawer
│   ├── toast.blade.php            # Toast notifications
│   ├── skeleton.blade.php         # Loading skeleton
│   ├── empty-state.blade.php      # Empty state placeholder
│   └── confirmation.blade.php     # Confirmation dialog
├── forms/
│   ├── input.blade.php            # Text input
│   ├── textarea.blade.php         # Textarea
│   ├── select.blade.php           # Select dropdown
│   ├── checkbox.blade.php         # Checkbox
│   ├── radio.blade.php            # Radio button
│   ├── file-upload.blade.php      # File upload with preview
│   ├── search-box.blade.php       # Search input
│   └── form-group.blade.php       # Form field wrapper
├── events/
│   ├── event-card.blade.php       # Event listing card
│   ├── event-grid.blade.php       # Event grid layout
│   ├── event-filters.blade.php    # Filter sidebar/drawer
│   └── event-detail.blade.php     # Event detail sections
├── dashboard/
│   ├── stat-card.blade.php        # Statistics card
│   ├── activity-feed.blade.php    # Recent activity list
│   ├── pending-actions.blade.php  # Pending items widget
│   └── chart.blade.php            # Chart wrapper
├── layout/
│   ├── footer.blade.php           # Public footer
│   ├── canonical.blade.php        # SEO canonical tag
│   ├── analytics.blade.php        # Google Analytics
│   └── json-ld.blade.php          # Structured data
└── seo/
    ├── meta.blade.php             # Meta tags
    ├── open-graph.blade.php       # Open Graph tags
    └── twitter-card.blade.php     # Twitter Card tags
```

---

## 3. Page Implementation Plan

### 3.1 Public Pages

| Page | Route | Layout | Components |
|---|---|---|---|
| **Home** | `/` | guest | Hero, TrustIndicators, HowItWorks, FeaturedEvents, Categories, SponsorSection, PartnerSection, CTA |
| **Events Listing** | `/events` | guest | EventGrid, EventFilters, EventCard, Pagination |
| **Event Detail** | `/events/{slug}` | guest | EventDetail, SponsorPackages, OrganizerCard, Gallery, Schedule |
| **About** | `/about` | guest | PageContent |
| **Contact** | `/contact` | guest | ContactForm |
| **FAQ** | `/faq` | guest | FAQAccordion, JsonLd |
| **Privacy Policy** | `/privacy-policy` | guest | PageContent |
| **Terms & Conditions** | `/terms-and-conditions` | guest | PageContent |
| **Blog** | `/blog` | guest | PostGrid, PostCard, Pagination |
| **Blog Post** | `/blog/{slug}` | guest | PostContent, Sidebar |
| **ROI Calculator** | `/roi-calculator` | guest | CalculatorForm, ResultDisplay |
| **Pricing** | `/pricing` | guest | PricingCards |

### 3.2 Organizer Dashboard Pages

| Page | Route | Components |
|---|---|---|
| **Dashboard Home** | `/organizer/dashboard` | StatCards, ActivityFeed, PendingActions |
| **Events List** | `/organizer/events` | EventTable, StatusFilter, Pagination |
| **Create Event** | `/organizer/events/create` | MultiStepWizard (6 steps) |
| **Edit Event** | `/organizer/events/{id}/edit` | MultiStepWizard (prefilled) |
| **Event Detail** | `/organizer/events/{id}` | EventInfo, Tabs (packages, sponsors, partners, schedule, gallery) |
| **Packages** | `/organizer/events/{id}/packages` | PackageBuilder, PackageCard |
| **Sponsors** | `/organizer/events/{id}/sponsors` | SponsorList, SponsorRequest |
| **Partners** | `/organizer/events/{id}/partners` | PartnerList, PartnerRequest |
| **Schedule** | `/organizer/events/{id}/schedule` | ScheduleBuilder, TimelineItem |
| **Gallery** | `/organizer/events/{id}/gallery` | ImageGrid, UploadArea |
| **Analytics** | `/organizer/events/{id}/analytics` | Charts, MetricsCards |
| **Messages** | `/organizer/messages` | ConversationList, ChatWindow |
| **Team** | `/organizer/team` | TeamList, InviteForm |
| **Profile** | `/organizer/profile` | ProfileForm, AvatarUpload |
| **Settings** | `/organizer/settings` | SettingsForm |

### 3.3 Sponsor Dashboard Pages

| Page | Route | Components |
|---|---|---|
| **Dashboard Home** | `/sponsor/dashboard` | StatCards, Recommendations, EnquiryStatus |
| **Discover Events** | `/sponsor/discover` | EventGrid, EventFilters, SearchBox |
| **Event Detail** | `/sponsor/discover/{event}` | EventInfo, SponsorPackages, EnquiryForm |
| **Saved Events** | `/sponsor/saved` | EventGrid, RemoveButton |
| **Enquiries** | `/sponsor/enquiries` | EnquiryList, StatusBadge |
| **Sponsored** | `/sponsor/sponsored` | SponsoredList, ROIMetrics |
| **Messages** | `/sponsor/messages` | ConversationList, ChatWindow |
| **Notifications** | `/sponsor/notifications` | NotificationList |
| **Profile** | `/sponsor/profile` | ProfileForm |
| **Settings** | `/sponsor/settings` | SettingsForm |

### 3.4 Partner Dashboard Pages

| Page | Route | Components |
|---|---|---|
| **Dashboard Home** | `/partner/dashboard` | StatCards, Opportunities, ActiveContracts |
| **Services** | `/partner/services` | ServiceList, CreateButton |
| **Create Service** | `/partner/services/create` | ServiceForm |
| **Edit Service** | `/partner/services/{id}/edit` | ServiceForm (prefilled) |
| **Opportunities** | `/partner/opportunities` | OpportunityList, BidForm |
| **Contracts** | `/partner/contracts` | ContractList, StatusBadge |
| **Availability** | `/partner/availability` | Calendar, ToggleDays |
| **Portfolio** | `/partner/portfolio` | PortfolioGrid, UploadArea |
| **Reviews** | `/partner/reviews` | ReviewList, RatingStars |
| **Messages** | `/partner/messages` | ConversationList, ChatWindow |
| **Profile** | `/partner/profile` | ProfileForm |
| **Settings** | `/partner/settings` | SettingsForm |

### 3.5 Admin Pages

| Page | Route | Components |
|---|---|---|
| **Dashboard** | `/admin/dashboard` | StatCards, PlatformHealth, GrowthChart |
| **Events** | `/admin/events` | EventTable, StatusFilter |
| **Event Detail** | `/admin/events/{id}` | EventInfo, ApproveRejectButtons |
| **Users** | `/admin/users` | UserTable, RoleFilter, VerifyButton |
| **Categories** | `/admin/categories` | CategoryTree, CRUDModal |
| **Sponsorships** | `/admin/sponsorships` | SponsorshipTable |
| **Partners** | `/admin/partners` | PartnerTable, VerifyButton |
| **Reports** | `/admin/reports` | ReportCharts, ExportButton |
| **CMS** | `/admin/cms` | PageList, EditorForm |
| **Roles** | `/admin/roles` | RoleTable, PermissionMatrix |
| **Settings** | `/admin/settings` | SettingsForm |
| **Logs** | `/admin/logs` | LogTable, FilterBar |

---

## 4. Responsive Design Implementation

### 4.1 Breakpoints
| Device | Width | Tailwind Prefix |
|---|---|---|
| Mobile | 320-425px | (base) |
| Tablet | 768px | `md:` |
| Laptop | 1024px | `lg:` |
| Desktop | 1280px | `xl:` |

### 4.2 Mobile-First Rules
- Design for mobile first, enhance for desktop
- Touch targets: minimum 44×44px
- Bottom tab bar on mobile (Home, Explore, Events, Messages, Profile)
- Hamburger drawer for secondary navigation
- Single column cards on mobile
- Infinite scroll on mobile event listings
- Bottom sheet for filters on mobile

### 4.3 Component Responsiveness
| Component | Mobile | Desktop |
|---|---|---|
| Event Grid | 1 column | 3-4 columns |
| Dashboard Cards | Vertical stack | 4 columns |
| Tables | Card layout | Full table |
| Filters | Bottom sheet | Sidebar |
| Modals | Full screen | Centered |
| Chat | Full screen | 3-panel |

---

## 5. Alpine.js Components

### 5.1 Interactive Components

```javascript
// Multi-step form wizard
x-data="{ step: 1, totalSteps: 6 }"

// Mobile menu toggle
x-data="{ mobileMenuOpen: false }"

// Modal toggle
x-data="{ modalOpen: false }"

// Filter drawer
x-data="{ filterOpen: false, filters: {} }"

// Search with debounce
x-data="{ query: '', results: [], loading: false }"

// Dynamic form fields
x-data="{ packages: [{ name: '', price: '', benefits: [] }] }"

// Calendar availability
x-data="{ availability: {} }"

// Chat messaging
x-data="{ message: '', messages: [] }"
```

### 5.2 API Integration

```javascript
// Fetch events with filters
Alpine.store('events', {
    events: [],
    loading: false,
    async fetch(filters) {
        this.loading = true;
        const response = await fetch(`/api/search/events?${new URLSearchParams(filters)}`);
        this.events = await response.json();
        this.loading = false;
    }
});

// Send enquiry
Alpine.store('enquiry', {
    async send(eventId, data) {
        const response = await fetch(`/api/enquiry/send`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ event_id: eventId, ...data })
        });
        return response.json();
    }
});
```

---

## 6. Tailwind CSS Configuration

### 6.1 Custom Theme
```javascript
// tailwind.config.js
module.exports = {
    theme: {
        extend: {
            colors: {
                primary: '#E35336',
                secondary: '#FFB0A1',
                dark: '#9E3A26',
                background: '#451911',
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
            },
        },
    },
}
```

### 6.2 Purge Configuration
```javascript
content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue', // if any
]
```

---

## 7. Vite Build Configuration

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
```

---

## 8. Implementation Checklist

### Phase 1: Foundation
- [ ] Install Laravel + configure .env
- [ ] Install Tailwind CSS + Alpine.js + Vite
- [ ] Configure tailwind.config.js with custom theme
- [ ] Create base Blade layout (guest)
- [ ] Create navigation components (header, footer, mobile-nav)
- [ ] Create UI components (button, card, badge, avatar, modal)
- [ ] Create form components (input, textarea, select, checkbox)
- [ ] Install Heroicons

### Phase 2: Public Pages
- [ ] Home page (hero, categories, featured events)
- [ ] Events listing (grid, filters, pagination)
- [ ] Event detail page
- [ ] About page
- [ ] Contact page
- [ ] FAQ page
- [ ] Privacy Policy page
- [ ] Terms & Conditions page
- [ ] Blog listing + detail

### Phase 3: Auth Pages
- [ ] Login page
- [ ] Register page (multi-step)
- [ ] Forgot password page
- [ ] Reset password page
- [ ] Email verification page

### Phase 4: Dashboard Layouts
- [ ] Organizer layout (sidebar + content)
- [ ] Sponsor layout (sidebar + content)
- [ ] Partner layout (sidebar + content)
- [ ] Admin layout (sidebar + content)

### Phase 5: Dashboard Pages
- [ ] Organizer dashboard + events CRUD
- [ ] Sponsor dashboard + discover
- [ ] Partner dashboard + services CRUD
- [ ] Admin dashboard + moderation

### Phase 6: Interactive Features
- [ ] Multi-step event creation wizard
- [ ] Sponsorship package builder
- [ ] Direct messaging UI
- [ ] Notification center
- [ ] ROI Calculator

---

*Last updated: 2026-06-30*
*This plan governs all frontend implementation. Follow the execution pipeline from project.md Section 24.*
