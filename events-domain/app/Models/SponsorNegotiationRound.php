<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorNegotiationRound extends Model
{
    use HasFactory;

    protected $fillable = [
        'negotiation_id',
        'user_id',
        'message',
        'offer',
        'terms',
    ];

    protected function casts(): array
    {
        return [
            'offer' => 'decimal:2',
            'terms' => 'array',
        ];
    }

    public function negotiation(): BelongsTo
    {
        return $this->belongsTo(SponsorNegotiation::class, 'negotiation_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
