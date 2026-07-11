<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerDeal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'partner_id', 'lead_id', 'sponsor_id', 'event_id', 'stage',
        'deal_value', 'commission_rate', 'expected_close_date',
        'closed_at', 'lost_reason', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'deal_value' => 'decimal:2',
            'commission_rate' => 'decimal:2',
            'expected_close_date' => 'date',
            'closed_at' => 'datetime',
        ];
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(PartnerLead::class);
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(PartnerCommission::class, 'deal_id');
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(PartnerMeeting::class, 'deal_id');
    }
}
