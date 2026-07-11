# EventsDomain -- Marketplace PRD

> Product Requirements Document v2
> Read `00-project-overview.md`, `02-middleware-implementation.md`, and `03-backend-implementation.md` first.

---

## Table of Contents

1. Executive Summary
2. Platform Overview
3. Organizer Experience
4. Sponsor Experience
5. Partner Experience
6. Shared Marketplace Features
7. Analytics & KPIs
8. State Machines
9. Data Model & Core Entities
10. Marketplace Intelligence (Future Ready)
11. Vertical Slice Roadmap

---

## 1. Executive Summary

### 1.1 Vision

EventsDomain is India's premier B2B marketplace for the event industry -- connecting Organizers with Sponsors (brands/investors) and Service Partners (vendors). It is NOT an event ticketing platform, a social event app, or a directory listing.

### 1.2 Marketplace Positioning

```
Event Organizers  ←→  Sponsors (Brands)  ←→  Service Partners
     │                      │                       │
     │   Create events      │   Invest budget       │   Provide services
     │   Seek funding       │   Track ROI           │   Win contracts
     │   Hire vendors       │   Reach audiences     │   Grow revenue
     └──────────────────────┼───────────────────────┘
                            │
                   EventsDomain Platform
              Discovery  |  Matching  |  Trust
              Contracts  |  Payments  |  Analytics
```

**Analogies:**
- LinkedIn for professional profiles and credibility
- IndiaMART for service discovery and quoting
- Upwork for contracts, milestones, and payments
- AngelList for sponsorship investment and ROI

### 1.3 Business Goals

| Goal | Metric | Target | Timeline |
|---|---|---|---|
| Organizer acquisition | Events listed per month | 200 | 6 months |
| Sponsor retention | Return sponsorship rate | >60% | 12 months |
| Partner engagement | Active service listings | 500 | 6 months |
| Marketplace liquidity | Proposals submitted per event | >5 | 12 months |
| Revenue | Platform commission | 5-10% per transaction | 12 months |

### 1.4 Success Metrics

| Metric | Definition | Target |
|---|---|---|
| Proposal-to-contract rate | % of proposals that convert | >40% |
| Partner response time | Hours to respond to request | <4 hours |
| Sponsor discovery depth | Avg events viewed before proposal | >8 |
| Partner booking utilization | % of calendar booked | >70% |
| Platform NPS | Net Promoter Score | >50 |
| Avg deal size | Mean sponsorship value | INR 8L |

---

## 2. Platform Overview

### 2.1 User Roles

| Role | Primary Question | Business Objective |
|---|---|---|
| **Organizer** | How do I secure sponsorships and service partners for my event? | Event success |
| **Sponsor** | Where should I invest my marketing budget for maximum ROI? | Brand reach |
| **Partner** | How do I find event opportunities and win service contracts? | Business growth |
| **Admin** | How do I maintain platform quality and trust? | Platform integrity |

### 2.2 Marketplace Architecture

```
                            ┌──────────────────┐
                            │   PLATFORM       │
                            │  (EventsDomain)  │
                            └────────┬─────────┘
                                     │
            ┌────────────────────────┼────────────────────────┐
            │                        │                        │
    ┌───────▼───────┐       ┌───────▼───────┐       ┌───────▼───────┐
    │  CAPABILITY 1 │       │  CAPABILITY 2 │       │  CAPABILITY 3 │
    │    Event      │       │ Sponsorship   │       │   Partner     │
    │  Marketplace  │       │  Marketplace  │       │  Marketplace  │
    └───────┬───────┘       └───────┬───────┘       └───────┬───────┘
            │                        │                        │
    ┌───────▼───────┐       ┌───────▼───────┐       ┌───────▼───────┐
    │  CAPABILITY 4 │       │  CAPABILITY 5 │       │  CAPABILITY 6 │
    │ Communication │       │ Contracts &   │       │  Analytics &  │
    │               │       │   Payments    │       │  Intelligence │
    └───────┬───────┘       └───────┬───────┘       └───────┬───────┘
            │                        │                        │
            └────────────────────────┼────────────────────────┘
                                     │
                            ┌────────▼────────┐
                            │    SHARED       │
                            │  COMPONENTS     │
                            │ (Search, Auth,  │
                            │  Notifications, │
                            │  Profiles, Docs)│
                            └─────────────────┘
```

### 2.3 High-Level User Journeys

**Organizer Journey:**
```
Create Event ──► Publish ──► Receive Sponsorship Interest ──► Negotiate ──► Execute
                     │                                              │
                     └──► Discover Partners ──► Request Services ───┘
```

**Sponsor Journey:**
```
Discover Events ──► Evaluate ──► Compare ──► Propose ──► Negotiate ──► Campaign ──► ROI
```

**Partner Journey:**
```
List Services ──► Receive Requests ──► Quote ──► Negotiate ──► Deliver ──► Get Reviewed
```

### 2.4 Core Concepts

| Concept | Definition |
|---|---|
| Event | A marketplace listing representing an in-person/virtual gathering seeking sponsorship and services |
| Sponsorship Package | A priced tier of benefits an organizer offers to sponsors |
| Proposal | A sponsor's formal offer to invest in an event (replaces simple `sponsorship_requests`) |
| Campaign | A sponsor's active sponsorship with tracked deliverables and ROI |
| Partner Service | A priced service offering a partner provides to events |
| Partner Request | An organizer's invitation for a partner to quote on a service need |
| Contract | A legally binding agreement between two parties |
| Health Score | Algorithmic score evaluating an event's sponsorship potential |

---

## 3. Organizer Experience

### 3.1 Dashboard

**Goal:** Give organizers a real-time command center for their events, sponsorships, and partner relationships.

#### Widgets

| Widget | Data | Click Action |
|---|---|---|
| Total Events | Count of all events | `organizer.events.index` |
| Live Events | Events with status=live | Filtered event list |
| Pending Sponsorships | Proposals awaiting review | Sponsor proposals list |
| Active Partner Bids | Pending partner quotes | Partner requests list |
| Total Funds Raised | Sum of accepted sponsorship amounts | Payment history |
| Upcoming Events | Next 3 events with countdown | Event detail |
| Recent Sponsor Proposals | Last 5 incoming proposals | Proposal detail |
| Recent Partner Quotes | Last 5 partner quotes | Quote detail |
| Messages | Unread count | Messages page |
| Tasks | Follow-ups, pending actions | Task modal |

#### Layout

