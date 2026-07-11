<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConversationParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'last_read_at',
    ];

    protected $casts = [
        'last_read_at' => 'datetime',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function hasUnreadMessages(): bool
    {
        $lastMessage = $this->conversation->messages()->latest()->first();

        if (! $lastMessage) {
            return false;
        }

        return $this->last_read_at === null || $this->last_read_at->lt($lastMessage->created_at);
    }

    public function markAsRead(): void
    {
        $this->update(['last_read_at' => now()]);
    }
}
