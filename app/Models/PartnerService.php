<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PartnerService extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'category_id',
        'title',
        'description',
        'price',
        'price_type',
        'pricing_model',
        'is_available',
        'availability_calendar',
        'min_notice_days',
        'portfolio_images',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'min_notice_days' => 'integer',
        'availability_calendar' => 'array',
        'portfolio_images' => 'array',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(PartnerServiceReview::class, 'service_id');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(PartnerRequest::class, 'service_id');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(PartnerBid::class, 'service_id');
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeForCategory($query, int $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getAverageRatingAttribute(): ?float
    {
        $avg = $this->reviews()->avg('rating');

        return $avg ? round($avg, 1) : null;
    }

    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    public function getFormattedPriceAttribute(): string
    {
        return '₹'.number_format($this->price, 0);
    }

    public function getPriceTypeLabelAttribute(): string
    {
        return match ($this->price_type) {
            'fixed' => 'Fixed Price',
            'hourly' => 'Per Hour',
            'negotiable' => 'Negotiable',
            default => ucfirst($this->price_type),
        };
    }

    public function getPricingModelLabelAttribute(): string
    {
        return match ($this->pricing_model) {
            'cost' => 'Paid',
            'barter' => 'Barter',
            'hybrid' => 'Hybrid',
            default => ucfirst($this->pricing_model),
        };
    }
}
