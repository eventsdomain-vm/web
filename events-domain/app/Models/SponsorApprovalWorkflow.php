<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SponsorApprovalWorkflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'name',
        'entity_type',
        'description',
        'is_active',
        'steps_required',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(SponsorApprovalStep::class, 'workflow_id');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(SponsorApprovalRequest::class, 'workflow_id');
    }
}