```
┌──────────────────────────────────────────────────────────────────────┐
│  Welcome back, Organizer Name                    [🔔][🔍][👤]      │
├──────────────────────────────────────────────────────────────────────┤
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐                │
│  │  Total   │ │   Live   │ │ Pending  │ │  Funds   │                │
│  │  Events  │ │  Events  │ │Sponsors  │ │  Raised  │                │
│  │    12    │ │     5    │ │    3     │ │  ₹45L   │                │
│  └──────────┘ └──────────┘ └──────────┘ └──────────┘                │
├────────────────────────┬─────────────────────────────────────────────┤
│  Upcoming Events       │  Recent Sponsor Proposals                   │
│  ┌──────────────────┐  │  ┌──────────────────────────────────────┐  │
│  │ Music Fest - 14d │  │  │ Brand X wants Platinum - ₹15L       │  │
│  │ Tech Conf - 45d  │  │  │ Brand Y wants Gold - ₹8L            │  │
│  │ Food Expo - 60d  │  │  │ Brand Z enquired about Silver       │  │
│  └──────────────────┘  │  └──────────────────────────────────────┘  │
├────────────────────────┴─────────────────────────────────────────────┤
│  Quick Actions                                                       │
│  [+ Create Event]  [View Sponsorships]  [Find Partners]  [Messages] │
└──────────────────────────────────────────────────────────────────────┘
```

### 3.2 Organizer Lifecycle

```
┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐
│ DASHBOARD│───▶│  CREATE  │───▶│ MANAGE  │───▶│ SPONSOR │
│          │    │  EVENT   │    │  EVENT   │    │ MGMT    │
└──────────┘    └──────────┘    └──────────┘    └────┬─────┘
                                                     │
┌──────────┐    ┌──────────┐    ┌──────────┐         │
│ ANALYTICS│◀───│ EXECUTE  │◀───│ CONTRACT │◀────────┘
│          │    │          │    │          │
└──────────┘    └──────────┘    └──────────┘
```

#### Step 1: Dashboard (above)

#### Step 2: Create Event

**Goal:** Submit a new event to the marketplace.

| Field | Type | Rules |
|---|---|---|
| Title | Text | Required, max 255 |
| Tagline | Text | Optional, max 500 |
| Description | Rich text | Required, min 100 chars |
| Category | Select from tree | Required |
| Event Type | Select | physical / virtual / hybrid |
| Start/End Date | Date picker | Required, start >= today |
| Venue / Location | Text | Required if physical |
| City / State / Country | Text | Required |
| Expected Audience | Number | Required, min 1 |
| Target Age Group | Select | 18-25 / 25-35 / 35-50 / 50+ / All |
| Ticket Price (min-max) | Number range | Optional |
| Website URL | URL | Optional |
| Cover Image | Image upload | Recommended, 16:9 |
| Gallery | Multiple images | Optional, max 10 |
| Sponsorship Type | Select | paid / barter / hybrid |
| Budget Min/Max | Number range | Required if paid |
| Instagram Reach | Number | Optional |
| YouTube Reach | Number | Optional |
| Has Celebrity | Boolean | Optional |
| Has Govt Support | Boolean | Optional |
| Has Media Coverage | Boolean | Optional |
| Previous Sponsors | Text (comma sep) | Optional |
| Tags | Multi-select | Optional, max 5 |

**Business Rules:**
- Event starts as `draft`
- Organizer can save as draft and resume later
- On submit -> status becomes `pending` -> admin approval -> `published`
- Published events appear in sponsor search

**State Changes:** `draft` -> `pending` -> `published` | `rejected`

**Notifications:** Admin notified of new event for approval. Organizer notified on approval/rejection.

#### Step 3: Manage Event

Edit event details, manage gallery, schedule, team members.

**Sections:**
- Event Details (edit form)
- Schedule (agenda items with time slots)
- Gallery (upload/reorder/delete images)
- Team (add/remove team members)
- Sponsorship Packages (create/edit packages)
- Sponsor Proposals (incoming)
- Partner Requests (outgoing + responses)

#### Step 4: Sponsorship Package Configuration

**Goal:** Create priced sponsorship tiers for sponsors to choose from.

| Field | Type | Rules |
|---|---|---|
| Title | Text | Required |
| Description | Text | Required |
| Price | Decimal | Required, min 0 |
| Slots Available | Integer | Required, min 1 |
| Benefits | Repeater | Required, min 1 benefit |
| Benefit Text | Text | Per benefit row |

**Business Rules:**
- At least 1 package required for sponsorship requests
- Slots filled auto-increments on acceptance
- Benefits are reusable templates (stored in `sponsorship_benefits`)
- Organizer can create unlimited packages per event

#### Step 5: Sponsor Management

**Goal:** Review and respond to incoming sponsorship proposals.

| State | Organizer Action |
|---|---|
| `submitted` | View proposal details -> Shortlist / Reject |
| `shortlisted` | Start Negotiation -> Send counter offer |
| `negotiating` | Accept counter / Send new counter / Reject |
| `agreed` | Generate contract |
| `contracted` | Track payment status |
| `active` | Track campaign deliverables |
| `completed` | Rate sponsor |

**View:** List of all proposals with filters by status. Click to view full proposal with sponsor profile, message, budget offer.

#### Step 6: Partner Management

**Goal:** Discover and request services from partners.

**Screens:**
- Discover Partners (browse by service category, city, rating)
- Partner Profile (portfolio, reviews, services)
- Request Service (select service, write message, set budget)
- Incoming Quotes (review partner quotes -> accept/reject/counter)

#### Step 7: Contracts & Payments

**Goal:** Formalize agreements.

- Auto-generate contract from agreed proposal/quote
- Track payment status (pending -> paid)
- Download contract PDF
- View payment history

#### Step 8: Event Execution

**Goal:** Run the event and track real-time deliverables.

- Campaign deliverable checklist (for sponsor)
- Partner schedule (which partner is doing what when)
- Team assignments

#### Step 9: Analytics

**Goal:** Measure event success.

| KPI | Source |
|---|---|
| Total sponsorship raised | Sum of accepted packages |
| Funds from partners spent | Sum of partner payments |
| Net event revenue | Sponsorship - partner costs |
| Sponsor satisfaction | Average sponsor rating |
| Partner performance | Average partner rating |
| Audience reach | Total expected attendance |
| Views / Interest count | Event views, proposal count |

---

## 4. Sponsor Experience

### 4.1 Dashboard

**Goal:** Give marketing decision-makers a real-time view of their sponsorship portfolio and opportunities.

#### Widgets

| Widget | Data | Click Action |
|---|---|---|
| Remaining Budget | `sponsor_budgets.remaining` | Budget page |
| Active Sponsorships | Count of accepted proposals | Campaigns list |
| Pending Proposals | Submitted proposals awaiting reply | Proposals list |
| Pending Negotiations | Active counter-offers | Negotiations list |
| Total Invested | Sum of all paid sponsorships | Payment history |
| Avg ROI | Mean ROI across all campaigns | Analytics page |
| Recommended Events | AI-matched, 4 items | Event detail |
| Saved Events | Count, recently saved | Saved events list |
| Recent Messages | Last 3 conversations | Messages |
| Upcoming Events | Next 3 sponsored events | Campaign detail |
| Tasks | Pending actions | Task list |

#### Layout

