<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoAudit extends Model
{
    use HasFactory;

    protected $table = 'seo_audits';

    protected $fillable = [
        'auditable_type',
        'auditable_id',
        'url',
        'results',
        'score',
        'critical_issues',
        'warnings',
        'notices',
        'issues',
        'completed_at',
    ];

    protected $casts = [
        'results' => 'array',
        'issues' => 'array',
        'score' => 'integer',
        'critical_issues' => 'integer',
        'warnings' => 'integer',
        'notices' => 'integer',
        'completed_at' => 'datetime',
    ];

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }
}
