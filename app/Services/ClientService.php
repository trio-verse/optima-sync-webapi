<?php

namespace App\Services;

use App\Models\Client;


class ClientService
{
    public function getClientsList(array $filters)
    {
        // dd(Client::query()->cityFilter($filters['city_id'] ?? null));
        return Client::query()
            ->with(['city', 'industry'])
            ->nameFilter($filters['search']['name'] ?? null)
            ->contactInfoFilter($filters['search']['contact_info'] ?? null)
            ->cityFilter($filters['city_id'] ?? null)
            ->industryFilter($filters['industry_id'] ?? null)
            ->typeFilter($filters['type'] ?? null)
            ->latest()
            ->paginate($filters['per_page'] ?? 15);
    }
}