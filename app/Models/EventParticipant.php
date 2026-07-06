<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'participant_id',
        'participant_type_id',
        'event_date_id',
        'role_label',
        'session_title',
        'performance_start',
        'performance_end',
        'sort_order',
    ];

    protected $casts = [
        'performance_start' => 'datetime',
        'performance_end' => 'datetime',
        'sort_order' => 'integer',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function participantType(): BelongsTo
    {
        return $this->belongsTo(ParticipantType::class);
    }

    public function eventDate(): BelongsTo
    {
        return $this->belongsTo(EventDate::class);
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeForEvent($query, int $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeForType($query, int $typeId)
    {
        return $query->where('participant_type_id', $typeId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
