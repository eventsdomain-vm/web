<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizerSponsorRelationship extends Model
{
    protected $fillable = [
        'user_id', 'sponsor_id', 'event_id', 'relationship_type',
        'status', 'health_score', 'last_engagement_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'health_score' => 'integer',
            'last_engagement_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
