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
                'address' => $this->address,
            ],
            'address' =>
                $this->full_address,
            'industry' => new IndustryResource($this->industry),
            'stackholders' => [],
            'createdAt' =>  $this->created_at
        ];
    }
}
