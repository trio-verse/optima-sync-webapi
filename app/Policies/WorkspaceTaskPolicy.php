<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorksapceModels\Task;
use App\Models\WorksapceModels\Workspace;
use App\Singleton\TenantManager;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

class WorkspaceTaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task, Workspace $workspace): bool
    {
        return $workspace->id == $task->workspace_id &&
         ($this->isOwner($user) ||
          $this->isAdministrator($user) ||
            $workspace->workspaceMembers()->where('member_id', $user->id)->exists());
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task, Workspace $workspace): bool
    {
        return $workspace->id == $task->workspace_id &&
         ($this->isOwner($user) ||
          $this->isAdministrator($user) ||
            $workspace->workspaceMembers()->where('member_id', $user->id)->exists());
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
