<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SponsorCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'sponsor_id',
        'event_id',
        'status',
        'budget',
        'spent',
        'target_reach',
        'actual_reach',
        'leads_generated',
        'brand_mentions',
        'roi',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'budget' => 'decimal:2',
            'spent' => 'decimal:2',
            'roi' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(SponsorProposal::class, 'proposal_id');
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function deliverables(): HasMany
    {
        return $this->hasMany(SponsorCampaignDeliverable::class, 'campaign_id');
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(SponsorCampaignMilestone::class, 'campaign_id');
    }

    public function brandAssets(): HasMany
    {
        return $this->hasMany(SponsorBrandAsset::class, 'campaign_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(SponsorTask::class, 'campaign_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(SponsorDocument::class, 'campaign_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getProgressAttribute(): int
    {
        $total = $this->deliverables()->count();
        if ($total === 0) {
            return 0;
        }

        $completed = $this->deliverables()->whereIn('status', ['completed', 'cancelled'])->count();

        return (int) round(($completed / $total) * 100);
    }
}
