<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsorObjective extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sponsor_objectives';

    protected $fillable = [
        'sponsor_id',
        'name',
        'description',
        'objective_type',
        'target_kpi_value',
        'kpi_unit',
        'estimated_cost',
        'estimated_roi',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'target_kpi_value' => 'decimal:2',
        'estimated_cost' => 'decimal:2',
        'estimated_roi' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }
}
