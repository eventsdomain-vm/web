<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_type',
        'company_name',
        'description',
        'website',
        'social_links',
        'location',
        'city',
        'state',
        'country',
        'gst_number',
        'gst_verified',
        'gst_verified_at',
        'gst_legal_name',
        'is_verified',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_verified' => 'boolean',
        'gst_verified' => 'boolean',
        'gst_verified_at' => 'datetime',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getFullLocationAttribute(): ?string
    {
        $parts = array_filter([$this->city, $this->state, $this->country]);

        return $parts ? implode(', ', $parts) : $this->location;
    }
}
