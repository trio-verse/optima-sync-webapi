<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Organization;
use App\Models\User;

class ClientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return Organization::forUser($user)->clients()->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Client $client): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return Organization::forUser($user)->clients()->where('clients.id', $client->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return Organization::forUser($user)->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Client $client): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return Organization::forUser($user)->clients()->where('clients.id', $client->id)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Client $client): bool
    {
        return $user->is_admin;
    }
}
