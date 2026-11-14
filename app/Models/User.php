<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\WorksapceModels\Task;
use App\Singleton\TenantManager;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'phone', 'email_verified_at'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that should be appended to arrays.
     *
     * @var array
     */
    protected $appends = ['is_admin', 'is_member', 'is_owner'];

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
            get: fn () => $this->pivot?->role === 'admin' || false
        );
    }

    public function isMember(): Attribute
    {
        return new Attribute(
            get: fn () => $this->pivot?->role === 'member' || false
        );
    }

    public function isOwner(): Attribute
    {
        return new Attribute(
            get: fn () => $this->organizations()->where('organizations.user_id', $this->id)->exists() || false
        );
    }

    public function isOwnerOrAdmin(?int $organizationId = null): bool
    {
        $organizationId ??= app(TenantManager::class)->getOrganizationId();

        if ($organizationId === null) {
            return false;
        }

        return Organization::query()
            ->whereKey($organizationId)
            ->where(function (Builder $query): void {
                $query
                    ->where('user_id', $this->id)
                    ->orWhereHas('members', function (Builder $query): void {
                        $query
                            ->where('user_id', $this->id)
                            ->where('role', 'admin');
                    });
            })
            ->exists();
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

    public function organizationMemberships()
    {
        return $this->hasMany(OrganizationMember::class);
    }

    public function tasks()
    {
        return $this->hasManyThrough(
            Task::class,
            OrganizationMember::class,
            'user_id',
            'organization_member_id',
            'id',
            'id'
        );
    }

    /**
     * get all clients that assigned to this user
     *
     * @return HasManyThrough<Client, Connection, User>
     */
    public function clients()
    {
        return $this->hasManyThrough(Client::class, Connection::class, 'assignee_id', 'id', 'id', 'client_id');
    }

    /**
     * get all connections that assigned to this user
     *
     * @return HasMany<Connection, User>
     */
    public function connections()
    {
        return $this->hasMany(Connection::class, 'assignee_id', 'id');
    }
}
