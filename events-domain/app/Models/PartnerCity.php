<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerCity extends Model
{
    protected $table = 'partner_city';

    protected $fillable = ['partner_id', 'city'];

    public $timestamps = false;

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }
}
