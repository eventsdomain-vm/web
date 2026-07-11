<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgeGroup extends Model
{
    protected $fillable = ['slug', 'label', 'sort_order'];

    protected $casts = [
        'sort_order' => 'integer',
    ];
}
