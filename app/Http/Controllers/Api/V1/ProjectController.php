<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ChangeProjectStatusRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\V1\ProjectAllDataResource;
use App\Http\Resources\V1\ProjectResource;
use App\Support\FakePersistence\ProjectModuleFakeStore;
use Database\Factories\ProjectFactory;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectModuleFakeStore $store
    ) {
    }

    public function index(): JsonResponse
    {
        $projects = ProjectResource::collection($this->store->projects()->all());

        return ApiResponse::success($projects, 'Projects retrieved successfully');
    }

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

    public function show(string $project): JsonResponse
    {
        $item = $this->store->projects()->find((int) $project);

        if (!$item) {
            return ApiResponse::notFound('Project not found');
        }

        return ApiResponse::success(new ProjectAllDataResource($item), 'Project retrieved successfully');
    }

    public function update(UpdateProjectRequest $request, string $project): JsonResponse
    {
        $item = $this->store->projects()->update((int) $project, $request->validated());

        if (!$item) {
            return ApiResponse::notFound('Project not found');
        }

        return ApiResponse::success(new ProjectResource($item), 'Project updated successfully');
    }

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
}
