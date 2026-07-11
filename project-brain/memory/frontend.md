# Memory — Frontend

## Stack
- Blade templates (Laravel native)
- Tailwind CSS v3
- Alpine.js 3
- Vite (build tool)

## Design Constraints
- No SPA frameworks (React, Vue, Angular)
- No jQuery
- No custom CSS unless absolutely required
- Mobile-first responsive design
- Terracotta theme (#E35336 primary)

## Layout Structure
```
resources/views/
├── layouts/
│   ├── guest.blade.php          (auth pages)
│   ├── organizer.blade.php      (organizer dashboard shell)
│   ├── sponsor.blade.php        (sponsor dashboard shell)
│   ├── partner.blade.php        (partner dashboard shell)
│   └── admin.blade.php          (admin dashboard shell)
├── components/
│   ├── ui/
│   │   ├── card.blade.php
│   │   ├── button.blade.php
│   │   ├── badge.blade.php
│   │   ├── table.blade.php
│   │   ├── modal.blade.php
│   │   ├── filter.blade.php
│   │   └── pagination.blade.php
│   ├── forms/
│   │   ├── input.blade.php
│   │   ├── select.blade.php
│   │   ├── textarea.blade.php
│   │   ├── checkbox.blade.php
│   │   ├── radio.blade.php
│   │   └── file-upload.blade.php
│   └── sponsor-package-builder.blade.php   (Alpine.js)
├── organizer/
│   ├── dashboard.blade.php
│   ├── events/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   ├── messages.blade.php
│   └── profile.blade.php
├── sponsor/
│   ├── dashboard.blade.php
│   ├── discover.blade.php
│   ├── messages.blade.php
│   └── profile.blade.php
├── partner/
│   ├── dashboard.blade.php
│   ├── services/
│   ├── opportunities.blade.php
│   ├── messages.blade.php
│   └── profile.blade.php
├── admin/
│   ├── dashboard.blade.php
│   ├── events/
│   ├── users/
│   ├── categories/
│   └── settings/
├── auth/
└── public/
    ├── home.blade.php
    ├── events.blade.php
    ├── event-detail.blade.php
    ├── pricing.blade.php
    ├── roi-calculator.blade.php
    └── contact.blade.php
```

## Alpine.js Components
| Component | Purpose |
|---|---|
| sponsorship-package-builder | Multi-tier package creation with live preview |
| event-search-filter | Dynamic filtering without page reload |
| multi-step-form | Event creation wizard |
| availability-calendar | Partner availability management |
| message-thread | Real-time messaging (with Laravel Reverb) |
| notification-dropdown | In-app notification center |
| roi-calculator | Interactive ROI estimation |
