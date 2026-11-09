<?php

namespace App\Models\WorksapceModels;


use App\Models\User;
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

    // Many-to-Many relationship with User model through WorkspaceMember pivot table
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'workspace_members',
            'workspace_id',
            'member_id'
        );
    }

    public function workspaceMembers()
    {
        return $this->hasMany(WorkspaceMember::class);
    }
}
