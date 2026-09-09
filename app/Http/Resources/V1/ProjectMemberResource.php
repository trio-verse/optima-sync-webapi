<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectMemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'project_id' => $this['project_id'],
            'user_id' => $this['user_id'] ?? null,
            'name' => $this['name'] ?? null,
            'email' => $this['email'] ?? null,
            'role' => $this['role'] ?? null,
            'created_at' => $this['created_at'] ?? null,
            'updated_at' => $this['updated_at'] ?? null,
        ];
    }
}
