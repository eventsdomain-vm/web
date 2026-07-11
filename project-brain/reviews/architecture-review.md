# Architecture Review Checklist

## Structure
- [ ] Follows established architecture (memory/architecture.md)
- [ ] Controllers are thin — logic in Services
- [ ] Form Requests used for validation
- [ ] Policies used for authorization
- [ ] Eloquent relationships used correctly
- [ ] No tight coupling between modules

## Patterns
- [ ] Service Layer pattern followed
- [ ] No business logic in Blade files
- [ ] No raw SQL unless absolutely necessary
- [ ] Database transactions for multi-step operations
- [ ] Queue jobs for async work
- [ ] RESTful routing conventions

## Standards
- [ ] PSR-12 coding style
- [ ] declare(strict_types=1) present
- [ ] Naming conventions followed (standards/naming.md)
- [ ] Proper namespace usage
- [ ] No dead code or commented-out code
