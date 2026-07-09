<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsorBudgetAllocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sponsor_budget_allocations';

    protected $fillable = [
        'sponsor_id',
        'fiscal_year',
        'category_allocations',
        'total_budget',
        'allocated_so_far',
        'status',
        'valid_from',
        'valid_to',
    ];

    protected $casts = [
        'total_budget' => 'decimal:2',
        'allocated_so_far' => 'decimal:2',
        'category_allocations' => 'array',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }
}