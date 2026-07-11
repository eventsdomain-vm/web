<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SponsorApprovalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'workflow_id',
        'approvable_type',
        'approvable_id',
        'requested_by',
        'status',
        'notes',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'resolved_at' => 'timestamp',
        ];
    }

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(SponsorApprovalWorkflow::class, 'workflow_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvable(): MorphTo
    {
        return $this->morphTo();
    }

    public function responses(): HasMany
    {
        return $this->hasMany(SponsorApprovalResponse::class, 'approval_request_id');
    }
}
