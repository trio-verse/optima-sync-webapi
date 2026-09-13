<?php

namespace App\Http\Controllers\Api\V1\ProjectManagment;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\Employee\StoreProjectEmployeeRequest;
use App\Http\Requests\Project\Employee\UpdateProjectEmployeeRequest;
use App\Http\Resources\V1\ProjectManagment\ProjectEmployeeResource;
use App\Models\Employee;
use App\Models\Project;
use App\Services\ProjectManagment\ProjectEmployeeService;
use Illuminate\Http\JsonResponse;

/**
 * @group  Project employees
 */
class ProjectEmployeesController extends Controller
{
    public function __construct(
        protected ProjectEmployeeService $service
    ) {
    }

    /**
     * List employees.
     * attached to a project with points & calculations
     */
    public function index(Project $project): JsonResponse
    {
        $employees = $this->service->getProjectEmployees($project);

        return ApiResponse::success(
            ProjectEmployeeResource::collection($employees),
            'Project employees retrieved successfully'
        );
    }

    /**
     * store.
     * Attach an employee to a project with total_points
     */
    public function store(StoreProjectEmployeeRequest $request, Project $project): JsonResponse
    {
        $validated = $request->validated();
        $attachedEmployee = $this->service->attachEmployee(
            $project,
            (int) $validated['employee_id'],
            (int) $validated['total_points']
        );

        return ApiResponse::success(
            new ProjectEmployeeResource($attachedEmployee),
            'Employee attached to project successfully',
            201
        );
    }

    /**
     * Show a specific employee attached to a project
     */
    public function show(Project $project, Employee $employee): JsonResponse
    {
        $attachedEmployee = $this->service->getProjectEmployee($project, $employee->id);

        if (!$attachedEmployee) {
            return ApiResponse::notFound('Employee is not assigned to this project');
        }

        return ApiResponse::success(
            new ProjectEmployeeResource($attachedEmployee),
            'Project employee details retrieved successfully'
        );
    }

    /**
     * Update employee points on a project
     */
    public function update(UpdateProjectEmployeeRequest $request, Project $project, Employee $employee): JsonResponse
    {
        try {
            $validated = $request->validated();
            $updatedEmployee = $this->service->updateEmployeePoints(
                $project,
                $employee,
                (int) $validated['total_points']
            );

            return ApiResponse::success(
                new ProjectEmployeeResource($updatedEmployee),
                'Project employee points updated successfully'
            );
        } catch (\DomainException $e) {
            return ApiResponse::notFound($e->getMessage());
        }
    }

    /**
     * destroy.
     * Detach an employee from a project
     */
    public function destroy(Project $project, Employee $employee): JsonResponse
    {
        try {
            $this->service->detachEmployee($project, $employee);

            return ApiResponse::success([
                'project_id' => $project->id,
                'employee_id' => $employee->id,
                'detached' => true,
            ], 'Employee removed from project successfully');
        } catch (\DomainException $e) {
            return ApiResponse::notFound($e->getMessage());
        }
    }

    /**
     * pointsSummary.
     * Calculate points & cost summary for all employees in a project
     */
    public function pointsSummary(Project $project): JsonResponse
    {
        $summary = $this->service->calculatePointsSummary($project);

        return ApiResponse::success(
            $summary,
            'Project employee points summary calculated successfully'
        );
    }
}