```
┌──────────────────────────────────────────────────────────────────────┐
│  Welcome back, Brand Name                       [🔔][🔍][👤]        │
├──────────────────────────────────────────────────────────────────────┤
│  Remaining Budget: ₹85,00,000                                        │
│  ████████████░░░░░░░░░░  42% utilized                               │
├──────────────────────────────────────────────────────────────────────┤
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐                │
│  │  Active  │ │ Pending  │ │  Total   │ │  Avg     │                │
│  │  Spons.  │ │ Proposals│ │ Invested │ │  ROI     │                │
│  │    3     │ │    2     │ │  ₹65L    │ │  14.2%   │                │
│  └──────────┘ └──────────┘ └──────────┘ └──────────┘                │
├────────────────────────┬─────────────────────────────────────────────┤
│  Recommended Events    │  Active Campaigns                           │
│  ┌──────────────────┐  │  ┌──────────────────────────────────────┐  │
│  │ Music Fest 2026  │  │  │ Brand X @ Tech Summit - 60% done    │  │
│  │ Audience: 15K    │  │  │ Brand Y @ Food Expo - 30% done      │  │
│  │ Budget: ₹15L     │  │  │ [View All Campaigns]                │  │
│  ├──────────────────┤  │  └──────────────────────────────────────┘  │
│  │ Startup Conf     │  ├─────────────────────────────────────────────┤
│  │ Audience: 8K     │  │  Recent Messages                           │
│  │ Budget: ₹8L      │  │  ┌──────────────────────────────────────┐  │
│  └──────────────────┘  │  │  Organizer: Can we discuss booth?    │  │
│                        │  │  Admin: Your event is approved       │  │
│  Pending Organizer     │  └──────────────────────────────────────┘  │
│  ┌──────────────────┐  ├─────────────────────────────────────────────┤
│  │ Platinum @ FestA │  │  Upcoming Events                           │
│  │ Awaiting reply   │  │  ┌──────────────────────────────────────┐  │
│  │ Gold @ ConfB     │  │  │ Music Fest - Jul 15 (14 days)        │  │
│  │ Counter received │  │  │ Tech Conf - Aug 20 (45 days)        │  │
│  └──────────────────┘  │  └──────────────────────────────────────┘  │
└────────────────────────┴─────────────────────────────────────────────┘
```

### 4.2 Discover Events

**Goal:** Find the best events for sponsorship investment.

#### Advanced Filter Panel

```
┌────────────────────────────────────────────────────────────────────────┐
│  [🔍 Search events by name, organizer, city...]        [SEARCH]      │
├────────────────────────────────────────────────────────────────────────┤
│  CATEGORY          │ EVENT TYPE       │ LOCATION       │ AUDIENCE      │
│  [All ✓]           │ [All ✓]          │ [All Cities]   │ Min [____]    │
│  Music             │ In-Person        │ Mumbai         │ Max [____]    │
│  Startup           │ Virtual          │ Delhi          │ Age [All ✓]   │
│  Corporate         │ Hybrid           │ Bangalore      │               │
│  College           │                  │                │ SPONSOR TYPE  │
│  Sports            │ BUDGET           │ DATE RANGE     │ [All ✓]       │
│  Food              │ Min [____]       │ From [____]    │ Paid          │
│  Fashion           │ Max [____]       │ To   [____]    │ Barter        │
│  Technology        │                  │                │ Hybrid        │
│  Healthcare        │ ONLINE REACH     │ VENUE          │               │
│  NGO               │ Instagram [ ]    │ [All ✓]        │ SORT BY       │
│  Festival          │ YouTube   [ ]    │ Indoor         │ [Health Score ✓│
│                    │ Min Fol [____]   │ Outdoor        │               │
└────────────────────────────────────────────────────────────────────────┘
```

#### Result Display

Events displayed as cards with:
- Cover image + category badge
- Title, date, city
- Expected audience + budget range
- Health score badge (color-coded)
- Sponsor type badge
- Save (heart) icon
- Click -> Event Detail

**Sort Options:** Health Score (default), Audience Size, Budget, Date, Organizer Rating.

### 4.3 Event Evaluation

**Goal:** Help sponsors make informed investment decisions.

#### Event Health Score

Calculated algorithmically:

| Factor | Weight | Source |
|---|---|---|
| Audience Match vs Sponsor Target | 25% | Sponsor industry/audience profile vs event target |
| Organizer Credibility | 15% | Rating, events completed, verification status |
| Past Sponsorship Success | 15% | Previous sponsor feedback, renewal rate |
| Media & Social Reach | 15% | Instagram, YouTube, website traffic |
| Brand Safety | 10% | Category alignment, no controversy |
| Budget Fit | 10% | Package price within sponsor budget |
| Timeline Feasibility | 5% | Days until event |
| Competition Level | 5% | Slots remaining / total |

Displayed as: `86/100` with color (green >75, amber 50-75, red <50).

#### Evaluation Screen Layout

```
┌─────────────────────────────────────────────────────────────────────────┐
│  ← Back to Results              [❤️ Save]  [⇄ Compare]  [📄 Download] │
├─────────────────────────────────────────────────────────────────────────┤
│  ┌─────────────────────────┐  ┌──────────────────────────────────────┐ │
│  │  EVENT HEADER           │  │  HEALTH SCORE: 86/100               │ │
│  │  [Cover Image]          │  │  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━    │ │
│  │  Music Fest 2026        │  │  Audience Match:    92% ████████░░  │ │
│  │  Jul 15-16, Mumbai      │  │  Organizer Rating:  85% ████████░░  │ │
│  │  Music | In-Person      │  │  Brand Alignment:   78% ███████░░░  │ │
│  └─────────────────────────┘  │  Social Reach:      70% ███████░░░  │ │
│                                │  Risk Score:        12% ██░░░░░░░░  │ │
│  ┌─────────────────────────┐  └──────────────────────────────────────┘ │
│  │  AUDIENCE INSIGHTS      │                                           │
│  │  Expected: 15,000       │  ┌──────────────────────────────────────┐ │
│  │  Age: 18-35 (70%)       │  │  SPONSORSHIP PACKAGES               │ │
│  │  Gender: Mixed          │  │  ┌────────────────────────────────┐  │ │
│  │  Ticket: ₹500-₹2,000    │  │  │ 🏆 Platinum - ₹15,00,000      │  │ │
│  │  Instagram: 50K         │  │  │   Slots: 2/5 filled            │  │ │
│  │  YouTube: 12K           │  │  │   Benefits:                    │  │ │
│  └─────────────────────────┘  │  │   - Logo on stage backdrop     │  │ │
│                                │  │   - Booth space (10x10)       │  │ │
│  ┌─────────────────────────┐  │  │   - Social media mention x5   │  │ │
│  │  ORGANIZER              │  │  │   - Product sampling allowed   │  │ │
│  │  ABC Events             │  │  │   [REQUEST THIS PACKAGE]       │  │ │
│  │  ★ 4.5 (23 events)      │  │  └────────────────────────────────┘  │ │
│  │  ✓ Verified             │  │  ┌────────────────────────────────┐  │ │
│  │  📅 Member since 2022   │  │  │ 🥇 Gold - ₹8,00,000           │  │ │
│  │  [View Profile]         │  │  │   Slots: 3/8 filled            │  │ │
│  └─────────────────────────┘  │  │   [REQUEST THIS PACKAGE]       │  │ │
│                                │  └────────────────────────────────┘  │ │
│  ┌─────────────────────────┐  │  ┌────────────────────────────────┐  │ │
│  │  DOWNLOADS              │  │  │ 🥈 Silver - ₹3,00,000          │  │ │
│  │  📄 Pitch Deck (PDF)    │  │  │   Slots: 1/10 filled           │  │ │
│  │  📸 Event Photos (ZIP)  │  │  │   [REQUEST THIS PACKAGE]       │  │ │
│  │  📊 Media Kit           │  │  └────────────────────────────────┘  │ │
│  └─────────────────────────┘  └──────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────────────────────┤
│  EVENT DETAILS (TABS)                                                    │
│  [About]  [Schedule]  [Gallery]  [Previous Sponsors]  [Media Coverage]  │
│  Description text...                                                     │
└─────────────────────────────────────────────────────────────────────────┘
```

