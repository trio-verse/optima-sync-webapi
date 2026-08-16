<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Stakeholder;

class StakeholderService
{

    public function getClientStakeholders(Client $client, int $perPage = 15)
    {

        return $client->stakeholders()->latest()->simplePaginate($perPage);
    }

    public function createStakeholder(Client $client, array $data): Stakeholder
    {
        return $client->stakeholders()->create($data);
    }


    public function updateStakeholder(Client $client, Stakeholder $stakeholder, array $data): bool
    {
        if ($stakeholder->client_id !== $client->id) {
            return false;
        }
        return $stakeholder->update($data);
    }

    public function deleteStakeholder(Client $client, Stakeholder $stakeholder): bool
    {
        if ($stakeholder->client_id !== $client->id) {
            return false;
        }
        return $stakeholder->delete();
    }
}
