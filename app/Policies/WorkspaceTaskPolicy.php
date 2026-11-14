<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorksapceModels\Task;
use App\Models\WorksapceModels\Workspace;

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
     * Determine whether the user can store a task.
     */
    public function store(User $user, Workspace $workspace): bool
    {
        return
         $user->isOwnerOrAdmin() ||
            $workspace->workspaceMembers()
                ->whereHas('organizationMember', fn ($query) => $query->where('user_id', $user->id))
                ->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task, Workspace $workspace): bool
    {
        return $workspace->id == $task->workspace_id &&
         ($user->isOwnerOrAdmin() ||
            $workspace->workspaceMembers()
                ->whereHas('organizationMember', fn ($query) => $query->where('user_id', $user->id))
                ->exists());
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task, Workspace $workspace): bool
    {
        return $workspace->id == $task->workspace_id &&
         ($user->isOwnerOrAdmin() ||
            $workspace->workspaceMembers()
                ->whereHas('organizationMember', fn ($query) => $query->where('user_id', $user->id))
                ->exists());
    }
}
