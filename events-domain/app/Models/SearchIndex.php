<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SearchIndex extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'search_indexes';

    protected $fillable = [
        'indexable_type',
        'indexable_id',
        'search_engine',
        'object_id',
        'title',
        'content',
        'url',
        'categories',
        'tags',
        'metadata',
        'ranking_score',
        'indexed_at',
        'status',
        'error_message',
    ];

    protected $casts = [
        'categories' => 'array',
        'tags' => 'array',
        'metadata' => 'array',
        'indexed_at' => 'datetime',
        'ranking_score' => 'decimal:4',
    ];

    public function indexable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function getIndexedCount(string $engine = 'meilisearch'): int
    {
        return self::where('search_engine', $engine)
            ->where('status', 'indexed')
            ->count();
    }

    public static function getPendingCount(string $engine = 'meilisearch'): int
    {
        return self::where('search_engine', $engine)
            ->where('status', 'pending')
            ->count();
    }
}
