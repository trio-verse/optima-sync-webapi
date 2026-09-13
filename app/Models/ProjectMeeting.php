<?php

namespace App\Models;

use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectMeeting extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $fillable = [
        'organization_id',
        'project_id',
        'title',
        'meeting_date',
        'meeting_url',
        'description',
        'stakeholders',
        'team_members',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'meeting_date' => 'datetime',
            'stakeholders' => 'array',
            'team_members' => 'array',
        ];
    }

    /**
     * Relationships
     */

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
