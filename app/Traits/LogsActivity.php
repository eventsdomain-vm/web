<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait LogsActivity
{
    protected function logActivity(
        string $action,
        ?string $description = null,
        ?Model $subject = null,
        ?array $properties = null,
        ?Request $request = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->id,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => $request?->ip() ?? request()->ip(),
        ]);
    }
}
