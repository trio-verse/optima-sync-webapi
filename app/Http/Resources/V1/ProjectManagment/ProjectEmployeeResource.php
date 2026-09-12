<?php

namespace App\Http\Resources\V1\ProjectManagment;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectEmployeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $points = (int) ($this->pivot->total_points ?? $this['total_points'] ?? 0);
        $hoursPerPoint = (int) ($this->houres_per_point ?? $this['houres_per_point'] ?? 2);
        $costPerHour = (float) ($this->cost_per_hour ?? $this['cost_per_hour'] ?? 0);
        $calculatedHours = $points * $hoursPerPoint;
        $calculatedCost = $calculatedHours * $costPerHour;

        return [
            'id' => $this->id ?? $this['id'] ?? null,
            'employee_id' => $this->id ?? $this['employee_id'] ?? null,
            'name' => $this->name ?? $this['name'] ?? null,
            'email' => $this->email ?? $this['email'] ?? null,
            'position' => $this->position ?? $this['position'] ?? null,
            'cost_per_hour' => $costPerHour,
            'houres_per_point' => $hoursPerPoint,
            'total_points' => $points,
            'calculated_hours' => $calculatedHours,
            'calculated_cost' => number_format($calculatedCost, 2, '.', ''),
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
        ];
    }
}
