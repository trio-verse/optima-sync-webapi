<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use App\Policies\OrganizationPolicy;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

#[UsePolicy(OrganizationPolicy::class)]
class Organization extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
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
