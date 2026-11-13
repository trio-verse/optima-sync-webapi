<?php

namespace App\Http\Resources\V1\Workspace;

use App\Http\Resources\V1\OrganizationMemberResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'workspace_id' => $this->workspace_id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'member_id' => $this->organization_member_id,
            'member_info' => $this->whenLoaded('organizationMember', function () {
                return new OrganizationMemberResource($this->organizationMember->loadMissing('user'));
            }),
            'created_at' => $this->created_at?->format('Y-m-d\TH:i:s\Z'),
            'updated_at' => $this->updated_at?->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
