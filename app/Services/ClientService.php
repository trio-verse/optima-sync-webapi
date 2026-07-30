<?php

namespace App\Services;

use App\Models\Client;

class ClientService
{
    public function createClient(array $data): bool
    {
        return Client::create($data);
    }

    public function updateClient(array $data, Client $client): bool
    {
        return $client->update($data);
    }
}
