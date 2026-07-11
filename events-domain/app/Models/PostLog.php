<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostLog extends Model
{
    use HasFactory;

    protected $table = 'post_logs';

    protected $fillable = [
        'event_post_id',
        'platform',
        'status',
        'response',
        'error_message',
        'post_url',
        'published_at',
        'reach_impressions',
        'reach_reach',
        'engagement_likes',
        'engagement_comments',
        'engagement_shares',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'reach_impressions' => 'integer',
        'reach_reach' => 'integer',
        'engagement_likes' => 'integer',
        'engagement_comments' => 'integer',
        'engagement_shares' => 'integer',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function eventPost(): BelongsTo
    {
        return $this->belongsTo(EventPost::class, 'event_post_id');
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeForPlatform($query, string $platform)
    {
        return $query->where('platform', $platform);
    }
}
