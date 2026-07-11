<?php

declare(strict_types=1);

namespace App\Traits;

trait HasStatusLabel
{
    /**
     * Get a human-readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending Review',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'published' => 'Published',
            'draft' => 'Draft',
            'archived' => 'Archived',
            'active' => 'Active',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get a Tailwind CSS color class for the status.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            'published' => 'green',
            'draft' => 'gray',
            'archived' => 'gray',
            'active' => 'blue',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get a Bootstrap-style badge class for the status.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'published' => 'bg-green-100 text-green-800',
            'draft' => 'bg-gray-100 text-gray-800',
            'archived' => 'bg-gray-100 text-gray-800',
            'active' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
