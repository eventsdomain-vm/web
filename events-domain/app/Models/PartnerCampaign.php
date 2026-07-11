<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerCampaign extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'partner_id', 'deal_id', 'sponsor_id', 'event_id', 'name',
        'status', 'start_date', 'end_date', 'budget',
        'deliverables', 'branding', 'media_assets',
        'attendance', 'engagement', 'media_coverage',
        'roi_metrics', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'budget' => 'decimal:2',
            'deliverables' => 'array',
            'branding' => 'array',
            'media_assets' => 'array',
            'roi_metrics' => 'array',
            'attendance' => 'integer',
            'engagement' => 'decimal:2',
        ];
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(PartnerDeal::class);
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
