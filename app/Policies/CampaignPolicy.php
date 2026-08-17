<?php

namespace App\Policies;

use App\Models\Campaign;
use App\Models\User;
use App\Singleton\TenantManager;
use Illuminate\Auth\Access\Response;

class CampaignPolicy
{
    private int|null $organizationId = null;

    private function userBelongsToOrganization(User $user): bool
    {
        return $user->createdOrganizations()->where('organizations.id', $this->organizationId)->exists()
            || $user->organizations()->where('organizations.id', $this->organizationId)->exists();
    }
    public function __construct()
    {
        $this->organizationId = app(TenantManager::class)->getOrganizationId();
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->userBelongsToOrganization($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Campaign $campaign): bool
    {
        return ($this->userBelongsToOrganization($user))
            && $campaign->organization_id === $this->organizationId;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->userBelongsToOrganization($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campaign $campaign): bool
    {
        return $this->userBelongsToOrganization($user)
            && $campaign->organization_id === $this->organizationId;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        return $this->userBelongsToOrganization($user)
            && $campaign->organization_id === $this->organizationId;
    }

}
