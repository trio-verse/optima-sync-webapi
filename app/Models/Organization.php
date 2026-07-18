<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
class Organization extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'description',
        'address',
    ];
}
