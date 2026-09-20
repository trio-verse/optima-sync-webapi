<?php

namespace App\Http\Resources\V1\ProjectManagment;


use App\Http\Resources\V1\ClientResource;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference_id' => $this->reference_id,
            'status' => $this->status,
            'source' => $this->source,
            'client_id' => $this->client_id,
            'client' => $this->whenLoaded('client', new ClientResource($this->client)),
            'current_version_id' => $this->current_version_id,
            'current_version' => $this->whenLoaded('currentVersion', new ProjectVersionResource($this->currentVersion)),

            // budget related fields
            'sub_total' => number_format($this->sub_total, 2, '.', ''),
            'profit_percentage' => $this->profit_percentage . ' %',
            'total_amount' => number_format($this->total_amount, 2, '.', ''),
            'discount' => number_format((float) ($this->discount ?? 0), 2, '.', ''),
            'tax' => number_format((float) ($this->tax ?? 0), 2, '.', ''),
            'issue_date' => $this->issue_date ?? null,
            'valid_until' => $this->valid_until ?? null,
            'payment_terms' => $this->payment_terms ?? null,

            'created_by' => $this->created_by,
            'created_by_user' => $this->whenLoaded('createdBy', new UserResource($this->createdBy)),
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
        ];
    }
}
