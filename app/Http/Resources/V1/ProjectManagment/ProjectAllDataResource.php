<?php

namespace App\Http\Resources\V1\ProjectManagment;

use App\Http\Resources\V1\ClientResource;
use App\Http\Resources\V1\ProjectManagment\ProjectVersionResource;
use App\Models\ProjectVersion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectAllDataResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // URL : for the current version
        $currentVersionUrl = $this->current_version_id
            ? route('project.versions.show', ['project' => $this->id, 'version' => $this->current_version_id])
            : null;

        // URL : previos versions
        $prevVersions = $this->freeze_versions
            ->filter(fn(ProjectVersion $version) => (int) ($version->id ?? 0) !== $this->current_version_id)
            ->map(fn(ProjectVersion $version) => [
                'id' => $version['id'],
                'url' => route('project.versions.show', ['project' => $this->id, 'version' => $version->id]),
                'version_number' => $version->version_number ?? null,
                'title' => $version->title ?? null,
            ])
            ->values()
            ->all();


        $currentVersion = $this->active_version ?? $this->currentVersion;

        return [
            'id' => $this->id,
            'project_refrence_number' => $this->reference_id,
            'title' => $currentVersion->title,
            'description' => $currentVersion->description ?? null,
            'status' => $this->status,
            'source' => $this->source,
            'current_version_number' => $currentVersion->version_number ?? null,
            // project_amounts
            'sub_total' => number_format((float) ($this->sub_total ?? 0), 2, '.', ''),
            'profit_percentage' => (int) ($this->profit_percentage ?? 0),
            'total_amount' => number_format((float) ($this->total_amount == 0 ? $this->total_budget : $this->total_amount ), 2, '.', ''),
            // client details
            'client_details' => $this->whenLoaded('client', new ClientResource($this->client), []),
            // versions
            'current_version' => new ProjectVersionResource($currentVersion),



            'freeze_versions_data' => ProjectVersionResource::collection($this->freeze_versions),
            'features' => ProjectFeatureResource::collection($this->features),
            'costs' => ProjectCostResource::collection($this->costs),
            'employees' => ProjectEmployeeResource::collection($this->whenLoaded('employees')),
            'quotations' => QuotationResource::collection($this->quotations),

            'counts' => [
                'versions_count' => $this->versions_count,
                'features_count' => $this->features_count,
                'employees_count' => $this->employees_count,
                'costs_count' => $this->costs_count,
            ],

            'versions_url' => [
                'current_version_url' => $currentVersionUrl,
                'prev_versions' => $prevVersions,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
