<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\Content;
use App\Models\User;
use App\Singleton\TenantManager;
use Illuminate\Auth\Access\Response;

class ContentPolicy
{

    private int|null $organizationId = null;

    public function __construct()
    {
        $this->organizationId = app(TenantManager::class)->getOrganizationId();
    }
    private function userBelongsToOrganization(User $user): bool
    {
        return $user->createdOrganizations()->where('organizations.id', $this->organizationId)->exists()
            || $user->organizations()->where('organizations.id', $this->organizationId)->exists();
    }
    private function userIsAdmin(User $user): bool
    {
        return $user->createdOrganizations()->where('organizations.id', $this->organizationId)->exists();
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Campaign $campaign): bool
    {
        return ($this->userBelongsToOrganization($user))
            && $campaign->organization_id === $this->organizationId;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Campaign $campaign, Content $content): bool
    {
        return ($this->userBelongsToOrganization($user))
            && $campaign->id === $content->campaign_id
            && $content->organization_id === $this->organizationId;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return ($this->userBelongsToOrganization($user));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Content $content): bool
    {
        return $user->is_admin
            || $content->assigned_by === $user->id
            || $user->createdOrganizations->contains(
                app(TenantManager::class)->getOrganizationId()
            );
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Content $content): Response
    {
        return ($this->userIsAdmin($user)
            && $content->organization_id === $this->organizationId) ?
            Response::allow() : Response::deny('You do not have permission to delete this content.');
    }

    public function set_cost(User $user, Content $content): Response
    {
        return ($this->userIsAdmin($user)
            && $content->organization_id === $this->organizationId) ?
            Response::allow() : Response::deny('You do not have permission to set cost for this content.');
    }
    public function approve_content(User $user, Content $content): Response
    {
        return ($this->userIsAdmin($user)
            && $content->organization_id === $this->organizationId) ?
            Response::allow() : Response::deny('You do not have permission to approve this content.');
    }
}
