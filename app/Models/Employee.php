<?php

namespace App\Models;

use App\Trait\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $fillable = [
        'organization_id',
        'name',
        'email',
        'phone',
        'position',
        'cost_per_hour',
        'houres_per_point',
    ];

    protected $casts = [
        'cost_per_hour' => 'decimal:2',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_employees', 'employee_id', 'project_id')
            ->withTimestamps()
            ->withPivot('total_points', 'organization_id');
    }

    /**
     * Calculate financial cost for a given number of points for this employee.
     */
    public function calculateCostForPoints(int $points): float
    {
        $hoursPerPoint = (int) ($this->houres_per_point ?? 2);
        return $points * $hoursPerPoint * (float) $this->cost_per_hour;
    }
}
