<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SponsorshipPackage extends Model
{
    use HasFactory;

    /**
     * The domain redesign renamed this table to `sponsor_packages` (the spec's
     * "Sponsor Packages"). The class name is retained so existing controllers
     * and views keep working unchanged.
     */
    protected $table = 'sponsor_packages';

    protected $fillable = [
        'event_id',
        'title',
        'level',
        'description',
        'price',
        'currency',
        'budget_range_label',
        'slots_available',
        'slots_filled',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'slots_available' => 'integer',
        'slots_filled' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function benefitRecords(): HasMany
    {
        return $this->hasMany(SponsorshipBenefit::class, 'package_id');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(SponsorshipRequest::class, 'package_id');
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price');
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getSlotsRemainingAttribute(): int
    {
        return $this->slots_available - $this->slots_filled;
    }

    public function isAvailable(): bool
    {
        return $this->is_active && $this->slots_remaining > 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return '₹'.number_format($this->price, 0);
    }
}
