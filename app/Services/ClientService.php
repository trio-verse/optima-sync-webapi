<?php

namespace App\Services;

use App\Models\Client;

class ClientService
{
    public function createClient(array $data): Client
    {
        return Client::create($data);
    }

    public function updateClient(array $data, Client $client): bool
    {
        return $client->update($data);
    }

    public function getClientsList(array $filters)
    {
        $query = Client::with(['city', 'industry']);

        $query
            ->nameFilter($filters['search']['name'] ?? null)
            ->contactInfoFilter($filters['search']['contact_info'] ?? null)
            ->cityFilter($filters['city_id'] ?? null)
            ->industryFilter($filters['industry_id'] ?? null)
            ->typeFilter($filters['type'] ?? null)
        ;
        return $query->latest()->paginate($filters['per_page'] ?? 15);
    }
}
