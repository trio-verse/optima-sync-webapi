<?php

namespace App\Http\Resources\V1\ProjectManagment;

use App\Http\Resources\V1\ClientResource;
use App\Http\Resources\V1\UserResource;
use App\Services\ProjectManagment\ProjectEmployeeService;
use App\Services\ProjectManagment\ProjectPricingService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $pricingService = new ProjectPricingService(new ProjectEmployeeService);
        $quotationTotals = $pricingService->calculateQuotationTotals($this->resource);

        return [
            'id' => $this->id,
            'reference_id' => $this->reference_id,
            'current_version_id' => $this->current_version_id,
            'title' => $this->whenLoaded('currentVersion', fn () => $this->currentVersion->title ?? null),
            'status' => $this->status,
            'source' => $this->source,
            'client_id' => $this->client_id,

            // budget related fields
            'sub_total' => number_format($this->sub_total, 2, '.', ''),
            'profit_percentage' => $this->profit_percentage.' %',
            'development_fee' => number_format($quotationTotals['development_fee'], 2, '.', ''),
            'discount' => number_format((float) ($this->discount ?? 0), 2, '.', ''),
            'tax' => number_format((float) ($this->tax ?? 0), 2, '.', ''),
            'added_costs_total' => number_format($quotationTotals['added_costs_total'], 2, '.', ''),
            'total_amount' => number_format($quotationTotals['total'], 2, '.', ''),
            'issue_date' => $this->issue_date ?? null,
            'valid_until' => $this->valid_until ?? null,
            'payment_terms' => $this->payment_terms ?? null,

            'client' => $this->whenLoaded('client', fn () => new ClientResource($this->client)),
            'current_version' => $this->whenLoaded('currentVersion', fn () => new ProjectVersionResource($this->currentVersion)),
            // 'created_by' => $this->whenLoaded('createdBy', fn () => $this->createdBy),
            'created_by_user' => $this->whenLoaded('createdBy', fn () => new UserResource($this->createdBy)),
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
        ];
    }
}
