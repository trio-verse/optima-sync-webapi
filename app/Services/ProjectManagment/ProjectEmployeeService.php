<?php

namespace App\Services\ProjectManagment;

use App\Events\ProjectEmployeeAssigned;
use App\Events\ProjectEmployeePointsUpdated;
use App\Events\ProjectEmployeeRemoved;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProjectEmployeeService
{
    /**
     * Get all employees assigned to a project.
     */
    public function getProjectEmployees(Project $project): Collection
    {
        return $project->employees;
    }

    /**
     * Attach an employee to a project with points.
     */
    public function attachEmployee(Project $project, int $employeeId, int $totalPoints): Employee
    {
        $employee = Employee::findOrFail($employeeId);

        DB::transaction(function () use ($project, $employee, $totalPoints) {
            $project->employees()->syncWithoutDetaching([
                $employee->id => [
                    'organization_id' => $project->organization_id,
                    'total_points' => $totalPoints,
                ]
            ]);

            DB::afterCommit(fn () => ProjectEmployeeAssigned::dispatch($project, $employee));
        });

        return $project->employees()->where('employee_id', $employee->id)->first();
    }

    /**
     * Get a specific employee attached to a project.
     */
    public function getProjectEmployee(Project $project, int $employeeId): ?Employee
    {
        return $project->employees()->where('employee_id', $employeeId)->first();
    }

    /**
     * Update employee points on a project.
     */
    public function updateEmployeePoints(Project $project, Employee $employee, int $totalPoints): Employee
    {
        if (!$project->employees()->where('employee_id', $employee->id)->exists()) {
            throw new \DomainException('Employee is not assigned to this project.');
        }

        DB::transaction(function () use ($project, $employee, $totalPoints) {
            $project->employees()->updateExistingPivot($employee->id, [
                'total_points' => $totalPoints,
            ]);

            DB::afterCommit(fn () => ProjectEmployeePointsUpdated::dispatch($project, $employee));
        });

        return $project->employees()->where('employee_id', $employee->id)->first();
    }

    /**
     * Detach an employee from a project.
     */
    public function detachEmployee(Project $project, Employee $employee): bool
    {
        if (!$project->employees()->where('employee_id', $employee->id)->exists()) {
            throw new \DomainException('Employee is not assigned to this project.');
        }

        $detached = DB::transaction(function () use ($project, $employee) {
            $detached = (bool) $project->employees()->detach($employee->id);

            if ($detached) {
                DB::afterCommit(fn () => ProjectEmployeeRemoved::dispatch($project, $employee));
            }

            return $detached;
        });

        return $detached;
    }

    /**
     * Calculate points & financial summary for all employees in a project.
     */
    public function calculatePointsSummary(Project $project): array
    {
        $employees = $project->employees;

        $employeeDetails = $employees->map(function ($employee) {
            $points = (int) ($employee->pivot->total_points ?? 0);
            $hoursPerPoint = (int) ($employee->houres_per_point ?? 2);
            $costPerHour = (float) $employee->cost_per_hour;
            $calculatedHours = $points * $hoursPerPoint;
            $calculatedCost = $calculatedHours * $costPerHour;

            return [
                'employee_id' => $employee->id,
                'employee_name' => $employee->name,
                'position' => $employee->position,
                'total_points' => $points,
                'hours_per_point' => $hoursPerPoint,
                'calculated_hours' => $calculatedHours,
                'cost_per_hour' => $costPerHour,
                'calculated_cost' => number_format($calculatedCost, 2, '.', ''),
            ];
        });

        $totalPoints = $employees->sum(fn ($emp) => (int) $emp->pivot->total_points);
        $totalCost = $employeeDetails->sum(fn ($item) => (float) $item['calculated_cost']);

        return [
            'project_id' => $project->id,
            'total_employees' => $employees->count(),
            'total_points' => $totalPoints,
            'total_cost' => number_format($totalCost, 2, '.', ''),
            'employees' => $employeeDetails->toArray(),
        ];
    }
}
