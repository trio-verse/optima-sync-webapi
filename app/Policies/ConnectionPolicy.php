<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Connection;
use App\Models\User;

class ConnectionPolicy
{
    /**
     * Determine if the user belongs to the connection's organization.
     */
    private function userBelongsToConnectionOrganization(User $user, Connection $connection): bool
    {
        // Load necessary relationships
        $connection->loadMissing(['client.organization']);

        $organizationId = $connection->client->organization_id;

        // Check if user is the organization owner
        if ($connection->client->organization->user_id === $user->id) {
            return true;
        }

        // Check if user is a member of the organization
        return $user->organizations()->where('organizations.id', $organizationId)->exists();
    }

    /**
     * Determine if the user belongs to the client's organization.
     */
    private function userBelongsToClientOrganization(User $user, Client $client): bool
    {
        // Load the client's organization relationship
        $client->loadMissing('organization');

        // Check if user is the organization owner
        if ($client->organization->user_id === $user->id) {
            return true;
        }

        // Check if user is a member of the organization
        return $user->organizations()->where('organizations.id', $client->organization_id)->exists();
    }

    /**
     * Determine if the user has access to any organization.
     */
    private function userHasOrganizations(User $user): bool
    {
        // User owns organizations or is a member of organizations
        return $user->createdOrganizations()->exists()
            || $user->organizations()->exists();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->userHasOrganizations($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Connection $connection): bool
    {
        return $this->userBelongsToConnectionOrganization($user, $connection);
    }

    /**
     * Determine whether the user can create models for a specific client.
     */
    public function create(User $user, Client $client): bool
    {
        return $this->userBelongsToClientOrganization($user, $client);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Connection $connection): bool
    {
        return $this->userBelongsToConnectionOrganization($user, $connection);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Connection $connection): bool
    {
        // Load the organization relationship
        $connection->loadMissing(['client.organization']);

        // Only organization owner can delete connections
        return $connection->client->organization->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Connection $connection): bool
    {
        // Only organization owner can restore connections
        $connection->loadMissing(['client.organization']);
        return $connection->client->organization->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Connection $connection): bool
    {
        // Only organization owner can force delete connections
        $connection->loadMissing(['client.organization']);
        return $connection->client->organization->user_id === $user->id;
    }
}
