<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'parent_id',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function partnerServices(): HasMany
    {
        return $this->hasMany(PartnerService::class);
    }

    public function fieldDefinitions(): HasMany
    {
        return $this->hasMany(CategoryFieldDefinition::class);
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function isParent(): bool
    {
        return is_null($this->parent_id);
    }

    public function getFullNameAttribute(): string
    {
        if ($this->parent) {
            return "{$this->parent->name} > {$this->name}";
        }

        return $this->name;
    }

    public static function cachedActive(): Collection
    {
        return Cache::remember('categories_active_ordered', 3600, function () {
            return static::active()->ordered()->get();
        });
    }

    public static function flushCache(): void
    {
        Cache::forget('categories_active_ordered');
    }
}
