<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SponsorComparison extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'name',
    ];

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(SponsorComparisonItem::class, 'comparison_id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'sponsor_comparison_items', 'comparison_id', 'event_id');
    }
}
