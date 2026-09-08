<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectCostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $quantity = (int) ($this['quantity'] ?? 1);
        $amount = (float) ($this['amount'] ?? 0);
        $lineTotal = $quantity * $amount;

        return [
            'id' => $this['id'],
            'project_id' => $this['project_id'],
            'project_version_id' => $this['project_version_id'],
            'name' => $this['name'],
            'description' => $this['description'] ?? null,
            'quantity' => $quantity,
            'amount' => number_format($amount, 2, '.', ''),
            'line_total' => number_format($lineTotal, 2, '.', ''),
            'formatted_amount' => number_format($amount, 2),
            'formatted_line_total' => number_format($lineTotal, 2),
            'created_at' => $this['created_at'] ?? null,
            'updated_at' => $this['updated_at'] ?? null,
        ];
    }
}
