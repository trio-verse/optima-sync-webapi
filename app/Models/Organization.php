<?php

namespace App\Models;

use App\Policies\OrganizationPolicy;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;

#[UsePolicy(OrganizationPolicy::class)]
class Organization extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'email',
        'phone',
        'description',
        'address',
        'logo',
    ];

    // relations
    public function user() {
        return $this->belongsTo(User::class);
    }
}
