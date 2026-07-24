<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OrganizationResource extends JsonResource
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
            'phone_number' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'description' => $this->description,
            // 'logo' => $this->logo ? $this->logo->file_path : null,
            'logo' => $this->when($this->logo, Storage::url($this->logo->file_path)),

            'createdAt' => $this->created_at->format('Y-m-d\TH:i:s\Z'), // ISO 8601
            'updatedAt' => $this->updated_at->format('Y-m-d\TH:i:s\Z'),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
