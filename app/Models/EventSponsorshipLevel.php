<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventSponsorshipLevel extends Model
{
    protected $fillable = ['event_id', 'level'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
