<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationMemberResource extends JsonResource
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
            'organization_id' => $this->organization_id,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'role' => $this->role,
            'createdAt' => $this->created_at->format('Y-m-d\TH:i:s\Z'), // ISO 8601
            'updatedAt' => $this->updated_at->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
