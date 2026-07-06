<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsorBrand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sponsor_id',
        'name',
        'slug',
        'tagline',
        'logo',
        'brand_colors',
        'brand_guidelines',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'brand_colors' => 'array',
            'brand_guidelines' => 'array',
            'is_primary' => 'boolean',
        ];
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(SponsorBrandAsset::class, 'brand_id');
    }
}
