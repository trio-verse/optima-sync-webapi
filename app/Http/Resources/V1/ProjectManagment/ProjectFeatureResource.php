<?php

namespace App\Http\Resources\V1\ProjectManagment;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectFeatureResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'project_version_id' => $this->project_version_id,
            'name' => $this->name,
            'description' => $this->description ?? null,
            'status' => $this->status,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
        ];
    }
}
