<?php

namespace App\Http\Resources\V1\ProjectManagment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectMeetingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'organization_id' => $this->organization_id,
            'title' => $this->title,
            'meeting_date' => $this->meeting_date ? $this->meeting_date->toIso8601String() : null,
            'meeting_url' => $this->meeting_url ?? null,
            'description' => $this->description ?? null,
            'stakeholders' => $this->stakeholders ?? [],
            'team_members' => $this->team_members ?? [],
            'created_by' => $this->created_by ?? null,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
        ];
    }
}
