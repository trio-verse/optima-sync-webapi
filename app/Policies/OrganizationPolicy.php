<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrganizationPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Organization $organization): Response
    {
        return $user->id === $organization->user_id? Response::allow()
        : Response::deny('You do not own this post.');
    }


    public function addMember(User $user, Organization $organization): Response
    {
        return $user->id === $organization->user_id? Response::allow()
        : Response::deny('You do not own this organization');
    }
    public function updateMemberRole(User $user, Organization $organization): Response
    {
        return $user->id === $organization->user_id? Response::allow()
        : Response::deny('You do not own this organization');
    }
}
