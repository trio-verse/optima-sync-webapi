<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable('worspace_id', 'assignee_id')]
class WorkspaceMember extends Model
{

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
