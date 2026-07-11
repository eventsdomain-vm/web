<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerCity extends Model
{
    protected $fillable = ['partner_id', 'city'];
    public $timestamps = false;
}
