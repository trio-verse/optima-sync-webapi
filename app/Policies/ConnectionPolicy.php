<?php

namespace App\Policies;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

#[UsePolicy(ConnectionPolicy::class)]
class ConnectionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, int $organization_id): bool
    {
        $org = $user->organizations()->find($organization_id);
        return $org !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Connection $connection): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, int $client_id): bool
    {

        $connection = Connection::where('client_id', $client_id)->first();
        return $user->organizations()->where('id', $connection->client->organization_id)->exists();

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Connection $connection): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Connection $connection): bool
    {
        return false;
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
