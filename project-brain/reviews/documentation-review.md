# Documentation Review Checklist

## Code Documentation
- [ ] Public methods documented with PHPDoc
- [ ] `@param` and `@return` present
- [ ] Complex logic has inline explanation
- [ ] No outdated comments

## Memory Documentation
- [ ] memory/*.md files reflect current state
- [ ] routing.md synced with `php artisan route:list`
- [ ] database.md synced with migrations
- [ ] dependencies.md matches composer.json + package.json
- [ ] Files under 500 lines each

## Change Documentation
- [ ] tasks/completed.md updated
- [ ] changelog.md updated
- [ ] graph updated if relevant
