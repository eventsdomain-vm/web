<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsorIntegration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sponsor_id',
        'provider',
        'name',
        'type',
        'config',
        'credentials',
        'status',
        'last_synced_at',
        'last_error',
    ];

    protected function casts(): array
    {
        return [
            'config' => 'array',
            'credentials' => 'array',
            'last_synced_at' => 'timestamp',
        ];
    }

    protected $hidden = [
        'credentials',
    ];

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(SponsorIntegrationLog::class, 'integration_id');
    }

    public function isConnected(): bool
    {
        return $this->status === 'connected';
    }

    public function markError(string $error): void
    {
        $this->update(['status' => 'error', 'last_error' => $error]);
    }
}
