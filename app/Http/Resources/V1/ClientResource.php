<?php

namespace App\Http\Resources\V1;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->client_type,

            'contact_info' => [
                'phone' => $this->phone,
                'email' => $this->email,
                'whatsapp' => $this->whatsapp,
                'facebook' => $this->facebook,
                'instagram' => $this->instagram,
                'website' => $this->website,
            ],

            'address' => [
                'raw' => $this->address,
                'full' => $this->full_address,
                'city' => new CityResource($this->whenLoaded('city')),
            ],

            'industry' => new IndustryResource($this->whenLoaded('industry')),

            'notes' => $this->notes,
            'stakeholders' => StakeholderResource::collection($this->whenLoaded('stakeholders')),
            'createdAt' => $this->created_at?->format('Y-m-d\TH:i:s\Z'),
            'updatedAt' => $this->updated_at?->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
