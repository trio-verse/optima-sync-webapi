<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ChangeProjectStatusRequest;
use App\Http\Requests\Project\RequestProjectRequest;
use App\Http\Requests\Project\StoreProjectMemberRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectMemberRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\V1\ProjectAllDataResource;
use App\Http\Resources\V1\ProjectMemberResource;
use App\Http\Resources\V1\ProjectResource;
use App\Models\Organization;
use App\Services\OrgSecureCryptService;
use App\Support\FakePersistence\ProjectModuleFakeStore;
use Database\Factories\ProjectFactory;
use Illuminate\Http\JsonResponse;

/**
 * @group Projects
 *
 * APIs for managing projects (fake persistence — no DB yet)
 */
class ProjectController extends Controller
{
    public function __construct(
        protected ProjectModuleFakeStore $store
    ) {
    }

    /**
     * index projects
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $projects = ProjectResource::collection($this->store->projects()->all());

        return ApiResponse::success($projects, 'Projects retrieved successfully');
    }

    /**
     * store project
     * @return JsonResponse
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $subTotal = (float) ($validated['sub_total'] ?? 0);
        $profit = (int) ($validated['profit_percentage'] ?? 20);
        $total = $validated['total_amount'] ?? number_format($subTotal * (1 + $profit / 100), 2, '.', '');

        $project = $this->store->projects()->create(ProjectFactory::dto(0, array_merge($validated, [
            'organization_id' => 1,
            'created_by' => 1,
            'current_version_id' => null,
            'status' => $validated['status'] ?? 'new',
            'source' => $validated['source'] ?? 'internal',
            'sub_total' => number_format($subTotal, 2, '.', ''),
            'profit_percentage' => $profit,
            'total_amount' => is_numeric($total) ? number_format((float) $total, 2, '.', '') : $total,
            'client' => [
                'id' => $validated['client_id'],
                'name' => 'Client #' . $validated['client_id'],
                'email' => null,
            ],
            'current_version' => null,
            'created_by_user' => [
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@optima.test',
            ],
        ])));

        return ApiResponse::success(new ProjectResource($project), 'Project created successfully', 201);
    }
    /**
     * show project
     * @return JsonResponse
     */
    public function show(string $project): JsonResponse
    {
        $item = $this->store->projects()->find((int) $project);

        if (!$item) {
            return ApiResponse::notFound('Project not found');
        }

        return ApiResponse::success(new ProjectAllDataResource($item), 'Project retrieved successfully');
    }

    /**
     * list project members
     * @return JsonResponse
     */
    public function members(string $project): JsonResponse
    {
        $memberList = $this->store->members()->where(
            fn(array $member) => (int) $member['project_id'] === (int) $project
        );

        return ApiResponse::success(
            ProjectMemberResource::collection($memberList),
            'Project members retrieved successfully'
        );
    }

    /**
     * update project member
     * @return JsonResponse
     */
    public function updateMember(UpdateProjectMemberRequest $request, string $project, string $member): JsonResponse
    {
        $existing = $this->findProjectMember((int) $project, (int) $member);

        if (!$existing) {
            return ApiResponse::notFound('Project member not found');
        }

        $item = $this->store->members()->update((int) $member, $request->validated());

        return ApiResponse::success(new ProjectMemberResource($item), 'Project member updated successfully');
    }

    /**
     * delete project member
     * @return JsonResponse
     */
    public function deleteMember(string $project, string $member): JsonResponse
    {
        if (!$this->findProjectMember((int) $project, (int) $member)) {
            return ApiResponse::notFound('Project member not found');
        }

        $this->store->members()->delete((int) $member);

        return ApiResponse::success([
            'id' => (int) $member,
            'project_id' => (int) $project,
            'deleted' => true,
        ], 'Project member deleted successfully');
    }

    /**
     * update project
     * @return JsonResponse
     */
    public function update(UpdateProjectRequest $request, string $project): JsonResponse
    {
        $validated = $request->validated();
        $current = $this->store->projects()->find((int) $project);

        if (!$current) {
            return ApiResponse::notFound('Project not found');
        }

        $subTotal = (float) ($validated['sub_total'] ?? $current['sub_total'] ?? 0);
        $profit = (int) ($validated['profit_percentage'] ?? $current['profit_percentage'] ?? 0);
        $validated['sub_total'] = number_format($subTotal, 2, '.', '');
        $validated['profit_percentage'] = $profit;
        $validated['total_amount'] = number_format($subTotal * (1 + ($profit / 100)), 2, '.', '');

        $item = $this->store->projects()->update((int) $project, $validated);

        return ApiResponse::success(new ProjectResource($item), 'Project updated successfully');
    }

    /**
     * delete project
     * @return JsonResponse
     */
    public function destroy(string $project): JsonResponse
    {
        if (!$this->store->projects()->delete((int) $project)) {
            return ApiResponse::notFound('Project not found');
        }

        return ApiResponse::success([
            'id' => (int) $project,
            'deleted' => true,
        ], 'Project deleted successfully');
    }

    /**
     * change project status
     * @return JsonResponse
     */
    public function changeStatus(ChangeProjectStatusRequest $request, string $project): JsonResponse
    {
        $item = $this->store->projects()->update((int) $project, [
            'status' => $request->validated('status'),
        ]);

        if (!$item) {
            return ApiResponse::notFound('Project not found');
        }

        return ApiResponse::success(new ProjectResource($item), 'Project status updated successfully');
    }

    /**
     * project-request
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

    private function findProjectMember(int $projectId, int $memberId): ?array
    {
        $item = $this->store->members()->find($memberId);

        if (!$item || (int) $item['project_id'] !== $projectId) {
            return null;
        }

        return $item;
    }
}
