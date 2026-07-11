<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Backlink extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_url',
        'source_url',
        'anchor_text',
        'domain_authority',
        'link_type',
        'status',
    ];

    protected $casts = [
        'domain_authority' => 'integer',
    ];

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForUrl($query, string $url)
    {
        return $query->where('target_url', $url);
    }

    public function scopeHighAuthority($query, int $min = 50)
    {
        return $query->where('domain_authority', '>=', $min);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getAuthorityColorAttribute(): string
    {
        return match (true) {
            $this->domain_authority >= 70 => 'text-green-600',
            $this->domain_authority >= 40 => 'text-yellow-600',
            default => 'text-red-600',
        };
    }
}
