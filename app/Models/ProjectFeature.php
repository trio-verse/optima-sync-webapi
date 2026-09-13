<?php

namespace App\Models;

use App\Enums\enProjectFeatureStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'project_version_id',
        'name',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => enProjectFeatureStatus::class,
        ];
    }

    /**
     * Relationships
     */

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function projectVersion(): BelongsTo
    {
        return $this->belongsTo(ProjectVersion::class);
    }
}
