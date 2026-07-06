<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'attachment_url',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeForConversation($query, int $conversationId)
    {
        return $query->where('conversation_id', $conversationId);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    public function getIsReadAttribute(): bool
    {
        return $this->read_at !== null;
    }
}
