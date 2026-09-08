<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $subTotal = (float) ($this['sub_total'] ?? 0);
        $profit = (int) ($this['profit_percentage'] ?? 0);
        $total = (float) ($this['total_amount'] ?? 0);

        return [
            'id' => $this['id'],
            'reference_id' => $this['reference_id'],
            'organization_id' => $this['organization_id'],
            'client_id' => $this['client_id'],
            'current_version_id' => $this['current_version_id'],
            'status' => $this['status'],
            'source' => $this['source'],
            'sub_total' => number_format($subTotal, 2, '.', ''),
            'profit_percentage' => $profit,
            'total_amount' => number_format($total, 2, '.', ''),
            'formatted_sub_total' => number_format($subTotal, 2),
            'formatted_total_amount' => number_format($total, 2),
            'client' => $this['client'] ?? [
                'id' => $this['client_id'],
                'name' => null,
                'email' => null,
            ],
            'current_version' => $this['current_version'] ?? null,
            'created_by' => $this['created_by'],
            'created_by_user' => $this['created_by_user'] ?? null,
            'created_at' => $this['created_at'] ?? null,
            'updated_at' => $this['updated_at'] ?? null,
        ];
    }
}
