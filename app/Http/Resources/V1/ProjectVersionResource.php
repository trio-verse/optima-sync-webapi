<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectVersionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'project_id' => $this['project_id'],
            'based_on_version_id' => $this['based_on_version_id'] ?? null,
            'version_number' => (int) $this['version_number'],
            'title' => $this['title'],
            'description' => $this['description'] ?? null,
            'change_description' => $this['change_description'] ?? null,
            'start_date' => $this['start_date'] ?? null,
            'end_date' => $this['end_date'] ?? null,
            'duration' => $this['duration'] ?? null,
            'freeze' => (bool) ($this['freeze'] ?? false),
            'is_editable' => ! (bool) ($this['freeze'] ?? false),
            'features_snapshot' => $this['features_snapshot'] ?? null,
            'costs_snapshot' => $this['costs_snapshot'] ?? null,
            'members_snapshot' => $this['members_snapshot'] ?? null,
            'created_by' => $this['created_by'] ?? null,
            'created_by_user' => $this['created_by_user'] ?? null,
            'created_at' => $this['created_at'] ?? null,
            'updated_at' => $this['updated_at'] ?? null,
        ];
    }
}
