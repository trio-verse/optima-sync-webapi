<?php

namespace App\Http\Resources\V1\ProjectManagment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectVersionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'based_on_version_id' => $this->based_on_version_id ?? null,
            'version_number' => (int) $this->version_number,
            'title' => $this->title,
            'description' => $this->description ?? null,
            'change_description' => $this->change_description ?? null,
            'start_date' => $this->start_date ?? null,
            'end_date' => $this->end_date ?? null,
            'duration' => $this->duration ?? null,
            'freeze' => (bool) ($this->freeze ?? false),
            'is_editable' => !(bool) ($this->freeze ?? false),
            'has_generated_quotation' => filled($this->quotation_pdf_path),
            'quotation_number' => $this->quotation_number ?? null,
            'quotation_pdf_path' => $this->quotation_pdf_path ?? null,
            'quotation_pdf_url' => $this->quotation_pdf_path
                ? url('storage/' . $this->quotation_pdf_path)
                : null,
            'quotation_generated_at' => $this->quotation_generated_at ?? null,
            $this->mergeWhen($this->freeze, [
                'features_snapshot' => $this->features_snapshot ?? null,
                'costs_snapshot' => $this->costs_snapshot ?? null,
                'employees_snapshot' => $this->employees_snapshot ?? null,
            ]),
            'created_by' => $this->created_by ?? null,
            'created_by_user' => $this->whenLoaded('createdBy', $this->createdBy),
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
        ];
    }
}
