<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorCampaignMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'title',
        'description',
        'due_date',
        'completed_at',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'completed_at' => 'date',
        ];
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(SponsorCampaign::class, 'campaign_id');
    }
}