### 4.4 Compare Events

**Goal:** Side-by-side comparison of up to 5 events.

```
┌────────────────────┬──────────────┬──────────────┬──────────────┐
│                    │  Event A     │  Event B     │  Event C     │
├────────────────────┼──────────────┼──────────────┼──────────────┤
│ Health Score       │  86          │  72          │  91          │
│ Audience           │  15,000      │  8,000       │  25,000      │
│ Ticket Price       │  ₹500-2K     │  Free        │  ₹1K-5K      │
│ Platinum Package   │  ₹15L        │  ₹8L         │  ₹25L        │
│ Gold Package       │  ₹8L         │  ₹5L         │  ₹15L        │
│ Slots Filled       │  2/5         │  1/3         │  4/6         │
│ Organizer Rating   │  4.5★        │  3.8★        │  4.9★        │
│ Instagram Reach    │  50K         │  12K         │  200K        │
│ Expected Reach     │  765K        │  200K        │  1.2M        │
│ Risk Score         │  12%         │  35%         │  8%          │
│ City               │  Mumbai      │  Delhi       │  Bangalore   │
├────────────────────┼──────────────┼──────────────┼──────────────┤
│                    │              │              │              │
│                    │ [REQUEST]    │ [REQUEST]    │ [REQUEST]    │
└────────────────────┴──────────────┴──────────────┴──────────────┘
```

### 4.5 Saved Events (Watchlist)

**Goal:** Bookmark events for later evaluation.

| Feature | Detail |
|---|---|
| Save from card | Heart icon on any event card |
| Private note | Attach note visible only to sponsor team |
| Tags | User-defined labels: "High Priority", "Q2 Budget" |
| Expiry alert | Notify N days before event |
| Bulk actions | Select multiple -> Compare / Request All |

### 4.6 Proposal Pipeline

**Goal:** Manage the full lifecycle of sponsorship proposals.

#### Pipeline States

```
discovered ──► interested ──► saved ──► proposal ──► submitted ──► viewed ──► shortlisted ──► negotiating ──► agreed ──► contracted ──► active ──► completed
                                        │              │               │                                    │
                                        └── draft ─────┘               └── rejected ────────────────────────┘
                                                                                   │
                                                                          negotiating ──► withdrawn
```

#### Pipeline View (Kanban-style)

```
┌──────────────┐  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐
│  PROPOSALS    │  │ NEGOTIATING  │  │  ACTIVE      │  │  COMPLETED   │
│  (3)          │  │ (2)          │  │  (3)         │  │  (5)         │
├──────────────┤  ├──────────────┤  ├──────────────┤  ├──────────────┤
│ Music Fest   │  │ Tech Conf    │  │ Startup Summit│  │ Food Expo    │
│ Submitted Jul1│  │ Counter recv │  │ 60% done     │  │ ROI: 18%     │
├──────────────┤  ├──────────────┤  ├──────────────┤  ├──────────────┤
│ Fashion Week │  │ College Fest │  │ Hackathon    │  │ Sports Meet  │
│ Viewed       │  │ Offer sent   │  │ 30% done     │  │ ROI: 12%     │
└──────────────┘  └──────────────┘  └──────────────┘  └──────────────┘
```

#### Proposal Form Fields

| Field | Type | Required |
|---|---|---|
| Package ID | Hidden (from selection) | Yes |
| Custom Message | Textarea | Yes |
| Budget Offer | Number | No |
| Additional Benefits Requested | Textarea | No |
| Internal Note (not shared) | Textarea | No |
| Attachments | File upload | No |

### 4.7 Negotiation

**Goal:** Structured back-and-forth to reach agreement.

- Proposal submitted -> Organizer reviews
- Organizer can: Accept, Reject, or Send Counter Offer
- Counter includes: `counter_amount`, `counter_message`
- Sponsor can: Accept Counter, Send New Counter, or Withdraw
- All changes tracked with timestamp

### 4.8 Campaign Tracking

**Goal:** Track sponsorship deliverables and measure success.

| Feature | Detail |
|---|---|
| Deliverable checklist | Benefits from package shown as checklist |
| Mark complete | Organizer marks items done |
| Progress bar | % of deliverables completed |
| Timeline | Days until event, days since active |
| Notes | Campaign-specific notes |
| Document upload | Briefs, designs, agreements |

### 4.9 Budget Management

**Goal:** Track sponsorship budget across fiscal year.

| Feature | Detail |
|---|---|
| Total budget | Set per fiscal year |
| Allocated | Committed to proposals in negotiation |
| Spent | Paid sponsorships |
| Remaining | Calculated: total - allocated - spent |
| Alerts | Notify when 80% utilized |

---

## 5. Partner Experience

### 5.1 Dashboard

**Goal:** Give service providers a real-time view of leads, jobs, and revenue.

#### Widgets

| Widget | Data | Click Action |
|---|---|---|
| New Leads Today | Incoming requests today | Requests list |
| Pending Quotes | Requests awaiting quote | Requests -> pending tab |
| Active Jobs | Accepted bookings | Bookings list |
| Monthly Revenue | Sum of completed deals this month | Revenue page |
| Upcoming Bookings | Next 4 jobs | Bookings list |
| Pending Quotations | Requests not yet quoted | Requests list |
| Average Rating | From reviews | Reviews page |
| Response Rate | % quoted within 24h | Analytics |

#### Layout

```
┌──────────────────────────────────────────────────────────────────────┐
│  Welcome back, Partner Name                       [🔔][🔍][👤]      │
├──────────────────────────────────────────────────────────────────────┤
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐                │
│  │New Leads │ │ Pending  │ │  Active  │ │  Monthly │                │
│  │  Today   │ │  Quotes  │ │   Jobs   │ │  Revenue │                │
│  │    3     │ │    5     │ │    2     │ │  ₹4.2L  │                │
│  └──────────┘ └──────────┘ └──────────┘ └──────────┘                │
├────────────────────────┬─────────────────────────────────────────────┤
│  Upcoming Bookings     │  Pending Quotations                         │
│  ┌──────────────────┐  │  ┌──────────────────────────────────────┐  │
│  │ Music Fest - Jul15│  │  │ Tech Conf needs AV setup            │  │
│  │ Wedding - Jul 22 │  │  │ College Fest needs stage design     │  │
│  │ Corporate - Aug5 │  │  │ Food Expo needs catering            │  │
│  │ Awards - Aug 12  │  │  │ [View All →]                       │  │
│  └──────────────────┘  │  └──────────────────────────────────────┘  │
├────────────────────────┴─────────────────────────────────────────────┤
│  Quick Actions                                                       │
│  [+ Add Service]  [View Requests]  [My Bookings]  [Calendar]        │
└──────────────────────────────────────────────────────────────────────┘
```

