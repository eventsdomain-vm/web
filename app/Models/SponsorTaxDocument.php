<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorTaxDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'invoice_id',
        'type',
        'document_number',
        'file_path',
        'document_date',
        'amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'document_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(SponsorInvoice::class, 'invoice_id');
    }
}
