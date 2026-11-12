<?php

namespace App\Services\Workspace;

use App\Models\WorksapceModels\Workspace;
use App\Models\WorksapceModels\WorkspaceMember;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class WorkspaceMemberService
{
    public function getAllMembers(Workspace $workspace): Collection
    {
        // used pluck to get only the member models from the workspaceMembers relationship
        return $workspace->workspaceMembers()
            ->with('member')
            ->latest()
            ->get()
            ->pluck('member');
    }

    public function addMember(Workspace $workspace, int $memberId): WorkspaceMember
    {
        return $workspace->workspaceMembers()->create([
            'member_id' => $memberId,
        ])->load('member');
        // after creating the workspace member, we load the member relationship to return the full member model
    }

    public function delete(Workspace $workspace, WorkspaceMember $workspaceMember): void
    {
        // using this exception error and procces it from here to return a 404 error if the workspace member does not belong to the workspace
        // the error message will be like "Workspace member not found in this workspace."
        if ($workspaceMember->workspace_id !== $workspace->id) {
            throw (new ModelNotFoundException('Workspace member not found in this workspace.'))->setModel(WorkspaceMember::class, [$workspaceMember->id]);
        }

        $workspaceMember->deleteOrFail();
    }
}
