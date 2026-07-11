# Template — New Module

```php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\{Module}Request;
use App\Http\Controllers\Controller;
use App\Models\{Module};
use App\Services\{Module}Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class {Module}Controller extends Controller
{
    public function __construct(
        private readonly {Module}Service ${module}Service,
    ) {}

    public function index(): View
    {
        $items = $this->{module}Service->getAll();
        return view('{module}.index', compact('items'));
    }

    public function create(): View
    {
        return view('{module}.create');
    }

    public function store({Module}Request $request): RedirectResponse
    {
        ${module} = $this->{module}Service->create($request->validated());
        return to_route('{module}.show', ${module})
            ->with('success', '{Module} created successfully.');
    }
}
```

## Service Template
```php
declare(strict_types=1);

namespace App\Services;

use App\Models\{Module};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class {Module}Service
{
    public function getAll(): Collection
    {
        return {Module}::latest()->get();
    }

    public function create(array $data): {Module}
    {
        return DB::transaction(function () use ($data) {
            return {Module}::create($data);
        });
    }
}
```

## Blade Component Template
```blade
@props([
    'title' => '',
    'description' => '',
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-sm border border-gray-200 p-6']) }}>
    @if($title)
        <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
    @endif
    @if($description)
        <p class="mt-1 text-sm text-gray-600">{{ $description }}</p>
    @endif
    {{ $slot }}
</div>
```

## Policy Template
```php
declare(strict_types=1);

namespace App\Policies;

use App\Models\{Module};
use App\Models\User;

class {Module}Policy
{
    public function view(User $user, {Module} ${module}): bool
    {
        return $user->can('view-{module}');
    }

    public function create(User $user): bool
    {
        return $user->can('create-{module}');
    }

    public function update(User $user, {Module} ${module}): bool
    {
        return $user->id === ${module}->user_id || $user->hasRole('admin');
    }

    public function delete(User $user, {Module} ${module}): bool
    {
        return $user->id === ${module}->user_id || $user->hasRole('admin');
    }
}
```

## Form Request Template
```php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Store{Module}Request extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', {Module}::class);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
        ];
    }
}
```

## Migration Template
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('{table_name}', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Add columns here
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('{table_name}');
    }
};
```
