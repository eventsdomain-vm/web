<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsorTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sponsor_id',
        'campaign_id',
        'contract_id',
        'created_by',
        'title',
        'description',
        'priority',
        'status',
        'due_date',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'completed_at' => 'timestamp',
        ];
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(SponsorCampaign::class, 'campaign_id');
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(SponsorshipContract::class, 'contract_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignees(): HasMany
    {
        return $this->hasMany(SponsorTaskAssignee::class, 'task_id');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['todo', 'in_progress']);
    }

    public function scopeOverdue($query)
    {
        return $query->whereIn('status', ['todo', 'in_progress'])
            ->where('due_date', '<', now());
    }
}
