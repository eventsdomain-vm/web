<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'price',
        'image_limit',
        'analytics_level',
        'featured_badge',
        'priority_listing',
        'social_promotion',
        'homepage_featured',
        'listing_duration_days',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'image_limit' => 'integer',
        'featured_badge' => 'boolean',
        'priority_listing' => 'boolean',
        'social_promotion' => 'boolean',
        'homepage_featured' => 'boolean',
        'listing_duration_days' => 'integer',
    ];
}
