<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
