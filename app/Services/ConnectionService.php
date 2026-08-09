<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Connection;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class ConnectionService
{

    public function getAllConnections(array $data): LengthAwarePaginator
    {
        try {
            return Connection::with(['client', 'channel', 'assignee', 'product'])->latest()->paginate($data['per_page']??null);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function getClientConnections(Client $client, array $data): LengthAwarePaginator
    {
        try {
            return $client->connections()->paginate($data['per_page'], ['*'], 'page', $data['page']);
        } catch (\Exception $exception) {
            Log::error('Error getting client connections: ' . $exception->getMessage());
            return new LengthAwarePaginator([], 0, 10);
        }
    }


    public function storeConnection(Client $client, array $data): bool
    {
        try {

            $client->connections()->create($data)->save();
            return true;
        } catch (\Exception $exception) {
            Log::error('Error storing connection: ' . $exception->getMessage());
            return false;
        }
    }

}