### 5.2 Partner Lifecycle

```
┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐
│DASHBOARD │───▶│ SERVICE  │───▶│ RECEIVE  │───▶│ SUBMIT   │
│          │    │ LISTINGS │    │ REQUESTS │    │ QUOTE    │
└──────────┘    └──────────┘    └──────────┘    └────┬─────┘
                                                     │
┌──────────┐    ┌──────────┐    ┌──────────┐         │
│ REVIEWS  │◀───│ DELIVER  │◀───│ CONFIRM  │◀────────┘
│          │    │ SERVICE  │    │ BOOKING  │
└──────────┘    └──────────┘    └──────────┘
```

### 5.3 Service Catalog

**Goal:** List and manage service offerings.

#### Service Form Fields

| Field | Type | Rules |
|---|---|---|
| Title | Text | Required |
| Category | Select | Required, from partner service categories |
| Description | Rich text | Required |
| Pricing Model | Select | fixed / hourly / per_event / quote_based |
| Base Price | Number | Required |
| Price Unit | Select | per event / per day / per hour / per head |
| Currency | Select | INR (default) |
| Min Order | Number | Optional |
| Max Capacity | Number | Optional |
| Coverage Areas | Multi-select cities | Optional |
| Tags | Text input | Optional |
| Images | Upload max 5 | Optional |
| Video URL | URL | Optional |
| Is Available | Toggle | Yes |
| Lead Time Days | Number | Required |

#### Service Categories

| # | Category |
|---|---|
| 1 | Audio Visual / Lighting |
| 2 | Stage Design & Construction |
| 3 | Catering & Food Services |
| 4 | Security & Crowd Management |
| 5 | Photography & Videography |
| 6 | Transportation & Logistics |
| 7 | Tent & Furniture Rental |
| 8 | Decor & Design |
| 9 | Entertainment (Artists, DJs) |
| 10 | Event Staffing & Volunteers |
| 11 | Printing & Branding |
| 12 | Digital Marketing |
| 13 | Travel & Accommodation |
| 14 | Insurance & Compliance |
| 15 | Cleanup & Waste Management |

### 5.4 Receive Requests + Quote

**Goal:** Respond to organizer service requests.

#### Request View

```
┌────────────────────────────────────────────────────────────────────────┐
│  SERVICE REQUEST #142                                     [DECLINE]  │
├────────────────────────────────────────────────────────────────────────┤
│  EVENT:  Music Fest 2026                                              │
│  ORGANIZER: ABC Events (★4.5, Verified)                               │
│  DATE: Jul 15-16, 2026                                                │
│  LOCATION: Mumbai, Maharashtra                                        │
│  AUDIENCE: 15,000                                                      │
│  SERVICE NEEDED: AV Setup & Management                                 │
│  BUDGET: ₹2,00,000 - ₹5,00,000                                        │
│                                                                        │
│  ORGANIZER MESSAGE:                                                    │
│  We need a full AV setup including sound system, LED screens,         │
│  and lighting for a 2-day music festival. Stage is 40x30 ft.          │
│  ────────────────────────────────────────────────────────────────────  │
│                                                                        │
│  YOUR QUOTE:                                                           │
│  ┌────────────────────────────────────────────────────────────────┐   │
│  │  Quote Amount: [₹ 3,50,000________]                             │   │
│  │  Quote Note: [Includes sound system, 2 LED screens,           │   │
│  │               basic stage lighting. Excludes labor.            │   │
│  │               Discount available for full weekend booking.]    │   │
│  │  Validity: [15 days]                                           │   │
│  │  [SUBMIT QUOTE]                                                │   │
│  └────────────────────────────────────────────────────────────────┘   │
└────────────────────────────────────────────────────────────────────────┘
```

### 5.5 Availability Calendar

**Goal:** Manage service availability to avoid double-booking.

```
┌────────────────────────────────────────────────────────────────────────┐
│  ◀  July 2026  ▶                                                       │
│  ┌────┬────┬────┬────┬────┬────┬────┐                                 │
│  │ Mo │ Tu │ We │ Th │ Fr │ Sa │ Su │                                 │
│  ├────┼────┼────┼────┼────┼────┼────┤                                 │
│  │    │    │ 1  │ 2  │ 3  │ 4  │ 5  │                                 │
│  │    │    │    │    │ ██ │ ██ │    │   ██ = Booked (Music Fest)      │
│  ├────┼────┼────┼────┼────┼────┼────┤   ▒▒ = Blocked (personal)      │
│  │ 6  │ 7  │ 8  │ 9  │ 10 │ 11 │ 12 │                                 │
│  │ ██ │    │    │    │    │ ██ │ ██ │                                 │
│  ├────┼────┼────┼────┼────┼────┼────┤   Click date to:               │
│  │ 13 │ 14 │ 15 │ 16 │ 17 │ 18 │ 19 │   - View booking details       │
│  │ ██ │ ██ │ ██ │ ██ │    │    │    │   - Block for personal         │
│  ├────┼────┼────┼────┼────┼────┼────┤   - Mark available             │
│  │ 20 │ 21 │ 22 │ 23 │ 24 │ 25 │ 26 │                                 │
│  │    │    │ ██ │ ██ │    │    │    │                                 │
│  └────┴────┴────┴────┴────┴────┴────┘                                 │
└────────────────────────────────────────────────────────────────────────┘
```

Bookings auto-populate from accepted jobs. Partner can manually block dates for personal time.

### 5.6 Portfolio

**Goal:** Showcase past work to win more business.

| Field | Type | Rules |
|---|---|---|
| Title | Text | Required |
| Description | Text | Optional |
| Event Name | Text | Optional |
| Event Date | Date | Optional |
| Location | Text | Optional |
| Images | Upload max 5 | Recommended |
| Video URL | URL | Optional |
| Tags | Multi-select | Optional |
| Is Featured | Boolean | Max 3 featured |

### 5.7 Revenue Dashboard

**Goal:** Track earnings and payouts.

| Widget | Detail |
|---|---|
| This Month Revenue | Sum of completed deals |
| Last Month Revenue | Comparison |
| Pending Payouts | Completed but unpaid |
| Total Earnings | All time |
| Revenue by Service | Pie chart |
| Revenue by Month | Bar chart (12 months) |
| Top Services | Table sorted by bookings |
| Payout History | Table with status |

---

## 6. Shared Marketplace Features

### 6.1 Messaging

**Scope:** All roles can message each other.

| Feature | Detail |
|---|---|
| Inbox | Threaded conversations |
| Real-time | Laravel Reverb WebSocket |
| Attachments | Images, documents (max 10MB) |
| Read receipts | Seen indicator |
| Typing indicator | "typing..." display |
| Conversation participants | 2+ users |
| Context-aware | Open from proposal/request with pre-filled context |
| Notifications | DB + Email on new message |

