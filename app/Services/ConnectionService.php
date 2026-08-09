<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Connection;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class ConnectionService
{

    public function getAllConnections(array $data): LengthAwarePaginator
    {
        try {
            return Connection::with(['client', 'channel', 'assignee', 'product'])->latest()->paginate($data['per_page'] ?? null);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function getClientConnections(Client $client, array $data): LengthAwarePaginator
    {
        try {
            return $client->connections()->paginate($data['per_page'] ?? null);
        } catch (Throwable $th) {
            Log::error('Error getting client connections: ' . $exception->getMessage());
            throw $th;
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

    public function updateConnection(Connection $connection, array $data): bool
    {
        try {
            $connection->update($data);
            return true;
        } catch (\Exception $exception) {
            Log::error('Error updating connection: ' . $exception->getMessage());
            return false;
        }
    }

    public function deleteConnection(Connection $connection): bool
    {
        try {
            $connection->delete();
            return true;
        } catch (\Exception $exception) {
            Log::error('Error deleting connection: ' . $exception->getMessage());
            return false;
        }
    }

}