<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorIntegrationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'integration_id',
        'event',
        'details',
        'status',
        'records_processed',
    ];

    public function integration(): BelongsTo
    {
        return $this->belongsTo(SponsorIntegration::class, 'integration_id');
    }
}
