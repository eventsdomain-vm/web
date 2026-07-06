<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorshipBenefit extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'benefit_text',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function package(): BelongsTo
    {
        return $this->belongsTo(SponsorshipPackage::class, 'package_id');
    }
}
