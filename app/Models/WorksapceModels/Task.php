<?php

namespace App\Models\WorksapceModels;

use App\Models\OrganizationMember;
use App\Policies\WorkspaceTaskPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UsePolicy(WorkspaceTaskPolicy::class)]
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'workspace_id',
        'organization_member_id',
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function organizationMember()
    {
        return $this->belongsTo(OrganizationMember::class, 'organization_member_id');
    }
}
