<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCost\StoreProjectCostRequest;
use App\Http\Requests\ProjectCost\UpdateProjectCostRequest;
use App\Http\Resources\V1\ProjectCostResource;
use App\Support\FakePersistence\ProjectModuleFakeStore;
use Database\Factories\ProjectCostFactory;
use Illuminate\Http\JsonResponse;

class ProjectCostController extends Controller
{
    public function __construct(
        protected ProjectModuleFakeStore $store
    ) {
    }

    public function index(string $project, string $version): JsonResponse
    {
        $costs = $this->store->costs()->where(
            fn (array $cost) => (int) $cost['project_id'] === (int) $project
                && (int) $cost['project_version_id'] === (int) $version
        );

        return ApiResponse::success(
            ProjectCostResource::collection($costs),
            'Project costs retrieved successfully'
        );
    }

    public function store(StoreProjectCostRequest $request, string $project, string $version): JsonResponse
    {
        if ($this->versionIsFrozen((int) $version)) {
            return ApiResponse::error(null, 'Cannot add costs to a frozen version', 422);
        }

        $validated = $request->validated();

        $cost = $this->store->costs()->create(ProjectCostFactory::dto(0, (int) $project, (int) $version, array_merge($validated, [
            'quantity' => (int) ($validated['quantity'] ?? 1),
            'amount' => number_format((float) $validated['amount'], 2, '.', ''),
        ])));

        return ApiResponse::success(new ProjectCostResource($cost), 'Project cost created successfully', 201);
    }

    public function show(string $project, string $version, string $cost): JsonResponse
    {
        $item = $this->findForVersion((int) $project, (int) $version, (int) $cost);

        if (!$item) {
            return ApiResponse::notFound('Project cost not found');
        }

        return ApiResponse::success(new ProjectCostResource($item), 'Project cost retrieved successfully');
    }

    public function update(UpdateProjectCostRequest $request, string $project, string $version, string $cost): JsonResponse
    {
        if (!$this->findForVersion((int) $project, (int) $version, (int) $cost)) {
            return ApiResponse::notFound('Project cost not found');
        }

        if ($this->versionIsFrozen((int) $version)) {
            return ApiResponse::error(null, 'Cannot update costs in a frozen version', 422);
        }

        $validated = $request->validated();

        if (isset($validated['amount'])) {
            $validated['amount'] = number_format((float) $validated['amount'], 2, '.', '');
        }

        $item = $this->store->costs()->update((int) $cost, $validated);

        return ApiResponse::success(new ProjectCostResource($item), 'Project cost updated successfully');
    }

    public function destroy(string $project, string $version, string $cost): JsonResponse
    {
        if (!$this->findForVersion((int) $project, (int) $version, (int) $cost)) {
            return ApiResponse::notFound('Project cost not found');
        }

        if ($this->versionIsFrozen((int) $version)) {
            return ApiResponse::error(null, 'Cannot delete costs from a frozen version', 422);
        }

        $this->store->costs()->delete((int) $cost);

        return ApiResponse::success([
            'id' => (int) $cost,
            'project_id' => (int) $project,
            'project_version_id' => (int) $version,
            'deleted' => true,
        ], 'Project cost deleted successfully');
    }

    private function findForVersion(int $projectId, int $versionId, int $costId): ?array
    {
        $item = $this->store->costs()->find($costId);

        if (
            !$item
            || (int) $item['project_id'] !== $projectId
            || (int) $item['project_version_id'] !== $versionId
        ) {
            return null;
        }

        return $item;
    }

    private function versionIsFrozen(int $versionId): bool
    {
        $version = $this->store->versions()->find($versionId);

        return (bool) ($version['freeze'] ?? false);
    }
}
