<?php

namespace App\Models;
use App\Policies\OrganizationPolicy;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
    ];

    // relations
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function members() {
        return $this->hasMany(OrganizationMember::class);
    }

    public function logo(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('file_type', 'logo');
    }
}
