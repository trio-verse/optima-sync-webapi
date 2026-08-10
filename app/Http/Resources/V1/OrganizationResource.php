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
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->user_id == auth()->id() ? 'owner' : 'member',
            'phone_number' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'description' => $this->description,
            'logo_url' => $this->whenLoaded('logo', function () {
                return $this->logo ? Storage::disk('public')->url($this->logo->file_path) : null;
            }),
            'members_count' => $this->whenCounted('members', $this->members_count),
            'clients_count' => $this->whenCounted('clients', $this->clients_count),

            'owner' => $this->whenLoaded('user', function () {
                return new UserResource($this->user);
            }),
            
            'members' => $this->whenLoaded('members', function () {
                return OrganizationMemberResource::collection($this->members);
            }),
            'products' => $this->whenLoaded('products', function () {
                return $this->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'description' => $product->description,
                    ];
                });
            }),
            'createdAt' => $this->created_at?->format('Y-m-d\TH:i:s\Z'),
            'updatedAt' => $this->updated_at?->format('Y-m-d\TH:i:s\Z'),
        ];

        return $data;
    }
}
