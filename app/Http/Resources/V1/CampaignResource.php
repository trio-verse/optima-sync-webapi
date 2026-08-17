<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date?->format('Y-m-d\TH:i:s\Z'),
            'end_date' => $this->end_date?->format('Y-m-d\TH:i:s\Z'),
            'expected_budget' => $this->expected_budget,
            'estimated_content_count' => $this->estimated_content_count,
            'status' => $this->status,
            'target' => $this->target,

            $this->mergeWhen($request->routeIs('campaigns.show'), [
                'duration' => $this->duration,
                'content_progress' => $this->content_progress,
                'content_performance' => $this->content_performance,
                'is_overdue' => $this->is_overdue,
                'days_remaining' => $this->days_remaining,
                'formatted_budget' => $this->formatted_budget,

                'connections' => ConnectionResource::collection($this->whenLoaded('connections')),
            ]),
            'createdAt' => $this->created_at?->format('Y-m-d\TH:i:s\Z'),
            'updatedAt' => $this->updated_at?->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
