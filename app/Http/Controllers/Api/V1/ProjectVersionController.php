<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectVersion\StoreProjectVersionRequest;
use App\Http\Requests\ProjectVersion\UpdateProjectVersionRequest;
use App\Http\Resources\V1\ProjectVersionResource;
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
        protected ProjectModuleFakeStore $store
    ) {
    }

    /**
     * index project versions
     * @param string $project
     * @return JsonResponse
     */
    public function index(string $project): JsonResponse
    {
        $versions = $this->store->versions()->where(
            fn (array $version) => (int) $version['project_id'] === (int) $project
        );

        return ApiResponse::success(
            ProjectVersionResource::collection($versions),
            'Project versions retrieved successfully'
        );
    }
    /**
     * store a new project version
     * @param string $project
     * @return JsonResponse
     */
    public function store(StoreProjectVersionRequest $request, string $project): JsonResponse
    {
        $validated = $request->validated();
        $nextNumber = (int) $this->store->versions()
            ->where(fn (array $v) => (int) $v['project_id'] === (int) $project)
            ->max('version_number') + 1;

        $version = $this->store->versions()->create(ProjectVersionFactory::dto(0, (int) $project, array_merge($validated, [
            'version_number' => $nextNumber,
            'freeze' => false,
            'features_snapshot' => null,
            'costs_snapshot' => null,
            'members_snapshot' => null,
            'created_by' => 1,
            'created_by_user' => [
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@optima.test',
            ],
        ])));

        return ApiResponse::success(new ProjectVersionResource($version), 'Project version created successfully', 201);
    }
    /**
     * show project version
     */
    public function show(string $project, string $version): JsonResponse
    {
        $item = $this->findForProject((int) $project, (int) $version);

        if (!$item) {
            return ApiResponse::notFound('Project version not found');
        }

        return ApiResponse::success(new ProjectVersionResource($item), 'Project version retrieved successfully');
    }
    /**
     * update project version
     */
    public function update(UpdateProjectVersionRequest $request, string $project, string $version): JsonResponse
    {
        $existing = $this->findForProject((int) $project, (int) $version);

        if (!$existing) {
            return ApiResponse::notFound('Project version not found');
        }

        if ($existing['freeze'] ?? false) {
            return ApiResponse::error(null, 'Cannot update a frozen version', 422);
        }

        $item = $this->store->versions()->update((int) $version, $request->validated());

        return ApiResponse::success(new ProjectVersionResource($item), 'Project version updated successfully');
    }

    /**
     * delete project version
     */
    public function destroy(string $project, string $version): JsonResponse
    {
        $existing = $this->findForProject((int) $project, (int) $version);

        if (!$existing) {
            return ApiResponse::notFound('Project version not found');
        }

        $this->store->versions()->delete((int) $version);

        return ApiResponse::success([
            'id' => (int) $version,
            'project_id' => (int) $project,
            'deleted' => true,
        ], 'Project version deleted successfully');
    }
    /**
     * freeze project version
     */
    public function freeze(string $project, string $version): JsonResponse
    {
        $existing = $this->findForProject((int) $project, (int) $version);

        if (!$existing) {
            return ApiResponse::notFound('Project version not found');
        }

        $features = $this->store->features()->where(
            fn (array $f) => (int) $f['project_version_id'] === (int) $version
        )->values()->all();

        $costs = $this->store->costs()->where(
            fn (array $c) => (int) $c['project_version_id'] === (int) $version
        )->values()->all();

        $item = $this->store->versions()->update((int) $version, [
            'freeze' => true,
            'features_snapshot' => $features,
            'costs_snapshot' => $costs,
        ]);

        return ApiResponse::success(new ProjectVersionResource($item), 'Project version frozen successfully');
    }

    /**
     * clone project version
     */
    public function clone(string $project, string $version): JsonResponse
    {
        $existing = $this->findForProject((int) $project, (int) $version);

        if (!$existing) {
            return ApiResponse::notFound('Project version not found');
        }

        $nextNumber = (int) $this->store->versions()
            ->where(fn (array $v) => (int) $v['project_id'] === (int) $project)
            ->max('version_number') + 1;

        $cloned = $this->store->versions()->create(ProjectVersionFactory::dto(0, (int) $project, [
            'based_on_version_id' => (int) $version,
            'version_number' => $nextNumber,
            'title' => ($existing['title'] ?? 'Version') . ' (clone)',
            'description' => $existing['description'] ?? null,
            'change_description' => 'Cloned from version #' . $version,
            'start_date' => $existing['start_date'] ?? null,
            'end_date' => $existing['end_date'] ?? null,
            'duration' => $existing['duration'] ?? null,
            'freeze' => false,
            'features_snapshot' => null,
            'costs_snapshot' => null,
            'members_snapshot' => null,
            'created_by' => 1,
            'created_by_user' => [
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@optima.test',
            ],
        ]));

        return ApiResponse::success(new ProjectVersionResource($cloned), 'Project version cloned successfully', 201);
    }

    private function findForProject(int $projectId, int $versionId): ?array
    {
        $item = $this->store->versions()->find($versionId);

        if (!$item || (int) $item['project_id'] !== $projectId) {
            return null;
        }

        return $item;
    }
}
