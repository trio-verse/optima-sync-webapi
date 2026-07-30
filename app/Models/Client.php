<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'organization_id',
        'name',
        'email',
        'phone',
        'address',
        'phone',
        'email',
        'whatsapp',
        'website',
        'city_id',
        'industry_id',
        'type',
        'notes'
    ];
}