### 6.2 Notifications

**Scope:** All roles.

| Channel | Implementation | Priority |
|---|---|---|
| In-app (database) | `notifications` table, bell icon + dropdown | P0 |
| Email | Queue job via Laravel Mail | P1 |
| SMS | Future via Twilio/MSG91 | P2 |
| Push | Future via browser/service worker | P2 |

#### Notification Types

| Trigger | Recipient | Channel |
|---|---|---|
| Sponsor submits proposal | Organizer | DB + Email |
| Proposal viewed | Sponsor | DB |
| Proposal shortlisted | Sponsor | DB + Email |
| Counter offer received | Sponsor | DB + Email |
| Counter accepted | Organizer | DB |
| Contract generated | Both | DB + Email |
| Payment received | Both | DB + Email |
| Payment due | Sponsor | DB + Email |
| Partner request sent | Partner | DB + Email |
| Quote submitted | Organizer | DB |
| Quote accepted | Partner | DB + Email |
| Booking upcoming (N days) | Partner | DB |
| Event completed | Both | DB |
| Review received | Partner | DB |
| Message received | Both | DB + Email |
| Budget 80% utilized | Sponsor | DB |

### 6.3 Reviews & Ratings

**Scope:** Organizers rate Partners. Sponsors rate Organizers (future). Partners rate Organizers (future).

| Field | Type | Rules |
|---|---|---|
| Rating | 1-5 stars | Required |
| Review Text | Textarea | Optional |
| Anonymous | Boolean | Optional |
| Event reference | FK to event | Required |
| Target user | FK to user | Required |

Rating display: Average, count, distribution histogram.

### 6.4 Verification & Badges

**Scope:** All roles.

| Badge | Criteria | Color |
|---|---|---|
| Verified | Phone + Email + GST/PAN verified | Blue |
| Premium | Paid subscription | Gold |
| Top Performer | Top 10% by rating + volume | Purple |
| Fast Responder | Avg response < 1 hour | Green |
| Gold Partner | 50+ completed events (partner) | Gold |

### 6.5 Documents

**Scope:** Contracts, Proposals, Invoices.

| Document Type | Generated By | Content |
|---|---|---|
| Sponsorship Contract | System on agreement | Parties, package, amount, terms, dates |
| Invoice | System on payment | Amount, GST, transaction ID |
| Proposal PDF | Sponsor download | Proposal detail, event info |
| NDA | Optional upload | By either party |

### 6.6 Search (Global)

**Scope:** Platform-wide search.

| Feature | Detail |
|---|---|
| Scope | Events, Organizers, Partners, Services |
| Full-text | MySQL FULLTEXT index |
| Filters | Category, city, price range, date |
| Sort | Relevance, date, rating, popularity |
| Save search | Bookmark search parameters |

### 6.7 User Profiles

**Scope:** All roles.

| Section | Organizer | Sponsor | Partner |
|---|---|---|---|
| Company Info | Yes | Yes | Yes |
| Contact | Yes | Yes | Yes |
| Verification | Yes | Yes | Yes |
| Stats | Events hosted | Sponsorships done | Services completed |
| Reviews | From sponsors | (future) | From organizers |
| Portfolio | Past events | Past campaigns | Past work |
| Badges | Yes | Yes | Yes |
| Team | Yes | Yes | Yes |

---

## 7. Analytics & KPIs

### 7.1 Organizer Analytics

| KPI | Type | Chart |
|---|---|---|
| Total Sponsorship Revenue | Number | Summary card |
| Revenue by Event | Breakdown | Bar chart |
| Sponsor Interest by Event | Count | Horizontal bar |
| Proposal Conversion Rate | % | Funnel |
| Avg Deal Size | Number | Trend line |
| Partner Spend | Number | Summary card |
| Partner Bookings by Service | Count | Pie chart |
| Event Views | Count | Trend line |
| Pending Actions | Count | Summary card |

### 7.2 Sponsor Analytics

| KPI | Type | Chart |
|---|---|---|
| Total Budget | Number | Summary card |
| Budget Allocated | % of total | Progress bar |
| Budget Spent | % of total | Progress bar |
| Total Reach | Number | Summary card |
| Total Impressions | Number | Summary card |
| Leads Generated | Number | Trend line |
| Cost Per Lead | Number | Trend line |
| Cost Per Impression | Number | Trend line |
| ROI by Campaign | Percentage | Horizontal bar |
| ROI Over Time | Percentage | Line chart |
| Brand Mentions | Number | Trend line |
| Campaigns by Category | Count | Pie chart |
| Geographic Distribution | Count | Map / Bar |
| Top Performing Events | Table | Sorted by ROI |

### 7.3 Partner Analytics

| KPI | Type | Chart |
|---|---|---|
| Monthly Revenue | Number | Summary card |
| Revenue Trend | Number | Line chart (12 months) |
| Revenue by Service | Percentage | Pie chart |
| Revenue by City | Percentage | Horizontal bar |
| Total Bookings | Count | Summary card |
| Acceptance Rate | % | Trend line |
| Avg Quote Value | Number | Trend line |
| Top Services | Count | Horizontal bar |
| Repeat Customers | % | Summary card |
| Completion Rate | % | Summary card |
| Avg Rating | Stars | Trend line |
| Response Time | Hours | Trend line |
| Cancellation Rate | % | Summary card |

---

## 8. State Machines

### 8.1 Event Lifecycle

```
Draft ──► Pending ──► Published ──► Live ──► Completed ──► Archived
            │              │
            └── Rejected ──┘
```

| State | Description | Owner Actions |
|---|---|---|
| `draft` | Being edited, not visible | Edit, submit for approval |
| `pending` | Awaiting admin review | -- |
| `published` | Approved, visible in search | Edit (non-critical fields) |
| `live` | Event is happening now | Track execution |
| `completed` | Event ended | View analytics, rate partners |
| `rejected` | Admin rejected | Edit and resubmit |
| `archived` | Older than 6 months | View only |

### 8.2 Sponsorship Lifecycle

```
     ┌─────────────────────────────────────────────────────────────┐
     │                     SPONSOR JOURNEY                         │
     │  discovered ──► interested ──► saved ──► proposal (draft)   │
     │                                                             │
     └──────────────────────────────┬──────────────────────────────┘
                                    ▼
                           proposal: submitted
                                    │
                           ┌────────┴────────┐
                           ▼                 ▼
                     shortlisted         rejected
                           │
                           ▼
                     negotiation
                           │
                    ┌──────┴──────┐
                    ▼             ▼
                 agreed       withdrawn
                    │
                    ▼
               contracted
                    │
                    ▼
               payment_pending
                    │
                    ▼
                  active
                    │
                    ▼
               completed
                    │
              ┌─────┴─────┐
              ▼           ▼
           review      renewal ──► submitted (new cycle)
```

