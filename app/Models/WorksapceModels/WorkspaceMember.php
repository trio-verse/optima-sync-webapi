<?php

namespace App\Models\WorksapceModels;

use App\Models\OrganizationMember;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['workspace_id', 'organization_member_id'])]
class WorkspaceMember extends Model
{
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function organizationMember(): BelongsTo
    {
        return $this->belongsTo(OrganizationMember::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'organization_member_id', 'organization_member_id')
            ->where('tasks.workspace_id', $this->workspace_id);
    }
}
