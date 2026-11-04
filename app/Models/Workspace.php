<?php

namespace App\Models;

use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'deadline', 'status'])]
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

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'workspace_members')
    //         ->withPivot('role');
    // }

    // public function workspaceMembers()
    // {
    //     return $this->hasMany(WorkspaceMember::class);
    // }
}
