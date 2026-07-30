<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class ClientResource extends JsonResource
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
        'name' => $this->name,
        'client_type' => $this->client_type,
        'contact_info' => [
            'phone' => $this->phone,
            'email' => $this->email,
            'whatsapp' => $this->whatsapp,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'website' => $this->website,
            'address' => $this->address,
        ],
        'industry' => new IndustryResource($this->whenLoaded('industry')),
        'city' => new CityResource($this->whenLoaded('city')),
        'stakeholders' =>[],
        'notes' => $this->notes,
        'created_at' => $this->created_at?->toIso8601String(),
    ];
}
}
