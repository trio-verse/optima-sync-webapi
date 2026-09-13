<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProjectVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'based_on_version_id',
        'version_number',
        'title',
        'description',
        'change_description',
        'start_date',
        'end_date',
        'duration',
        'freeze',
        'features_snapshot',
        'costs_snapshot',
        'employees_snapshot',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'version_number' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
            'freeze' => 'boolean',
            'features_snapshot' => 'array',
            'costs_snapshot' => 'array',
            'employees_snapshot' => 'array',
        ];
    }

    protected $with = [
        'features',
        // 'costs',
        'project',
    ];

    /**
     * Relationships
     */

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function basedOnVersion(): BelongsTo
    {
        return $this->belongsTo(ProjectVersion::class, 'based_on_version_id');
    }

    // public function createdBy(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }

    public function features(): HasMany
    {
        return $this->hasMany(ProjectFeature::class);
    }

    public function costs(): HasMany
    {
        return $this->hasMany(ProjectCost::class);
    }

    public function quotation(): HasOne
    {
        return $this->hasOne(Quotation::class);
    }

    public function derivedVersions(): HasMany
    {
        return $this->hasMany(ProjectVersion::class, 'based_on_version_id');
    }

    /**
     * Helper Methods
     */

    public function isEditable(): bool
    {
        return !$this->freeze;
    }

    public function freezeVersion(): bool
    {
        $this->features_snapshot = $this->features->toArray();
        $this->costs_snapshot = $this->project->costs->toArray();
        $this->employees_snapshot = $this->project?->employees->map(function ($employee) {
            $points = (int) ($employee->pivot->total_points ?? 0);
            $hoursPerPoint = (int) ($employee->houres_per_point ?? 2);
            $costPerHour = (float) $employee->cost_per_hour;
            $calculatedHours = $points * $hoursPerPoint;
            $calculatedCost = $calculatedHours * $costPerHour;

            return [
                'employee_id' => $employee->id,
                'name' => $employee->name,
                'email' => $employee->email,
                'position' => $employee->position,
                'cost_per_hour' => $costPerHour,
                'houres_per_point' => $hoursPerPoint,
                'total_points' => $points,
                'calculated_hours' => $calculatedHours,
                'calculated_cost' => $calculatedCost,
            ];
        })->toArray() ?? [];
        $this->freeze = true;

        return $this->save();
    }

    public function createNewVersion(array $attributes = []): ProjectVersion
    {
        $newVersion = $this->replicate();
        $newVersion->based_on_version_id = $this->id;
        $newVersion->version_number = $this->project->versions()->max('version_number') + 1;
        $newVersion->freeze = false;
        $newVersion->features_snapshot = null;
        $newVersion->costs_snapshot = null;
        $newVersion->employees_snapshot = null;

        $newVersion->fill($attributes);
        $newVersion->save();

        return $newVersion;
    }
}
