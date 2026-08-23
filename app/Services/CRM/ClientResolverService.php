<?php

namespace App\Services\CRM;

use App\Models\Client;

class ClientResolverService
{

    public function reslover(int $organizationId, array $data): Client
    {
        // Primary: match by email
        if (!empty($data['email'])) {
            $existing = Client::where('organization_id', $organizationId)
                ->where('email', $data['email'])
                ->first();
            if ($existing)
                return $existing;
        }
        // secondary: match by phone
        if (!empty($data['phone'])) {
            $existing = Client::where('organization_id', $organizationId)
                ->where('phone', $data['phone'])
                ->first();
            if ($existing)
                return $existing;
        }
        // No match : create new client
        return Client::create([
            'organization_id' => $organizationId,
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'client_type' => $data['client_type'] ?? 'individual'
        ]);
    }
}
