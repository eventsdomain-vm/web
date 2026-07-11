<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerMeeting extends Model
{
    protected $fillable = [
        'partner_id', 'sponsor_id', 'deal_id', 'lead_id',
        'title', 'description', 'type', 'location', 'meeting_link',
        'start_time', 'end_time', 'timezone', 'status',
        'notes', 'minutes', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(PartnerDeal::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(PartnerLead::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
