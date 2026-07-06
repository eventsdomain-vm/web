<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorTeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'user_id',
        'role',
        'team_id',
    ];

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(SponsorTeam::class, 'team_id');
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Admin',
            'editor' => 'Editor',
            'viewer' => 'Viewer',
            'approver' => 'Approver',
            'finance' => 'Finance',
            default => ucfirst($this->role),
        };
    }
}
