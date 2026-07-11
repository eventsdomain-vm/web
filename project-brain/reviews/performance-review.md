# Performance Review Checklist

## Database
- [ ] No N+1 queries — eager loading used
- [ ] Indexes exist on filtered/joined columns
- [ ] Pagination used for list endpoints
- [ ] FULLTEXT indexes on search columns
- [ ] No `SELECT *` — columns specified
- [ ] No heavy operations in sync request

## Caching
- [ ] Static data cached (categories, cities)
- [ ] Dashboard stats cached with TTL
- [ ] Cache invalidated on model changes

## Frontend
- [ ] Images lazy loaded
- [ ] Assets bundled via Vite
- [ ] Debounce on search inputs
- [ ] No excessive Alpine.js watchers
- [ ] CSS purged (no unused classes)

## General
- [ ] No `dd()`/`dump()` in committed code
- [ ] Debugbar disabled in production
- [ ] App debug set to false in production
- [ ] Route model binding used
