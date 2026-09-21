<?php

namespace App\Http\Controllers\Api\V1\ProjectManagment;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ChangeProjectStatusRequest;
use App\Http\Requests\Project\RequestProjectRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\V1\ProjectManagment\ProjectAllDataResource;
use App\Http\Resources\V1\ProjectManagment\ProjectResource;
use App\Models\Organization;
use App\Models\Project;
use App\Services\OrgSecureCryptService;
use App\Services\ProjectManagment\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Projects
 *
 * APIs for managing projects (fake persistence — no DB yet)
 */
class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $service
    ) {
    }

    /**
     * index projects
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $projects = $this->service->getFilteredProjects($request->all());
        return ApiResponse::pagination(ProjectResource::collection($projects), 'Projects retrieved successfully');
    }

    /**
     * store project
     * @return JsonResponse
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $project = $this->service->createProject($validated);

        return ApiResponse::success(new ProjectResource($project), 'Project created successfully', 201);
    }
    /**
     * show project
     * @return JsonResponse
     */
    public function show(Project $project): JsonResponse
    {
        if (!$project) {
            return ApiResponse::notFound('Project not found');
        }
        $project = $this->service->getProject($project);

        return ApiResponse::success(new ProjectAllDataResource($project), 'Project retrieved successfully');
    }


    /**
     * update project
     * @return JsonResponse
     */
    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $validated = $request->validated();
        $project = $this->service->updateProject($project, $validated);
        return ApiResponse::success(new ProjectResource($project), 'Project updated successfully');
    }

    /**
     * delete project
     * @return JsonResponse
     */
    public function destroy(Project $project): JsonResponse
    {
        if (!$this->service->deleteProject($project)) {
            return ApiResponse::notFound('Project not found');
        }

        return ApiResponse::success([
            'id' => $project->id,
            'deleted' => true,
        ], 'Project deleted successfully');
    }

    /**
     * change project status
     * @return JsonResponse
     */
    public function changeStatus(ChangeProjectStatusRequest $request, Project $project): JsonResponse
    {
        $item = $this->service->changeStatus(
            $project,
            $request->validated('status')
        );

        if (!$item) {
            return ApiResponse::notFound('Project not found');
        }

        return ApiResponse::success(new ProjectResource($item), 'Project status updated successfully');
    }

    /**
     * project-request
     * @unauthenticated
     */
    public function requestProject(RequestProjectRequest $request, string $token)
    {

        $orgId = OrgSecureCryptService::decrypt($token);

        if (!$orgId)
            return ApiResponse::notFound('Invalid or malformed token.', 404);
        $request->validated();

        $organization = Organization::find($orgId);

        if (!$organization)
            return ApiResponse::notFound('Organization not found.', 404);

        return ApiResponse::success(null, "project request created successfully");

    }


}
