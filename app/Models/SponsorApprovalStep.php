<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorApprovalStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'workflow_id',
        'approver_id',
        'step_order',
        'action',
    ];

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(SponsorApprovalWorkflow::class, 'workflow_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