| State | Description | Owner Action |
|---|---|---|
| `discovered` | Sponsor viewed event | Save, interested, ignore |
| `interested` | Clicked "Interested" | Save, start proposal |
| `saved` | Bookmarked | Start proposal, remove |
| `draft` | Proposal being written | Edit, submit |
| `submitted` | Sent to organizer | Await |
| `shortlisted` | Organizer shortlisted | Await negotiation |
| `negotiating` | Active discussion | Accept counter, counter-offer, withdraw |
| `agreed` | Terms accepted by both | Generate contract |
| `contracted` | Contract signed by both | Make payment |
| `payment_pending` | Awaiting payment confirmation | Complete payment |
| `active` | Campaign running | Track deliverables |
| `completed` | Event done | Rate, review |
| `rejected` | Organizer declined | -- |
| `withdrawn` | Sponsor canceled | -- |

### 8.3 Partner Service Lifecycle

```
     ┌────────────────────────────────────────────────────────┐
     │                    PARTNER JOURNEY                     │
     │  browse_events ──► interested ──► submit_proposal      │
     │                                                        │
     │  receive_request ──► quote ──► negotiation             │
     └────────────────────────┬───────────────────────────────┘
                              ▼
                        accepted
                              │
                              ▼
                         booked
                              │
                              ▼
                     service_delivered
                              │
                              ▼
                         completed
                              │
                         ┌────┴────┐
                         ▼         ▼
                      review   repeat_business
```

| State | Description |
|---|---|
| `available` | Partner is accepting work |
| `requested` | Organizer sent service request |
| `quoted` | Partner submitted quote |
| `negotiating` | Back-and-forth on price/scope |
| `accepted` | Organizer accepted quote |
| `booked` | Service confirmed in calendar |
| `service_delivered` | Work completed |
| `completed` | Event done, payment released |
| `reviewed` | Rating and review submitted |

### 8.4 Payment Lifecycle

```
pending ──► processing ──► completed
                │
                └── failed ──► retry
```

| State | Description |
|---|---|
| `pending` | Invoice generated, awaiting payment |
| `processing` | Payment in progress (Razorpay) |
| `completed` | Payment successful |
| `failed` | Payment failed |
| `refunded` | Money returned |
| `disputed` | Under review |

### 8.5 Contract Lifecycle

```
draft ──► sent ──► signed_by_one ──► signed_by_both ──► active ──► completed ──► archived
                                           │                │
                                           └── terminated ──┘
```

---

## 9. Data Model & Core Entities

### 9.1 Entity Relationship Diagram (Logical)

```
users ──1:N──► events
users ──1:N──► sponsorship_packages (as organizer)
users ──1:N──► sponsor_proposals (as sponsor)
users ──1:N──► sponsor_campaigns (as sponsor)
users ──1:N──► sponsor_budgets (as sponsor)
users ──1:N──► partner_services (as partner)
users ──1:N──► partner_requests (as partner or organizer)
users ──1:N──► reviews (as reviewer)

events ──1:N──► sponsorship_packages
events ──1:N──► sponsor_proposals
events ──1:N──► partner_requests
events ──1:N──► sponsor_saved_events

sponsor_proposals ──1:1──► sponsor_campaigns
sponsor_proposals ──1:1──► contracts
sponsor_proposals ──N:N──► sponsor_team_members (through approvals)

partner_services ──1:N──► partner_requests
partner_requests ──1:N──► partner_quotes
partner_requests ──1:1──► contracts

contracts ──1:N──► payments

users ──1:N──► notifications
users ──1:N──► messages
users ──1:N──► conversation_participants

categories ──1:N──► events
categories ──1:N──► partner_services
```

### 9.2 New Tables Required

| Table | Purpose | Key Fields |
|---|---|---|
| `sponsor_budgets` | Fiscal year budget tracking | sponsor_id, fiscal_year, total, allocated, spent |
| `sponsor_proposals` | Full proposal with state machine (replaces simple `sponsorship_requests`) | event_id, sponsor_id, package_id, status (enum 12 states), message, budget_offer, counter_amount, timestamps per state |
| `sponsor_saved_events` | Watchlist with notes | sponsor_id, event_id, note, tags |
| `sponsor_comparisons` | Saved comparison sets | sponsor_id, name |
| `sponsor_comparison_items` | Events in a comparison | comparison_id, event_id |
| `sponsor_campaigns` | Active sponsorship tracking | proposal_id, sponsor_id, event_id, status, budget, reach, leads, roi |
| `sponsor_campaign_deliverables` | Checklist items per campaign | campaign_id, title, status, due_date |
| `sponsor_team_members` | Multi-user sponsor accounts | sponsor_id, user_id, role |
| `sponsor_internal_notes` | Private sponsor team notes | sponsor_id, event_id, campaign_id, author_id, content |
| `partner_availability` | Daily availability | partner_id, date, status, event_id |
| `partner_portfolio_items` | Past work showcase | partner_id, title, images, event_name |
| `partner_payouts` | Revenue tracking | partner_id, amount, status, period |

### 9.3 Column Additions to Existing Tables

**`events` table:**
- `target_age_group`, `target_gender`, `instagram_reach`, `youtube_reach`, `website_traffic`, `has_celebrity`, `has_govt_support`, `has_media_coverage`, `venue_type`, `ticket_price_min`, `ticket_price_max`, `previous_sponsors`, `health_score`, `health_score_updated_at`

**`users` table:**
- `company_name`, `company_logo`, `company_website`, `company_description`, `industry`, `company_size`, `year_established`, `gst_number`, `pan_number`, `verified`, `verified_at`, `is_featured`, `badges`

### 9.4 Migration Strategy

1. Run new table migrations
2. Run ALTER TABLE for `events` and `users`
3. Write data migration: copy `sponsorship_requests` -> `sponsor_proposals` with status mapping
4. Decommission old `sponsorship_requests` table (or keep for backward compat during transition)

---

## 10. Marketplace Intelligence (Future Ready)

### 10.1 AI Event Recommendations

**Goal:** Show sponsors the most relevant events based on their profile and history.

| Input | Source |
|---|---|
| Past sponsored categories | `sponsor_campaigns` via `events.category_id` |
| Budget range | `sponsor_budgets` |
| Preferred cities | Sponsor profile cities |
| Audience preferences | Past event audience demographics |
| Industry focus | Sponsor company industry |
| Seasonality | Past campaign months |

**Output:** `GET /api/sponsor/events/recommended` -> ordered list of events with match score.

### 10.2 AI Sponsor Matching

**Goal:** Recommend relevant sponsors to organizers when they publish an event.

| Input | Source |
|---|---|
| Event category | `events.category_id` |
| Event budget | `events.budget_min/max` |
| Event city | `events.city` |
| Expected audience | `events.expected_audience` |
| Past sponsors in category | `sponsor_proposals` where event category matches |

### 10.3 AI Partner Matching

**Goal:** Recommend relevant partners to organizers and vice versa.

| Input | Source |
|---|---|
| Service category vs event needs | `partner_services.category_id` |
| Partner rating | `reviews.rating` |
| Response time | `partner_requests.created_at` to first quote |
| Coverage area | `partner_services.coverage_areas` vs event city |
| Availability | `partner_availability` for event dates |

### 10.4 Predictive ROI

**Goal:** Estimate ROI before sponsorship commitment.

