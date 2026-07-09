<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudienceType extends Model
{
    protected $fillable = ['slug', 'label'];
}
