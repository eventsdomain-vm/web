<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsorPreference extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sponsor_preferences';

    protected $fillable = [
        'sponsor_id',
        'target_audience_demographics',
        'category_preferences',
        'event_types',
        'geographic_preferences',
        'budget_range',
        'formats_preferred',
        'industry_targets',
        'min_audience_size',
        'max_audience_size',
        'notes',
    ];

    protected $casts = [
        'target_audience_demographics' => 'array',
        'category_preferences' => 'array',
        'event_types' => 'array',
        'geographic_preferences' => 'array',
        'budget_range' => 'array',
        'formats_preferred' => 'array',
        'industry_targets' => 'array',
        'min_audience_size' => 'integer',
        'max_audience_size' => 'integer',
    ];

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }
}
