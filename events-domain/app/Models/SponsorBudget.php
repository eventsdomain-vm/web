<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'fiscal_year',
        'total_budget',
        'allocated',
        'spent',
        'currency',
    ];

    protected function casts(): array
    {
        return [
            'fiscal_year' => 'integer',
            'total_budget' => 'decimal:2',
            'allocated' => 'decimal:2',
            'spent' => 'decimal:2',
        ];
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function getRemainingAttribute(): float
    {
        return (float) ($this->total_budget - $this->allocated - $this->spent);
    }

    public function scopeForYear($query, int $year)
    {
        return $query->where('fiscal_year', $year);
    }
}
