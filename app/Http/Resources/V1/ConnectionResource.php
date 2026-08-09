<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConnectionResource extends JsonResource
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
            'client_id' => $this->client_id,
            'product_id' => $this->product_id,
            'stage' => $this->stage,
            'channel_id' => $this->channel_id,
            'assignee_id' => $this->assignee_id,
            'initiated_by' => $this->initiated_by,
            'created_at' => $this->created_at->format('Y-m-d\TH:i:s\Z'),
            'updated_at' => $this->updated_at->format('Y-m-d\TH:i:s\Z'),
            // 'client' => $this->whenLoaded('client' , fn() => new ClientResource($this->client)),
            'client' => $this->whenLoaded('client' , function(){
                return[
                    'id' => $this->client->id,
                    'name' => $this->client->name,
                    'email' => $this->client->email,
                    'phone' => $this->client->phone,
                    'full_address' => $this->client->full_address,
                    'city_id' => $this->client->city_id,
                    'industry_id' => $this->client->industry_id,
                    'client_type' => $this->client->client_type,
                    'notes' => $this->client->notes,
                ];
            }),
            'product' => $this->whenLoaded('product' , fn() => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->price,
                'description' => $this->product->description,
                
            ]),
            'channel' => $this->whenLoaded('channel' , fn() => [
                'id' => $this->channel->id,
                'name' => $this->channel->name,
            ]),
            'assignee' => $this->whenLoaded('assignee' , fn() => [
                'id' => $this->assignee->id,    
                'name' => $this->assignee->name,
                'email' => $this->assignee->email,
            ]),
        ];
    }
}
