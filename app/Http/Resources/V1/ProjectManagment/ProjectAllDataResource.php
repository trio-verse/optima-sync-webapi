<?php

namespace App\Http\Resources\V1\ProjectManagment;

use App\Http\Resources\V1\ClientResource;
use App\Models\ProjectVersion;
use App\Services\ProjectManagment\ProjectEmployeeService;
use App\Services\ProjectManagment\ProjectPricingService;
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
            ->filter(fn (ProjectVersion $version) => (int) ($version->id ?? 0) !== $this->current_version_id)
            ->map(fn (ProjectVersion $version) => [
                'id' => $version['id'],
                'url' => route('project.versions.show', ['project' => $this->id, 'version' => $version->id]),
                'version_number' => $version->version_number ?? null,
                'title' => $version->title ?? null,
            ])
            ->values()
            ->all();

        // current_version_id is the authoritative pointer. Historical
        // versions expose their Features through snapshots, never through the
        // project's live Feature relation.
        $currentVersion = $this->currentVersion ?? $this->active_version;

        // Get quotation totals
        $pricingService = new ProjectPricingService(new ProjectEmployeeService);
        $quotationTotals = $pricingService->calculateQuotationTotals($this->resource);

        return [
            'id' => $this->id,
            'project_refrence_number' => $this->reference_id,
            'title' => $currentVersion?->title,
            'description' => $currentVersion?->description,
            'status' => $this->status,
            'source' => $this->source,
            'current_version_number' => $currentVersion?->version_number,

            // project_amounts
            'sub_total' => number_format((float) ($this->sub_total ?? 0), 2, '.', ''),
            'profit_percentage' => (int) ($this->profit_percentage ?? 0),
            'development_fee' => number_format($quotationTotals['development_fee'], 2, '.', ''),
            // 'total_amount' => number_format((float) ($this->total_amount == 0 ? $this->total_budget : $this->total_amount), 2, '.', ''),
            'discount' => number_format((float) ($this->discount ?? 0), 2, '.', ''),
            'tax' => number_format((float) ($this->tax ?? 0), 2, '.', ''),
            'added_costs_total' => number_format($quotationTotals['added_costs_total'], 2, '.', ''),
            'total_amount' => number_format($quotationTotals['total'], 2, '.', ''),

            'issue_date' => $this->issue_date ?? null,
            'valid_until' => $this->valid_until ?? null,
            'payment_terms' => $this->payment_terms ?? null,
            // client details
            'client_details' => $this->whenLoaded('client', new ClientResource($this->client), []),
            // versions
            'current_version' => $currentVersion
                ? new ProjectVersionResource($currentVersion)
                : null,

            'costs' => ProjectCostResource::collection($this->costs),
            'employees' => ProjectEmployeeResource::collection($this->whenLoaded('employees')),
            'features' => ProjectFeatureResource::collection($currentVersion?->features ?? collect()),
            'counts' => [
                'versions_count' => $this->versions_count,
                'features_count' => $currentVersion?->features->count() ?? 0,
                'employees_count' => $this->employees_count,
                'costs_count' => $this->costs_count,
            ],

            'versions_url' => [
                'current_version_url' => $currentVersionUrl,
                'prev_versions' => $prevVersions,
            ],
            'freeze_versions_data' => ProjectVersionResource::collection($this->freeze_versions),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
