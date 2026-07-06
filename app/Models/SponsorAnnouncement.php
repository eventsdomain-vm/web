<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SponsorAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'created_by',
        'title',
        'body',
        'type',
        'audience_type',
        'status',
        'published_at',
        'archived_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'timestamp',
            'archived_at' => 'timestamp',
        ];
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(SponsorAnnouncementReceipt::class, 'announcement_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function publish(): void
    {
        $this->update(['status' => 'published', 'published_at' => now()]);
    }

    public function archive(): void
    {
        $this->update(['status' => 'archived', 'archived_at' => now()]);
    }
}
