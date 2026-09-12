<?php

namespace App\Http\Controllers\Api\V1\ProjectManagment;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectFeature\ChangeProjectFeatureStatusRequest;
use App\Http\Requests\ProjectFeature\StoreProjectFeatureRequest;
use App\Http\Requests\ProjectFeature\UpdateProjectFeatureRequest;
use App\Http\Resources\V1\ProjectManagment\ProjectFeatureResource;
use App\Models\Project;
use App\Models\ProjectFeature;
use App\Services\ProjectManagment\ProjectFeatureService;
use Illuminate\Http\JsonResponse;

/**
 * @group Project Features
 *
 * APIs for managing project features
 */
class ProjectFeatureController extends Controller
{
    public function __construct(
        protected ProjectFeatureService $service
    ) {
    }

    /**
     * Index project features
     */
    public function index(Project $project): JsonResponse
    {
        try {
            $features = $this->service->getProjectFeatures($project);

            return ApiResponse::success(
                ProjectFeatureResource::collection($features),
                'Project features retrieved successfully'
            );
        } catch (\Throwable $th) {
            return ApiResponse::error(null, $th->getMessage(), 500);
        }
    }

    /**
     * Store feature
     */
    public function store(StoreProjectFeatureRequest $request, Project $project): JsonResponse
    {
        try {
            $feature = $this->service->createFeature($project, $request->validated());

            return ApiResponse::success(
                new ProjectFeatureResource($feature),
                'Project feature created successfully',
                201
            );
        } catch (\DomainException $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        } catch (\Throwable $th) {
            return ApiResponse::error(null, 'Failed to create feature: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Show feature
     */
    public function show(Project $project, ProjectFeature $feature): JsonResponse
    {
        try {
            $featureModel = $this->service->getFeature($project, $feature);

            return ApiResponse::success(
                new ProjectFeatureResource($featureModel),
                'Project feature retrieved successfully'
            );
        } catch (\DomainException $e) {
            return ApiResponse::notFound($e->getMessage());
        } catch (\Throwable $th) {
            return ApiResponse::error(null, $th->getMessage(), 500);
        }
    }

    /**
     * Update feature
     */
    public function update(UpdateProjectFeatureRequest $request, Project $project, ProjectFeature $feature): JsonResponse
    {
        try {
            $updated = $this->service->updateFeature($project, $feature, $request->validated());

            return ApiResponse::success(
                new ProjectFeatureResource($updated),
                'Project feature updated successfully'
            );
        } catch (\DomainException $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        } catch (\Throwable $th) {
            return ApiResponse::error(null, 'Failed to update feature: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Delete feature
     */
    public function destroy(Project $project, ProjectFeature $feature): JsonResponse
    {
        try {
            $this->service->deleteFeature($project, $feature);

            return ApiResponse::success([], 'Project feature deleted successfully');
        } catch (\DomainException $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        } catch (\Throwable $th) {
            return ApiResponse::error(null, 'Failed to delete feature: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Change feature status
     */
    public function changeStatus(ChangeProjectFeatureStatusRequest $request, Project $project, ProjectFeature $feature): JsonResponse
    {
        try {
            $updated = $this->service->changeStatus(
                $project,
                $feature,
                $request->validated('status')
            );

            return ApiResponse::success(
                new ProjectFeatureResource($updated),
                'Project feature status updated successfully'
            );
        } catch (\DomainException $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        } catch (\Throwable $th) {
            return ApiResponse::error(null, 'Failed to update feature status: ' . $th->getMessage(), 500);
        }
    }
}
