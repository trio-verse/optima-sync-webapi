<?php

namespace App\Http\Controllers\Api\V1\ProjectManagment;


use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectVersion\StoreProjectVersionRequest;
use App\Http\Requests\ProjectVersion\UpdateProjectVersionRequest;
use App\Http\Resources\V1\ProjectManagment\ProjectVersionResource;
use App\Models\Project;
use App\Models\ProjectVersion;
use App\Services\ProjectManagment\ProjectVersionService;
use App\Support\FakePersistence\ProjectModuleFakeStore;
use Database\Factories\ProjectVersionFactory;
use Illuminate\Http\JsonResponse;
/**
 * @group Project Versions
 *
 * APIs for managing project versions (fake persistence — no DB yet)
 */
class ProjectVersionController extends Controller
{
    public function __construct(
        protected ProjectVersionService $service
    ) {
    }

    /**
     * index project versions
     * @param string $project
     * @return JsonResponse
     */
    /**
     * index project versions
     */
    public function index(Project $project): JsonResponse
    {
        $versions = $this->service->getProjectVersions($project, request()->all());

        return ApiResponse::success(
            ProjectVersionResource::collection($versions),
            'Project versions retrieved successfully'
        );
    }

    /**
     * store a new project version
     */
    public function store(StoreProjectVersionRequest $request, Project $project): JsonResponse
    {
        $validated = $request->validated();
        $version = $this->service->createVersion($project, $validated);

        return ApiResponse::success(new ProjectVersionResource($version), 'Project version created successfully', 201);
    }

    /**
     * show project version
     */
    public function show(Project $project, ProjectVersion $version): JsonResponse
    {
        if ($version->project_id !== $project->id) {
            return ApiResponse::notFound('Project version not found for this project');
        }

        $version->load(['features', 'costs', 'basedOnVersion', 'createdBy']);

        return ApiResponse::success(new ProjectVersionResource($version), 'Project version retrieved successfully');
    }

    /**
     * update project version
     *
     * Option 1 (freeze = false): Updates the active version directly.
     * Option 2 (freeze = true): Automatically branches a new version from the frozen version and updates it.
     */
    public function update(UpdateProjectVersionRequest $request, Project $project, ProjectVersion $version): JsonResponse
    {
        if ($version->project_id !== $project->id) {
            return ApiResponse::notFound('Project version not found for this project');
        }

        $wasFrozen = $version->freeze;
        $resultVersion = $this->service->updateVersion($project , $version, $request->validated());

        $statusCode = $wasFrozen ? 201 : 200;
        $message = $wasFrozen
            ? 'Frozen version branched into a new version successfully'
            : 'Project version updated successfully';

        return ApiResponse::success(new ProjectVersionResource($resultVersion), $message, $statusCode);
    }

    /**
     * delete project version
     */
    public function destroy(Project $project, ProjectVersion $version): JsonResponse
    {
        if ($version->project_id !== $project->id) {
            return ApiResponse::notFound('Project version not found for this project');
        }

        try {
            $this->service->deleteVersion($version);

            return ApiResponse::success([
                'id' => $version->id,
                'project_id' => $project->id,
                'deleted' => true,
            ], 'Project version deleted successfully');
        } catch (\Exception $e) {
            return ApiResponse::error(null, $e->getMessage(), 422);
        }
    }

    /**
     * freeze project version
     */
    public function freeze(Project $project, ProjectVersion $version): JsonResponse
    {
        if ($version->project_id !== $project->id) {
            return ApiResponse::notFound('Project version not found for this project');
        }

        $item = $this->service->freezeVersion($version);

        return ApiResponse::success(new ProjectVersionResource($item), 'Project version frozen successfully');
    }

    /**
     * clone project version
     */
    public function clone(Project $project, ProjectVersion $version): JsonResponse
    {
        if ($version->project_id !== $project->id) {
            return ApiResponse::notFound('Project version not found for this project');
        }

        $cloned = $this->service->cloneVersion($version);

        return ApiResponse::success(new ProjectVersionResource($cloned), 'Project version cloned successfully', 201);
    }
}
