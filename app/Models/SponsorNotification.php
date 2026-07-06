<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'user_id',
        'type',
        'title',
        'body',
        'icon',
        'color',
        'action_url',
        'action_label',
        'reference_type',
        'reference_id',
        'read_at',
        'dismissed_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'dismissed_at' => 'datetime',
        ];
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeUnread($q)
    {
        return $q->whereNull('read_at');
    }

    public function markAsRead(): void
    {
        if (is_null($this->read_at)) {
            $this->update(['read_at' => now()]);
        }
    }

    public function dismiss(): void
    {
        $this->update(['dismissed_at' => now()]);
    }
}
