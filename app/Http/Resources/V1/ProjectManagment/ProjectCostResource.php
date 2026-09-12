<?php

namespace App\Http\Resources\V1\ProjectManagment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectCostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'name' => $this->name,
            'description' => $this->description ?? null,
            'quantity' => (int) ($this->quantity ?? 1),
            'amount' => (float) $this->amount,
            'line_total' => (float) $this->line_total,
            'formatted_amount' => $this->formatted_amount,
            'formatted_line_total' => $this->formatted_line_total,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
        ];
    }
}
