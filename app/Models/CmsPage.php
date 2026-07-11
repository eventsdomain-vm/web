<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CmsPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // =========================================================================
    // Boot
    // =========================================================================

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getUrlAttribute(): string
    {
        return "/{$this->slug}";
    }
}
