<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'type',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeForEvent($query, int $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getLastMessageAttribute(): ?Message
    {
        return $this->messages()->latest()->first();
    }

    public function getParticipantNamesAttribute(): string
    {
        return $this->participants->pluck('user.name')->implode(', ');
    }
}