| Factor | Weight |
|---|---|
| Expected audience vs sponsor target | 30% |
| Past similar event ROI | 25% |
| Organizer track record | 20% |
| Social media reach | 15% |
| Seasonality factor | 10% |

### 10.5 Event Health Score (Algorithm)

Defined in Section 4.3. Store calculated value in `events.health_score`, refresh weekly or on key data change.

### 10.6 Smart Notifications

| Rule | Trigger | Action |
|---|---|---|
| New event matches sponsor criteria | Event published | Push notification |
| Budget 80% utilized | Sponsorship submitted | Alert to set next year budget |
| Partner hasn't responded in 24h | Request sent | Reminder notification |
| Event completion +7 days | Event ended | Review reminder |
| Renewal opportunity | Campaign ended 6 months ago | "Sponsor again?" prompt |

---

## 11. Vertical Slice Roadmap

### Slice 1: Sponsor Discovery & Evaluation (Weeks 1-3)

**Business outcome:** A sponsor can land on the platform, find relevant events, evaluate them, save them, compare them, and submit a proposal.

| Deliverable | Components |
|---|---|
| Sponsor dashboard | KPI cards, recommended events widget, saved events widget |
| Discover Events | Advanced search with all filters, card grid, pagination |
| Event Detail | Full evaluation screen, health score, packages, organizer info |
| Save / Unsave | Heart toggle, saved events list |
| Compare | Up to 5 events side-by-side |
| Proposal Submit | Form with package selection, message, attachments |

**Data:** `sponsor_proposals` table, `sponsor_saved_events` table, `sponsor_comparisons` tables.

**Routes:**
- `GET /sponsor/dashboard`
- `GET /sponsor/events`
- `GET /sponsor/events/{id}`
- `POST /sponsor/events/{id}/save`
- `DELETE /sponsor/events/{id}/save`
- `GET /sponsor/saved`
- `POST /sponsor/compare`
- `GET /sponsor/compare/{id}`
- `POST /sponsor/proposals`
- `GET /sponsor/proposals`

### Slice 2: Negotiation & Contracting (Weeks 4-5)

**Business outcome:** Organizers can review, shortlist, and negotiate proposals. Both parties can reach agreement and generate a contract.

| Deliverable | Components |
|---|---|
| Organizer proposal review | Inbox of incoming proposals with status filters |
| Shortlist / Reject actions | One-click actions |
| Counter offer | Amount + message |
| Negotiation thread | Timeline of offers and counter-offers |
| Contract generation | PDF with terms, amounts, dates |
| Organizer dashboard updates | Proposal KPI widgets |

**Routes:**
- `GET /organizer/proposals`
- `GET /organizer/proposals/{id}`
- `POST /organizer/proposals/{id}/shortlist`
- `POST /organizer/proposals/{id}/reject`
- `POST /organizer/proposals/{id}/counter`
- `POST /sponsor/proposals/{id}/accept-counter`
- `POST /sponsor/proposals/{id}/counter`
- `POST /sponsor/proposals/{id}/withdraw`
- `POST /proposals/{id}/generate-contract`

### Slice 3: Campaign Execution & Payments (Weeks 6-8)

**Business outcome:** Sponsors can pay, track deliverables, and measure ROI. Organizers receive payments and manage deliverables.

| Deliverable | Components |
|---|---|
| Razorpay payment integration | Checkout, callback, receipt |
| Campaign creation | From accepted proposal |
| Deliverable checklist | Organizer marks items complete |
| Campaign progress bar | Visual completion status |
| Campaign detail page | Stats, timeline, deliverables |
| Sponsor analytics (basic) | Budget, spend, reach, ROI |

**Routes:**
- `GET /sponsor/campaigns`
- `GET /sponsor/campaigns/{id}`
- `POST /campaigns/{id}/deliverables/{id}/complete`
- `GET /sponsor/analytics`
- `GET /payments/checkout/{proposal}`
- `POST /payments/callback/{payment}`
- `GET /payments/receipt/{payment}`

### Slice 4: Partner Marketplace (Weeks 9-12)

**Business outcome:** Partners can list services, receive organizer requests, submit quotes, manage availability, and get booked.

| Deliverable | Components |
|---|---|
| Partner dashboard | KPI cards, pending requests, upcoming bookings |
| Service catalog CRUD | Create, edit, list, toggle availability |
| Partner discovery | Organizer browses services, views partner profile |
| Service request | Organizer requests quote |
| Incoming request view | Detail with event info, submit quote form |
| Quote submission | Amount, note, validity |
| Accept / Reject quote | Organizer actions |
| Availability calendar | Monthly view, block/booked/available |
| Portfolio management | Add/edit/delete past work items |
| Booking view | Confirmed jobs list with detail |

**Routes:**
- `GET /partner/dashboard`
- `GET /partner/services`, `POST`, `PUT`, `DELETE`
- `GET /organizer/discover-partners`
- `GET /organizer/partners/{id}`
- `POST /organizer/partner-requests`
- `GET /partner/requests`
- `GET /partner/requests/{id}`
- `POST /partner/requests/{id}/quote`
- `POST /partner/requests/{id}/decline`
- `POST /organizer/partner-requests/{id}/accept`
- `POST /organizer/partner-requests/{id}/reject`
- `GET /partner/calendar`
- `POST /partner/calendar`
- `GET /partner/portfolio`, `POST`, `PUT`, `DELETE`
- `GET /partner/bookings`

### Slice 5: Marketplace Intelligence & Trust (Weeks 13-16)

**Business outcome:** Trust signals (reviews, verification, badges) and intelligence (recommendations, trending) drive marketplace quality.

| Deliverable | Components |
|---|---|
| Reviews & Ratings | Star rating, review text, per-partner aggregate |
| Verification system | GST/PAN upload + admin verification |
| Badge system | Verified, Premium, Top Performer, Fast Responder |
| AI recommendations | Basic matching algorithm (category + city + budget) |
| Trending events | Most viewed/saved events this week |
| Featured listings | Organizer/Partner can pay for featured placement |
| Notification system | Database notifications, bell icon, dropdown, page |
| Email notifications | Queue jobs for key events |
| Smart notifications | Reminders, alerts based on rules |

**Routes:**
- `POST /reviews`
- `GET /api/events/{id}/health-score`
- `GET /api/sponsor/events/recommended`
- `GET /api/trending`
- `GET /notifications`
- `POST /notifications/{id}/read`
- `POST /notifications/mark-all-read`

### Migration from Current Codebase

**Current to new mapping:**

| Current | Replace With | Migrate |
|---|---|---|
| `sponsorship_requests` | `sponsor_proposals` | Copy + status mapping |
| `sponsorship_contracts` | Keep, add to new contract system | Enhance |
| `partner_bids` | Keep as `partner_requests` with quote | Enhance statuses |
| `EventController@show` (organizer) | Add partner bids section + proposal section | Already done partially |
| Nav items | Full sidebar per role spec | Phase 1 done, expand |

---

*Last updated: 2026-07-03*
*Build vertically: one complete business slice at a time. Each slice is independently deployable and testable.*
