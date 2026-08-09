<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Connection;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

#[UsePolicy(ConnectionPolicy::class)]
class ConnectionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // $org = $user->organizations()->find($organization_id);
        // return $org !== null;
        return Organization::forUser($user)->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return Organization::forUser($user)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, int $client_id): bool
    {
        // return Organization::forUser($user)->exists();
        return Organization::forUser($user)->clients()->find($client_id)->exists();

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        // return $user->organizations()->where('id', $connection->client->organization_id)->exists();
        return Organization::forUser($user)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Connection $connection): bool
    {
        // return $user->organizations()->where('id', $connection->client->organization_id)->exists();
        return Organization::forUser($user)->clients()->find($connection->client_id)->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Connection $connection): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Connection $connection): bool
    {
        return false;
    }
}
