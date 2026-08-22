<?php

namespace App\Services;

use App\Enums\enConnectionStages;
use App\Models\Activity;
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
            Log::error('Error getting client connections: ' . $th->getMessage());
            throw $th;
        }
    }

    public function getConnectionActivities(Connection $connection, array $data): LengthAwarePaginator
    {
        try {
            return $connection->activities()
                ->with(['user'])
                ->latest()
                ->paginate($data['per_page'] ?? 20);
        } catch (Throwable $th) {
            Log::error('Error getting connection activities: ' . $th->getMessage());
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

    public function storeActivity(Connection $connection, array $data): bool
    {
        try {
            // Set organization_id from the connection
            $data['organization_id'] = $connection->client->organization_id;
            $connection->activities()->create($data);
            return true;
        } catch (\Exception $exception) {
            Log::error('Error storing activity: ' . $exception->getMessage());
            return false;
        }
    }

    public function updateConnection(Connection $connection, array $data): bool
    {
        try {
            $wasWon = $connection->stage == enConnectionStages::WIN->value;
            $connection->update($data);

            // Freeze a snapshot of the deal value only when transitioning into WIN.
            // Never overwrite it afterward, so later product price changes
            // cannot corrupt the financial record of an already-closed deal.
            if (!$wasWon && isset($data['stage']) && $data['stage'] == enConnectionStages::WIN->value) {
                $connection->load('product');
                $connection->deal_value = $connection->product->price;
                $connection->save();
            }
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
