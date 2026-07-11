<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizerRenewal extends Model
{
    protected $fillable = [
        'user_id', 'sponsor_id', 'contract_id', 'status',
        'proposed_value', 'probability', 'expected_close_date',
        'notes', 'renewed_at',
    ];

    protected function casts(): array
    {
        return [
            'proposed_value' => 'decimal:2',
            'probability' => 'integer',
            'expected_close_date' => 'date',
            'renewed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(SponsorshipContract::class);
    }
}
