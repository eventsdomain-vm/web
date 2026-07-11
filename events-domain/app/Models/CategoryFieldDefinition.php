<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class CategoryFieldDefinition extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'section_key',
        'field_key',
        'label',
        'input_type',
        'is_visible',
        'is_required',
        'options',
        'sort_order',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'is_required' => 'boolean',
        'options' => 'array',
        'sort_order' => 'integer',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeForCategory($query, ?int $categoryId)
    {
        return $query->where(function ($q) use ($categoryId) {
            // Global defaults (category_id IS NULL)
            $q->whereNull('category_id')
              // OR category-specific overrides
                ->orWhere('category_id', $categoryId);
        });
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('field_key');
    }

    public function scopeSection($query, string $sectionKey)
    {
        return $query->where('section_key', $sectionKey);
    }

    // =========================================================================
    // Cache helpers
    // =========================================================================

    /**
     * Get resolved field definitions for a category, with caching.
     *
     * Resolution logic:
     * 1. Start with all global defaults (category_id IS NULL)
     * 2. Overlay category-specific overrides
     * 3. Group by section_key
     *
     * @return array<string, array<int, self>> section_key → fields
     */
    public static function resolveForCategory(?int $categoryId): array
    {
        $cacheKey = "category_fields_{$categoryId}";

        return Cache::remember($cacheKey, 3600, function () use ($categoryId) {
            // 1. Get global defaults
            $globalFields = static::whereNull('category_id')
                ->visible()
                ->ordered()
                ->get();

            // 2. Get category-specific overrides
            $categoryFields = $categoryId
                ? static::where('category_id', $categoryId)
                    ->visible()
                    ->ordered()
                    ->get()
                : collect();

            // 3. Merge: category overrides replace globals by (section_key, field_key)
            $merged = [];
            foreach ($globalFields as $field) {
                $merged[$field->section_key.'.'.$field->field_key] = $field;
            }
            foreach ($categoryFields as $field) {
                $merged[$field->section_key.'.'.$field->field_key] = $field;
            }

            // 4. Group by section_key
            $grouped = [];
            foreach ($merged as $field) {
                $grouped[$field->section_key][] = $field;
            }

            // Sort each section
            foreach ($grouped as $section => &$fields) {
                usort($fields, fn ($a, $b) => $a->sort_order <=> $b->sort_order);
            }

            return $grouped;
        });
    }

    /**
     * Clear the cache for a category's field definitions.
     */
    public static function clearCacheForCategory(?int $categoryId): void
    {
        Cache::forget("category_fields_{$categoryId}");
    }

    /**
     * Clear all category field caches.
     */
    public static function clearAllCaches(): void
    {
        // Clear for all categories + null (global)
        $categoryIds = static::whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id')
            ->toArray();

        $categoryIds[] = null;

        foreach ($categoryIds as $catId) {
            static::clearCacheForCategory($catId);
        }
    }
}
