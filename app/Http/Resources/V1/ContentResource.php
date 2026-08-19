<?php

namespace App\Http\Resources\V1;

use App\Enums\enContentStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if (request()->route()->getName() === "campaign.contents.show") {
            return [
                'id' => $this->id,
                'campaign_id' => $this->campaign_id,
                'channel_id' => $this->whenLoaded('channel', function () {
                    return new ChannelResource($this->channel);
                }),
                'title' => $this->title,
                'type' => $this->type,
                'script' => $this->script,
                'cost' => $this->cost,
                'status' => $this->status,

                'published_at' => $this->published_at,
                'published_by' => $this->published_by,
                'approved_at' =>
                    $this->when(
                        $this->status == 'approved' ||
                        $this->status == enContentStatus::PUBLISHED->value,
                        $this->approved_at
                    ),

                'cost_confirmed_by' => $this->cost_confirmed_by,
                'cost_confirmed_at' => $this->cost_confirmed_at,

                'assigned_by' => $this->assigned_by,
                'description' => $this->description,
            ];
        }

        return [
            'id' => $this->id,
            'campaign_id' => $this->campaign_id,
            'channel' => $this->whenLoaded('channel', function () {
                return new ChannelResource($this->channel);
            }),
            'title' => $this->title,
            'type' => $this->type,
            'script' => $this->script,
            'cost' => $this->cost,
            'status' => $this->status,
            'published_at' => $this->published_at,
        ];
    }
}
