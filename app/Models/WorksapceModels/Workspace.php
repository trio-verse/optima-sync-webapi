<?php

namespace App\Models\WorksapceModels;

use App\Models\OrganizationMember;
use App\Policies\WorkspacePolicy;
use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'deadline', 'status'])]
#[UsePolicy(WorkspacePolicy::class)]
class Workspace extends Model
{
    use BelongsToOrganization;

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
        ];
    }

    // Relations
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    // Many-to-many relationship with organization members through the workspace membership table.
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(
            OrganizationMember::class,
            'workspace_members',
            'workspace_id',
            'organization_member_id'
        );
    }

    public function workspaceMembers()
    {
        return $this->hasMany(WorkspaceMember::class);
    }
}
