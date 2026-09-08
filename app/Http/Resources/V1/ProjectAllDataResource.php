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
        $project = $this->store->projects()->find($this->project['id']);
        $versions = $this->store->versions()->where(fn(array $version) => $version['project_id'] === $this->project['id']);
        $features = $this->store->features()->where(fn(array $feature) => $feature['project_version_id'] === $this->project['id']);
        $costs = $this->store->costs()->where(fn(array $cost) => $cost['project_version_id'] === $this->project['id']);
        $quotations = $this->store->quotations()->where(fn(array $quotation) => $quotation['project_version_id'] === $this->project['id']);
        return [
            'project' => new ProjectResource($project),
            'versions' => ProjectVersionResource::collection($versions),
            'features' => ProjectFeatureResource::collection($features),
            'costs' => ProjectCostResource::collection($costs),
            'quotations' => QuotationResource::collection($quotations),
        ];
    }
}
