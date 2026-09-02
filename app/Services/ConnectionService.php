<?php

namespace App\Services;

use App\Enums\enConnectionStages;
use App\Models\Activity;
use App\Models\Client;
use App\Models\Connection;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class ConnectionService
{

    public function getAllConnections(array $data): LengthAwarePaginator
    {
        try {
            return Connection::with(['client', 'channel', 'assignee', 'product', 'campaign'])
                ->orderBy($data['order'] ?? 'created_at', $data['sort'] ?? 'desc')
                ->paginate($data['per_page'] ?? null);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function getClientConnections(Client $client, array $data): LengthAwarePaginator
    {
        try {
            return $client->connections()
                ->when(isset($data['stage']), fn($query) => $query->byStage($data['stage']))
                ->paginate($data['per_page'] ?? null);

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
                ->paginate($data['per_page'] ?? null);
        } catch (Throwable $th) {
            Log::error('Error getting connection activities: ' . $th->getMessage());
            throw $th;
        }
    }

    public function storeConnection(Client $client, array $data): false|Connection
    {
        try {
            if (isset($data['stage']) && $data['stage'] == enConnectionStages::WIN->value)
                $data['deal_value'] = Product::find((int) $data['product_id'])->price;

            $connection = $client->connections()->create($data);
            return $connection;
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

    public function updateActivity(Activity $activity, array $data): bool
    {
        try {
            $activity->update($data);
            return true;
        } catch (\Exception $exception) {
            Log::error('Error updating activity: ' . $exception->getMessage());
            return false;
        }
    }

    public function deleteActivity(Activity $activity): bool
    {
        try {
            $activity->delete();
            return true;
        } catch (\Exception $exception) {
            Log::error('Error deleting activity: ' . $exception->getMessage());
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

    public function changeStage(Connection $connection, string $stage): bool
    {
        try {
            $wasWon = $connection->stage == enConnectionStages::WIN->value;
            $connection->update(['stage' => $stage]);

            // Freeze a snapshot of the deal value only when transitioning into WIN.
            // Never overwrite it afterward, so later product price changes
            // cannot corrupt the financial record of an already-closed deal.
            if (!$wasWon && $stage === enConnectionStages::WIN->value) {
                $connection->load('product');
                $connection->deal_value = $connection->product?->price;
                $connection->save();
            }
            return true;
        } catch (\Exception $exception) {
            Log::error('Error changing connection stage: ' . $exception->getMessage());
            return false;
        }
    }

    public function deleteConnection(Connection $connection): bool
    {
        $connection->loadCount('activities');
        try {
            $connection->delete();

            if ($connection->activities_count > 0)
                $connection->activities()->delete();
            return true;
        } catch (\Exception $exception) {
            Log::error('Error deleting connection: ' . $exception->getMessage());
            return false;
        }
    }

}
