<?php

namespace App\Services;

use App\Models\Channel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class ChannelService
{

    public function getAllChannels(int $perPage = 15): Paginator
    {
        return Channel::latest()->simplePaginate($perPage);
    }

    public function createChannel(array $data): Channel
    {
        return DB::transaction(function () use ($data) {
            return Channel::create($data);
        });
    }

    public function updateChannel(array $data, Channel $channel): bool
    {
        return DB::transaction(function () use ($data, $channel) {
            return $channel->update($data);
        });
    }

    public function deleteChannel(Channel $channel): bool
    {
        return DB::transaction(function () use ($channel) {
            return $channel->delete();
        });
    }
}
