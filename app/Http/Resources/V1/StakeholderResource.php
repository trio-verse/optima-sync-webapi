<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StakeholderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'clientId'   => $this->client_id,
            'name'       => $this->name,
            'phone'      => $this->phone,
            'role'       => $this->role,
            'createdAt' => $this->created_at?->format('Y-m-d\TH:i:s\Z'),
            'updatedAt' => $this->updated_at?->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
