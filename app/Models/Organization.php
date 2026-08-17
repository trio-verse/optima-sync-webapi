<?php

namespace App\Models;
use App\Policies\OrganizationPolicy;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[UsePolicy(OrganizationPolicy::class)]
class Organization extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'description',
        'address',
        'user_id',

    ];
    protected $with = [
        'logo'
    ];

    // relations
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function members()
    {
        return $this->hasMany(OrganizationMember::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'organization_id');
    }

    /**
     * Scope: orgs where the given user is an owner or member/admin.
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->orWhereHas('members', function ($q2) use ($user) {
                    $q2->where('user_id', $user->id);
                });
        });
    }

    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
    public function logo(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('file_type', 'logo');
    }
}
