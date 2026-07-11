<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorApprovalResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_request_id',
        'step_id',
        'user_id',
        'decision',
        'comment',
    ];

    public function approvalRequest(): BelongsTo
    {
        return $this->belongsTo(SponsorApprovalRequest::class, 'approval_request_id');
    }

    public function step(): BelongsTo
    {
        return $this->belongsTo(SponsorApprovalStep::class, 'step_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
