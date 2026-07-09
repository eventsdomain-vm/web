<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartnerEnquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'company_name',
        'partnership_type',
        'partnership_type_label',
        'message',
    ];
}
