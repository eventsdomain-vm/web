# Code Quality Review Checklist

## Readability
- [ ] Clear variable and method names
- [ ] No deeply nested conditionals
- [ ] Methods under 20 lines where practical
- [ ] Controllers under 50 lines per method
- [ ] Services under 200 lines per class
- [ ] Blade files under 150 lines

## Maintainability
- [ ] Duplicated logic extracted to shared methods/services
- [ ] No magic numbers — use constants
- [ ] No long parameter lists (>3 → use DTO/array)
- [ ] Dependencies injected via constructor
- [ ] SOLID principles followed

## Error Handling
- [ ] Try/catch with meaningful error responses
- [ ] Validation errors returned properly
- [ ] 404 handling for missing resources
- [ ] Logging for unexpected errors
- [ ] User-friendly error messages

## Testing
- [ ] Feature/Browser tests for critical paths
- [ ] Unit tests for complex service logic
- [ ] Test coverage ≥ 70% for new code
- [ ] Edge cases considered in tests
