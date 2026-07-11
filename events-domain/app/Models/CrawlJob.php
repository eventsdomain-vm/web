<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrawlJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_url',
        'status',
        'response_code',
        'page_title',
        'meta_description',
        'headers_found',
        'links_found',
        'errors',
    ];

    protected $casts = [
        'response_code' => 'integer',
        'headers_found' => 'array',
        'links_found' => 'array',
        'errors' => 'array',
    ];

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'running' => 'Running',
            'completed' => 'Completed',
            'failed' => 'Failed',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'running' => 'blue',
            'completed' => 'green',
            'failed' => 'red',
            default => 'gray',
        };
    }

    public function getSuccessAttribute(): bool
    {
        return $this->status === 'completed' && in_array($this->response_code, [200, 301, 302]);
    }
}
