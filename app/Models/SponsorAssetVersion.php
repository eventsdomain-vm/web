<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorAssetVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'version_number',
        'file_path',
        'mime_type',
        'file_size',
        'change_notes',
        'uploaded_by',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(SponsorBrandAsset::class, 'asset_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
