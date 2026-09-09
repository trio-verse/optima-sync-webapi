<?php

namespace App\Http\Resources\V1;

use App\Support\FakePersistence\FakeStore;
use App\Support\FakePersistence\ProjectModuleFakeStore;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectAllDataResource extends JsonResource
{
    private readonly ProjectModuleFakeStore $store;

    public function __construct(private readonly array $project)
    {
        $this->store = app(ProjectModuleFakeStore::class);
    }
    public function toArray(Request $request): array
    {
        $project = $this->store->projects()->find((int) $this->project['id']);
        $versions = $this->store->versions()->where(fn(array $version) => (int) ($version['project_id'] ?? 0) === (int) $this->project['id']);
        $projectVersionIds = $versions->pluck('id')->map(fn($id) => (int) $id)->all();

        $features = $this->store->features()->where(function (array $feature) use ($projectVersionIds) {
            $projectId = (int) ($feature['project_id'] ?? 0);
            $versionId = (int) ($feature['project_version_id'] ?? 0);

            return $projectId === (int) $this->project['id'] || in_array($versionId, $projectVersionIds, true);
        });

        $costs = $this->store->costs()->where(function (array $cost) use ($projectVersionIds) {
            $projectId = (int) ($cost['project_id'] ?? 0);
            $versionId = (int) ($cost['project_version_id'] ?? 0);

            return $projectId === (int) $this->project['id'] || in_array($versionId, $projectVersionIds, true);
        });

        $members = $this->store->members()->where(fn(array $member) => (int) ($member['project_id'] ?? 0) === (int) $this->project['id']);

        $quotations = $this->store->quotations()->where(function (array $quotation) use ($projectVersionIds) {
            $versionId = (int) ($quotation['project_version_id'] ?? 0);

            return in_array($versionId, $projectVersionIds, true);
        });

        $currentVersionId = (int) (($project['current_version_id'] ?? $versions->first()['id'] ?? null) ?? 0);
        $currentVersion = $currentVersionId ? $this->store->versions()->find($currentVersionId) : null;

        $currentVersionUrl = $currentVersionId
            ? route('project.versions.show', ['project' => $this->project['id'], 'version' => $currentVersionId])
            : null;

        $prevVersions = $versions
            ->filter(fn(array $version) => (int) ($version['id'] ?? 0) !== $currentVersionId)
            ->map(fn(array $version) => [
                'id' => $version['id'],
                'url' => route('project.versions.show', ['project' => $this->project['id'], 'version' => $version['id']]),
                'version_number' => $version['version_number'] ?? null,
                'title' => $version['title'] ?? null,
            ])
            ->values()
            ->all();

        $projectReference = $project['reference_id'] ?? $project['project_reference_number'] ?? null;
        $clientDetails = $project['client'] ?? [
            'id' => $project['client_id'] ?? null,
            'name' => null,
            'email' => null,
        ];
        $currentProjectVersion = $currentVersion ?? ($project['current_version'] ?? null);

        return [
            'id' => (int) ($project['id'] ?? $this->project['id']),
            'project_refrence_number' => $projectReference,
            'title' => $currentProjectVersion['title'] ?? null,
            'description' => $currentProjectVersion['description'] ?? null,
            'client_details' => $clientDetails,
            'current_version' => $currentProjectVersion,
            'current_version_number' => $currentProjectVersion['version_number'] ?? null,
            'versions_count' => $versions->count(),
            'key_objectives' => $project['key_objectives'] ?? $currentProjectVersion['key_objectives'] ?? [],
            'features_count' => $features->count(),
            'members_count' => $members->count(),
            'costs_count' => $costs->count(),
            'versions' => [
                'current_version_url' => $currentVersionUrl,
                'prev_versions' => $prevVersions,
            ],
            'created_at' => $project['created_at'] ?? null,
            'updated_at' => $project['updated_at'] ?? null,

            'project' => new ProjectResource($project),
            'versions_data' => ProjectVersionResource::collection($versions),
            'features' => ProjectFeatureResource::collection($features),
            'costs' => ProjectCostResource::collection($costs),
            'members' => ProjectMemberResource::collection($members),
            'quotations' => QuotationResource::collection($quotations),
        ];
    }
}
