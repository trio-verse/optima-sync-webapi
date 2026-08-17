<?php

namespace App\Services;

use App\Models\Campaign;
use Illuminate\Support\Facades\DB;

class CampaignService
{


    public function showAll()
    {
        return Campaign::orderBy('status')->get();
    }

    public function save(array $data): Campaign
    {
        return Campaign::create($data);
    }
    public function update(Campaign $campaign, array $data): Campaign
    {
        $campaign->fill($data)->saveOrFail();
        return $campaign;
    }

    public function show(Campaign $campaign): Campaign
    {
        return $campaign->load(['connections']);
    }

    public function delete(Campaign $campaign): bool|null
    {
        return $campaign->delete();
    }
}
