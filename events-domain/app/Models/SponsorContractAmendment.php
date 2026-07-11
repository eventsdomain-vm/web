<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorContractAmendment extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'title',
        'description',
        'type',
        'status',
        'changed_clauses',
        'amount_adjustment',
        'effective_date',
        'expiry_date',
        'signed_at',
        'signed_by',
    ];

    protected function casts(): array
    {
        return [
            'changed_clauses' => 'array',
            'amount_adjustment' => 'decimal:2',
            'effective_date' => 'date',
            'expiry_date' => 'date',
            'signed_at' => 'timestamp',
        ];
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(SponsorshipContract::class, 'contract_id');
    }

    public function signee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signed_by');
    }
}
