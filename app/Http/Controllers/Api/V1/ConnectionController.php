<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\StoreActivityRequest;
use App\Http\Requests\Connections\StoreConnectionRequest;
use App\Http\Requests\Connections\UpdateConnectionRequest;
use App\Http\Resources\V1\ActivityResource;
use App\Http\Resources\V1\ConnectionResource;
use App\Models\Client;
use App\Models\Connection;
use App\Services\ConnectionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

/**
 * @group Connections
 */
class ConnectionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private ConnectionService $connectionService)
    {
    }
    /**
     * Get all Connections.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Connection::class);

        $validated = $request->only([
            'per_page',
            'page',
            'sort',
            'order',
        ]);
        $connections = $this->connectionService->getAllConnections($validated);
        return ApiResponse::pagination(ConnectionResource::collection($connections), "Connections retrieved successfully", 200);
    }

    /**
     * Store new Connection.
     */
    public function store(StoreConnectionRequest $request, Client $client)
    {
        $this->authorize('create', [Connection::class, $client]);

        $validated = $request->validated();
        if ($this->connectionService->storeConnection($client, $validated)) {
            return ApiResponse::success([], "Connection created successfully", 201);
        } else {
            return ApiResponse::error(null, "Failed to create connection", 500);
        }
    }

    /**
     * show Connection.
     */
    public function show(Connection $connection)
    {
        $this->authorize('view', [Connection::class, $connection]);

        return ApiResponse::success(new ConnectionResource($connection), "Connection retrieved successfully", 200);
    }

    /**
     * Update Connection.
     */
    public function update(UpdateConnectionRequest $request, Connection $connection)
    {
        $this->authorize('update', $connection);

        $validated = $request->validated();

        if ($this->connectionService->updateConnection($connection, $validated)) {
            return ApiResponse::success(new ConnectionResource($connection->fresh()), "Connection updated successfully", 200);
        } else {
            return ApiResponse::error(null, "Failed to update connection", 500);
        }
    }

    /**
     * Remove Connection.
     */
    public function destroy(Connection $connection)
    {
        $this->authorize('delete', $connection);

        if ($this->connectionService->deleteConnection($connection)) {
            return ApiResponse::success([], "Connection deleted successfully", 200);
        } else {
            return ApiResponse::error(null, "Failed to delete connection", 500);
        }
    }

    /**
     * get client connections
     * @param Request $request
     * @param Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function getClientConnections(Request $request, Client $client)
    {
        // Verify user has access to this client's organization
        $this->authorize('view', [Client::class, $client]);

        $validated = $request->only([
            'per_page',
            'page',
            'sort',
            'order',
        ]);
        $connections = $this->connectionService->getClientConnections($client, $validated);
        return ApiResponse::pagination(ConnectionResource::collection($connections), "Client Connections retrieved successfully", 200);
    }

    /**
     * Get activities for a connection
     *
     * Retrieve all activities/updates for a specific connection
     */
    public function getActivities(Request $request, Connection $connection)
    {
        $this->authorize('view', $connection);

        $validated = $request->only([
            'per_page',
            'page',
        ]);
        $activities = $this->connectionService->getConnectionActivities($connection, $validated);
        return ApiResponse::pagination(ActivityResource::collection($activities), "Connection activities retrieved successfully", 200);
    }

    /**
     * Add activity to a connection
     *
     * Create a new activity/update for a connection
     */
    public function storeActivity(StoreActivityRequest $request, Connection $connection)
    {
        $this->authorize('update', $connection);

        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($this->connectionService->storeActivity($connection, $data)) {
            return ApiResponse::success([], "Activity added successfully", 201);
        } else {
            return ApiResponse::error(null, "Failed to add activity", 500);
        }
    }
}
