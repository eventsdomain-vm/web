<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorTaskAssignee extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(SponsorTask::class, 'task_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
