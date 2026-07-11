<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'query',
        'user_id',
        'ip_address',
        'results_count',
    ];

    protected $casts = [
        'results_count' => 'integer',
    ];

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePopular($query, int $limit = 10)
    {
        return $query
            ->selectRaw('query, COUNT(*) as search_count')
            ->groupBy('query')
            ->orderByDesc('search_count')
            ->limit($limit);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public static function logSearch(string $query, ?int $userId = null, int $resultsCount = 0): static
    {
        return static::create([
            'query' => $query,
            'user_id' => $userId,
            'ip_address' => request()->ip(),
            'results_count' => $resultsCount,
        ]);
    }
}
