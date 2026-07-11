<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = [
        'keyword',
        'category',
        'competition_level',
        'monthly_search_volume',
        'difficulty_score',
        'intent',
    ];

    protected $casts = [
        'monthly_search_volume' => 'integer',
        'difficulty_score' => 'integer',
    ];

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeForCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeLowCompetition($query)
    {
        return $query->where('competition_level', 'low');
    }

    public function scopeHighVolume($query, int $min = 1000)
    {
        return $query->where('monthly_search_volume', '>=', $min);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getIntentLabelAttribute(): string
    {
        return match ($this->intent) {
            'informational' => 'Informational',
            'transactional' => 'Transactional',
            'navigational' => 'Navigational',
            'commercial' => 'Commercial',
            default => ucfirst($this->intent),
        };
    }
}
