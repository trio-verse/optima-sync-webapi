<?php

namespace App\Http\Controllers\Api\V1\ProjectManagment;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCost\StoreProjectCostRequest;
use App\Http\Requests\ProjectCost\UpdateProjectCostRequest;
use App\Http\Resources\V1\ProjectManagment\ProjectCostResource;
use App\Models\Project;
use App\Models\ProjectCost;
use App\Services\ProjectManagment\ProjectCostService;
use Illuminate\Http\JsonResponse;

/**
 * @group Project Costs
 *
 * APIs for managing project costs
 */
class ProjectCostController extends Controller
{
    public function __construct(
        protected ProjectCostService $service
    ) {
    }

    /**
     * Index project costs
     */
    public function index(Project $project): JsonResponse
    {
        try {
            $costs = $this->service->getProjectCosts($project);

            return ApiResponse::success(
                ProjectCostResource::collection($costs),
                'Project costs retrieved successfully'
            );
        } catch (\Throwable $th) {
            return ApiResponse::error(null, $th->getMessage(), 500);
        }
    }

    /**
     * Store project cost
     */
    public function store(StoreProjectCostRequest $request, Project $project): JsonResponse
    {
        try {
            $cost = $this->service->createCost($project, $request->validated());

            return ApiResponse::success(
                new ProjectCostResource($cost),
                'Project cost created successfully',
                201
            );
        } catch (\DomainException $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        } catch (\Throwable $th) {
            return ApiResponse::error(null, 'Failed to create project cost: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Show project cost
     */
    public function show(Project $project, ProjectCost $cost): JsonResponse
    {
        try {
            $costModel = $this->service->getCost($project, $cost);

            return ApiResponse::success(
                new ProjectCostResource($costModel),
                'Project cost retrieved successfully'
            );
        } catch (\DomainException $e) {
            return ApiResponse::notFound($e->getMessage());
        } catch (\Throwable $th) {
            return ApiResponse::error(null, $th->getMessage(), 500);
        }
    }

    /**
     * Update project cost
     */
    public function update(UpdateProjectCostRequest $request, Project $project, ProjectCost $cost): JsonResponse
    {
        try {
            $updatedCost = $this->service->updateCost($project, $cost, $request->validated());

            return ApiResponse::success(
                new ProjectCostResource($updatedCost),
                'Project cost updated successfully'
            );
        } catch (\DomainException $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        } catch (\Throwable $th) {
            return ApiResponse::error(null, 'Failed to update project cost: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Delete project cost
     */
    public function destroy(Project $project, ProjectCost $cost): JsonResponse
    {
        try {
            $this->service->deleteCost($project, $cost);

            return ApiResponse::success([
                'id' => $cost->id,
                'project_id' => $project->id,
                'deleted' => true,
            ], 'Project cost deleted successfully');
        } catch (\DomainException $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        } catch (\Throwable $th) {
            return ApiResponse::error(null, 'Failed to delete project cost: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Calculate total budget for project costs
     */
    public function totalBudget(Project $project): JsonResponse
    {
        try {
            $budgetSummary = $this->service->calculateTotalBudget($project);

            return ApiResponse::success(
                $budgetSummary,
                'Total budget for project costs calculated successfully'
            );
        } catch (\Throwable $th) {
            return ApiResponse::error(null, $th->getMessage(), 500);
        }
    }
}
