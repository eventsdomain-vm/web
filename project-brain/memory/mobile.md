# Memory — Mobile Optimization

> **Source of truth:** `project.md` Section 13 — Mobile Optimization & Responsiveness.
> This file is a condensed runtime reference. For full details, always read `project.md` Section 9 first.
> If updating mobile specs, update `project.md` Section 9 first, then sync this file.

## Strategy
Mobile-first responsive design. Desktop layouts are enhancements on top of mobile base.

## Breakpoints (Tailwind CSS v3)

| Device | Width | Prefix |
|---|---|---|
| Mobile | 320-425px | (base) |
| Tablet | 768px | `md:` |
| Laptop | 1024px | `lg:` |
| Desktop | 1280px | `xl:` |
| Large Desktop | 1536px | `2xl:` |

## Principles
- **Mobile First:** `flex-col` → `md:flex-row`, `w-full` → `lg:w-1/3`
- **Touch Friendly:** 44×44px minimum hit target
- **One-Hand Nav:** Primary actions near bottom of screen
- **Performance:** lazy loading, WebP, skeleton loading, infinite scroll
- **Lightweight:** If it can be done in Blade/CSS → no JS. Heroicons SVG only

## Global Layout

### Header
- Desktop: Logo | Nav | Search | Notifications | Profile
- Mobile: ☰ Menu | Logo | Search | Notification | Avatar

### Bottom Navigation (Mobile)
Home | Explore | Events | Messages | Profile — sticky bottom tab bar

### Drawer Menu
- Alpine.js: `x-data="{ mobileMenuOpen: false }"`
- Background: `#451911` or `#9E3A26` with white text
- Page scroll locked when open (`overflow-hidden`)
- Contents: Dashboard, My Events, Sponsors, Partners, Messages, Notifications, Settings, Logout

## Key Component Behaviors

| Component | Desktop | Mobile |
|---|---|---|
| Search/Filter | Sidebar visible | Sticky bottom button → slide-up sheet |
| Data Tables | Standard table | Stacked vertical cards |
| Event Grid | 3-4 columns | Single column, infinite scroll |
| Event Detail | Hero + Gallery + Sidebar | Image slider → details → sticky CTA |
| Dashboard | 4-column cards + charts | Vertical cards + swipeable charts |
| Messaging | 3-panel layout | WhatsApp-style full screen |
| Modals | Centered | Bottom sheet or full-screen |
| File Upload | Drag & drop | Tap + camera/gallery |
| Calendar | Month view | Agenda view, swipe nav |
| Charts | Full size | Swipeable + summary cards |
| Admin Panel | Sidebar + widgets | Drawer nav + card-based |
| Sidebar | Always visible | Drawer, tap hamburger |
| Cards | Hover effect | Tap animation, no hover, no `shadow-lg` |
| Buttons | Normal | Full-width, 44px+ height |

## Event Cards (Mobile)
- Max 1 column, single card vertical scroll
- No `shadow-lg` or `shadow-xl` — `shadow-sm` max
- Image size target: < 200KB per card. WebP + srcset
- Each card is a single tap target
- Show only: Banner, Category, Location, Date, Audience, Price

## Loading Strategy
| Priority | Load Immediately | Lazy Load |
|---|---|---|
| Critical | Header, Event list, CTA buttons | — |
| High | Page shell, skeleton UI | — |
| Medium | — | Images, sponsor logos, partner cards |
| Low | — | Analytics charts, historical data |

- Skeleton UI (CSS placeholders) over spinners

## Forms
- Single column, large inputs, large buttons (44px+)
- `autocomplete`, `autocapitalize="none"`, `type="number|email|tel"`
- Bottom sheet selectors on mobile
- Multi-step wizards (create event: 8 steps)

## Images
- `loading="lazy"` on all banners/logos
- WebP format, responsive `srcset`
- Target < 200KB per card image
- Progressive loading with blur placeholder

## Performance Targets
- FCP < 2s, LCP < 2.5s, CLS < 0.1
- Lighthouse: Performance > 95, Accessibility > 95, SEO > 95

## Viewport
```html
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
```

## Rule
Every new page/module must be fully responsive by default. No desktop-only layouts allowed.
