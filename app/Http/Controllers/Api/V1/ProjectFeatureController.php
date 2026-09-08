<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectFeature\ChangeProjectFeatureStatusRequest;
use App\Http\Requests\ProjectFeature\StoreProjectFeatureRequest;
use App\Http\Requests\ProjectFeature\UpdateProjectFeatureRequest;
use App\Http\Resources\V1\ProjectFeatureResource;
use App\Support\FakePersistence\ProjectModuleFakeStore;
use Database\Factories\ProjectFeatureFactory;
use Illuminate\Http\JsonResponse;
/**
 * @group Project Features
 *
 * APIs for managing project Features (fake persistence — no DB yet)
 */
class ProjectFeatureController extends Controller
{
    public function __construct(
        protected ProjectModuleFakeStore $store
    ) {
    }

    /**
     * index project costs
     * @return JsonResponse
     */
    public function index(string $project, string $version): JsonResponse
    {
        $features = $this->store->features()->where(
            fn (array $feature) => (int) $feature['project_id'] === (int) $project
                && (int) $feature['project_version_id'] === (int) $version
        );

        return ApiResponse::success(
            ProjectFeatureResource::collection($features),
            'Project features retrieved successfully'
        );
    }

    /**
     * store
     * @return JsonResponse
     */
    public function store(StoreProjectFeatureRequest $request, string $project, string $version): JsonResponse
    {
        if ($this->versionIsFrozen((int) $version)) {
            return ApiResponse::error(null, 'Cannot add features to a frozen version', 422);
        }

        $feature = $this->store->features()->create(ProjectFeatureFactory::dto(0, (int) $project, (int) $version, array_merge(
            $request->validated(),
            ['status' => $request->validated('status', 'new')]
        )));

        return ApiResponse::success(new ProjectFeatureResource($feature), 'Project feature created successfully', 201);
    }

    /**
     * show
     * @return JsonResponse
     */
    public function show(string $project, string $version, string $feature): JsonResponse
    {
        $item = $this->findForVersion((int) $project, (int) $version, (int) $feature);

        if (!$item) {
            return ApiResponse::notFound('Project feature not found');
        }

        return ApiResponse::success(new ProjectFeatureResource($item), 'Project feature retrieved successfully');
    }
    
    /**
     * update
     * @return JsonResponse
     */
    public function update(UpdateProjectFeatureRequest $request, string $project, string $version, string $feature): JsonResponse
    {
        if (!$this->findForVersion((int) $project, (int) $version, (int) $feature)) {
            return ApiResponse::notFound('Project feature not found');
        }

        if ($this->versionIsFrozen((int) $version)) {
            return ApiResponse::error(null, 'Cannot update features in a frozen version', 422);
        }

        $item = $this->store->features()->update((int) $feature, $request->validated());

        return ApiResponse::success(new ProjectFeatureResource($item), 'Project feature updated successfully');
    }
    /**
     * delete
     * @return JsonResponse
     */
    public function destroy(string $project, string $version, string $feature): JsonResponse
    {
        if (!$this->findForVersion((int) $project, (int) $version, (int) $feature)) {
            return ApiResponse::notFound('Project feature not found');
        }

        if ($this->versionIsFrozen((int) $version)) {
            return ApiResponse::error(null, 'Cannot delete features from a frozen version', 422);
        }

        $this->store->features()->delete((int) $feature);

        return ApiResponse::success([
            'id' => (int) $feature,
            'project_id' => (int) $project,
            'project_version_id' => (int) $version,
            'deleted' => true,
        ], 'Project feature deleted successfully');
    }

    /**
     * change feature status
     * @return JsonResponse
     */
    public function changeStatus(ChangeProjectFeatureStatusRequest $request, string $project, string $version, string $feature): JsonResponse
    {
        if (!$this->findForVersion((int) $project, (int) $version, (int) $feature)) {
            return ApiResponse::notFound('Project feature not found');
        }

        $item = $this->store->features()->update((int) $feature, [
            'status' => $request->validated('status'),
        ]);

        return ApiResponse::success(new ProjectFeatureResource($item), 'Project feature status updated successfully');
    }

    private function findForVersion(int $projectId, int $versionId, int $featureId): ?array
    {
        $item = $this->store->features()->find($featureId);

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
