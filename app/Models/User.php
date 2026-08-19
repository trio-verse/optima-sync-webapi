<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'phone', 'email_verified_at'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that should be appended to arrays.
     *
     * @var array
     */
    protected $appends = ['is_admin', 'is_member'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    // Attributes
    public function isAdmin(): Attribute
    {
        return new Attribute(
            get: fn() => $this->pivot?->role === 'admin' || false
        );
    }
    public function isMember(): Attribute
    {
        return new Attribute(
            get: fn() => $this->pivot?->role === "member" || false
        );
    }
    // Relations
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_members')
            ->withPivot('role');
    }

    public function createdOrganizations()
    {
        return $this->hasMany(Organization::class, 'user_id');
    }


    /**
     * get all clients that assigned to this user
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough<Client, Connection, User>
     */
    public function clients()
    {
        return $this->hasManyThrough(Client::class, Connection::class, 'assignee_id', 'id', 'id', 'client_id');
    }
    /**
     * get all connections that assigned to this user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Connection, User>
     */
    public function connections()
    {
        return $this->hasMany(Connection::class, 'assignee_id', 'id');
    }


}
