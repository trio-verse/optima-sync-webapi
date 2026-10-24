<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use App\Singleton\TenantManager;
use Illuminate\Support\Facades\DB;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->belongsToActiveOrganization($user);
    }

    public function view(User $user, Project $project): bool
    {
        return $this->belongsToActiveOrganization($user)
            && $this->ownsActiveOrganization($project);
    }

    public function create(User $user): bool
    {
        return  $this->belongsToActiveOrganization($user);
    }

    public function update(User $user, Project $project): bool
    {
        return $this->belongsToActiveOrganization($user) && $this->ownsActiveOrganization($project);
    }

    public function delete(User $user, Project $project): bool
    {
        return $this->belongsToActiveOrganization($user) && $this->ownsActiveOrganization($project);
    }

    public function manageFinancials(User $user, Project $project): bool
    {
        return $this->belongsToActiveOrganization($user) && $this->ownsActiveOrganization($project);
    }

    public function manageVersions(User $user, Project $project): bool
    {
        return $this->belongsToActiveOrganization($user) && $this->ownsActiveOrganization($project);
    }


    private function ownsActiveOrganization(Project $project): bool
    {
        return $project->organization_id === app(TenantManager::class)->getOrganizationId();
    }

    private function belongsToActiveOrganization(User $user): bool
    {
        $organizationId = app(TenantManager::class)->getOrganizationId();

        return $organizationId !== null
            && ($this->isOwner($user) || DB::table('organization_members')
                ->where('organization_id', $organizationId)
                ->where('user_id', $user->id)
                ->exists());
    }

    private function isOwner(User $user): bool
    {
        $organizationId = app(TenantManager::class)->getOrganizationId();

        return $organizationId !== null
            && DB::table('organizations')
                ->where('id', $organizationId)
                ->where('user_id', $user->id)
                ->exists();
    }

    private function isAdministrator(User $user): bool
    {
        $organizationId = app(TenantManager::class)->getOrganizationId();

        return $this->isOwner($user)
            || ($organizationId !== null && DB::table('organization_members')
                ->where('organization_id', $organizationId)
                ->where('user_id', $user->id)
                ->whereIn('role', ['admin'])
                ->exists());
    }
}
