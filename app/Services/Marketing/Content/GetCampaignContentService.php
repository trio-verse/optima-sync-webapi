<?php

namespace App\Services\Marketing\Content;

use App\Models\Campaign;
use Illuminate\Pagination\LengthAwarePaginator;

class GetCampaignContentServiceP
{

    public function getContent(Campaign $campaign, array $data): LengthAwarePaginator
    {
        $campaign->load('contents');
        return $campaign->contents()->orderBy($data['order'] ?? 'created_at', $data['sort'] ?? 'desc')
            ->paginate($data['per_page'] ?? null);
    }
}