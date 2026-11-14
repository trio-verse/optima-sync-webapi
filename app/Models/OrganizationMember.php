<?php

namespace App\Models;

use App\Models\WorksapceModels\Task;
use App\Models\WorksapceModels\Workspace;
use App\Models\WorksapceModels\WorkspaceMember;
use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['organization_id', 'user_id', 'role'])]
class OrganizationMember extends Model
{
    use BelongsToOrganization;

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workspaceMemberships(): HasMany
    {
        return $this->hasMany(WorkspaceMember::class);
    }

    public function workspaces(): BelongsToMany
    {
        return $this->belongsToMany(
            Workspace::class,
            'workspace_members',
            'organization_member_id',
            'workspace_id'
        );
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'organization_member_id');
    }
}
