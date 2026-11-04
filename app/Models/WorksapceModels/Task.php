<?php

namespace App\Models\WorksapceModels;

use App\Models\User;
use App\Models\WorksapceModels\Workspace;
use App\Policies\WorkspaceTaskPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

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
        'assignee_id',
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
}
