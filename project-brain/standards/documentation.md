# Standards — Documentation

## What to Document
- All public methods in Services — PHPDoc with @param and @return
- All model relationships — PHPDoc describing relationship
- All policies — what access each method grants
- All Form Requests — what each rule validates
- Complex Blade components — props documentation

## PHPDoc Format
```php
/**
 * Create a new event with sponsorship packages.
 *
 * @param array{title: string, category_id: int, ...} $data
 * @return Event
 *
 * @throws \App\Exceptions\EventCreationException
 */
public function create(array $data): Event
{
    // ...
}
```

## File Headers
Skip file-level docblocks. Class-level docblocks only when the purpose is not obvious.

## Memory Files
- Keep under 500 lines each
- Update only affected sections after changes
- Never regenerate entire file
- Run `php artisan route:list` and sync routing.md after route changes
- Run `php artisan migrate:status` and sync database.md after migrations
