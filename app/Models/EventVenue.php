<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventVenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'venue_type',
        'venue_name',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'virtual_url',
        'virtual_platform',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function stages()
    {
        return $this->hasMany(EventStage::class, 'event_venue_id');
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopePhysical($query)
    {
        return $query->where('venue_type', 'physical');
    }

    public function scopeVirtual($query)
    {
        return $query->where('venue_type', 'virtual');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getFullAddressAttribute(): ?string
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->country,
        ]);

        return $parts ? implode(', ', $parts) : null;
    }
}
