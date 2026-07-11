<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsorBrandAsset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand_id',
        'campaign_id',
        'name',
        'type',
        'file_path',
        'mime_type',
        'file_size',
        'thumbnail_path',
        'tags',
        'is_approved',
        'approved_at',
        'approved_by',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'approved_at' => 'timestamp',
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(SponsorBrand::class, 'brand_id');
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(SponsorCampaign::class, 'campaign_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(SponsorAssetVersion::class, 'asset_id');
    }
}
