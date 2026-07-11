# Standards — Performance

> Every millisecond matters. Every kilobyte matters. The platform must feel instant on mobile, smooth on low-end devices.

## Database
- All queries use indexes — verify with EXPLAIN
- N+1 prevention: use `->with()` or `->load()` for relationships. Never query inside loops
- Paginate all list endpoints: `paginate(15)` default, `paginate(10)` on mobile, `paginate(20)` on desktop
- Use `chunk()` or `lazy()` for large dataset operations
- FULLTEXT indexes on search columns (events.description, events.tags, sponsorship_packages.description)
- Avoid `SELECT *` — specify columns explicitly
- Indexes required on: `event_category_id`, `location`, `event_date`, `sponsorship_status`
- Keep tables normalized but not over-normalized
- Avoid JSON-heavy queries for filters; avoid deep nested joins without caching
- Never `->get()` without `->take()` limit on unbounded queries

## Caching
| Data | TTL | Invalidation |
|---|---|---|
| Categories, Cities, Settings | 86400s (24h) | On admin edit |
| Event listings | 300s (5min) | On event create/update |
| Dashboard stats | 300s (5min) | On status change |
| Sponsor/Partner lists | 600s (10min) | On profile update |

```php
Cache::remember('categories', 86400, fn() => Category::all());
Cache::remember('events_home', 300, fn() => Event::latest()->take(20)->get());
Cache::remember("dashboard_stats_{$userId}", 300, fn() => ...);
```

- Use Redis/Memcached in production (config ready)
- Invalidate cache on model save/delete

## Frontend
- Lazy load images (`loading="lazy"`)
- Vite asset bundling with cache busting
- Minimize Alpine.js component count per page
- Debounce search inputs (300ms)
- Use CSS `will-change` sparingly
- **Skeleton UI** over spinners — lightweight CSS placeholders
- **Heroicons (SVG)** — inline SVGs, no external icon packs
- **Simple CSS transitions** — no animation libraries (Lottie, GSAP, etc.)

## Assets
- Compress all images to WebP format (target < 200KB per card image)
- Use responsive image sets (`srcset`)
- Bundle and minify with Vite (tree-shaking enabled)
- Font subsetting for custom fonts
- No external heavy icon packs or multiple CSS frameworks

## Network
- Enable gzip compression on Apache/Nginx
- Set HTTP caching headers on static assets (Cache-Control: public, max-age=31536000)
- Combine API calls where possible (batch endpoints)
- Reduce external HTTP requests — self-host fonts/icons where feasible

## Anti-Patterns
- ❌ Heavy SPA architecture
- ❌ Overusing JavaScript (Blade + CSS first)
- ❌ Loading all data at once (always paginate)
- ❌ Large image assets (>200KB)
- ❌ Complex animations
- ❌ Uncached queries on static data
- ❌ Duplicate Blade layouts
- ❌ Multiple CSS frameworks
- ❌ External heavy icon packs
- ❌ Querying inside loops
