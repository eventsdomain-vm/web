<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'platforms',
        'content',
        'status',
        'scheduled_at',
    ];

    protected $casts = [
        'platforms' => 'array',
        'content' => 'array',
        'scheduled_at' => 'datetime',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(PostLog::class, 'event_post_id');
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeForEvent($query, int $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'scheduled' => 'Scheduled',
            'publishing' => 'Publishing',
            'published' => 'Published',
            'partial' => 'Partially Published',
            'failed' => 'Failed',
            default => ucfirst($this->status),
        };
    }
}
