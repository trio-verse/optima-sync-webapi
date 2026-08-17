<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrganizationPolicy
{

    public function view(User $user, int $orgId): Response
    {
        $organization = Organization::find($orgId);
        return $user->id === $organization->user_id ? Response::allow()
            : Response::denyAsNotFound('You do not own this Organization.');

    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Organization $organization): Response
    {
        return $user->id === $organization->user_id ? Response::allow()
            : Response::deny('You do not own this Organization');
    }


    public function addMember(User $user, Organization $organization): Response
    {
        return $user->id === $organization->user_id ? Response::allow()
            : Response::deny('You do not own this organization');
    }
    public function updateMemberRole(User $user, Organization $organization): Response
    {
        return $user->id === $organization->user_id ? Response::allow()
            : Response::deny('You do not own this organization');
    }

    public function getMyOrganizations(User $user): Response
    {
        return $user
            ? Response::allow()
            : Response::deny('You are not authorized to perform this action.');
    }
}
