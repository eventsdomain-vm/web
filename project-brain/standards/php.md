# Standards — PHP & Laravel

## Typing
- `declare(strict_types=1)` at top of every class file
- Type-hint all function parameters and return types
- Use PHP 8.2+ typed properties
- No mixed types unless absolutely necessary

## Code Style (PSR-12 + Laravel Pint)
- Namespace: `App\Http\Controllers`, `App\Models`, `App\Services`
- Class brace on next line, method brace on next line
- 4 spaces for indentation (no tabs)
- Line length: max 120 chars
- Visibility: `public`, `protected`, `private` everywhere

## Class Structure
```php
declare(strict_types=1);

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventService
{
    public function create(array $data): Event
    {
        return DB::transaction(function () use ($data) {
            // ...
        });
    }
}
```

## Controller Rules
- Max 1 service call per method
- No business logic in controllers
- Always type-hint FormRequest for validation
- Return RedirectResponse or View

## Model Rules
- Use `$fillable` or `$guarded` — never both
- Define all relationships explicitly
- Use `$casts` for attribute typing
- Use `$with` for eager loading defaults

## Service Rules
- One service per domain concept
- Services are stateless (no property state)
- Return typed results (Model, Collection, DTO)
- Use `DB::transaction()` for multi-step operations
