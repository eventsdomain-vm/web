<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventDraft extends Model
{
    protected $fillable = [
        'user_id',
        'current_step',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
        'current_step' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
