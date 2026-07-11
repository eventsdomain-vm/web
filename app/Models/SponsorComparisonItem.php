<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorComparisonItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'comparison_id',
        'event_id',
    ];

    public function comparison(): BelongsTo
    {
        return $this->belongsTo(SponsorComparison::class, 'comparison_id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
