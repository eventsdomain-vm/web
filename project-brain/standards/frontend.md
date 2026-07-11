# Standards — Frontend (Blade + Tailwind + Alpine)

## Core Philosophy
- **If it can be done in Blade or CSS → do NOT use JS**
- Blade is the primary rendering engine. No React/Vue/Angular
- Reserve JS for: dropdowns, modals, tabs, filters, mobile nav only
- Every reusable UI unit must be a Blade component — stateless where possible

## Blade
- Use `<x-*>` components for all reusable UI
- Keep view logic minimal — no queries in Blade
- Use `@props` for component attributes
- Use `@isset` / `@empty` for conditional rendering
- No PHP business logic in Blade files
- Avoid duplicate layouts — extend shared components

## Tailwind CSS
- Utility classes only — no custom CSS
- Use `@apply` only in component CSS files (rare)
- Purge unused classes — content paths must scan all Blade + JS files
- Follow Terracotta theme:
  - Primary: `bg-[#E35336]`
  - Hover: `hover:bg-[#FFB0A1]`
  - Dark: `text-[#9E3A26]`
  - Dark bg: `bg-[#451911]`
- Responsive: mobile-first (`sm:`, `md:`, `lg:`, `xl:`)
- Dark mode: use `dark:` variants
- No multiple CSS frameworks — Tailwind only

## Alpine.js
- Use `x-data` for component state
- Use `x-init` for initialization
- Use `x-on:click` for events (not `@click`)
- Use `x-model` for form bindings
- Use `x-show` / `x-cloak` for visibility
- Use `x-transition` for animations (modals, drawers — native-feel, lightweight)
- Size limit: max 50 lines per component, extract to separate file if larger
- Use `$wire` if needed (not currently using Livewire)

## Vite
- Entry: `resources/js/app.js`
- CSS: `resources/css/app.css`
- Build: `npm run build` — ensures minified CSS + JS + tree-shaking
- Dev: `npm run dev`
- Must ensure: minification enabled, tree-shaking active, no dead code

## Icons & Animations
- **Heroicons (SVG)** — inline SVGs for all icons. No external font-based icon packs
- **Simple CSS transitions only** — `transition`, `transform`, `opacity`
- **No** Lottie, GSAP, Framer Motion, or large animation libraries
- **Skeleton UI** — lightweight CSS placeholders preferred over spinners
