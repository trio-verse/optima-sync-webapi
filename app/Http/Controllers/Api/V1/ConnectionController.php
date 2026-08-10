<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\connections\StoreConnectionRequest;
use App\Http\Requests\connections\UpdateConnectionRequest;
use App\Http\Resources\V1\ConnectionResource;
use App\Models\Client;
use App\Models\Connection;
use App\Services\ConnectionService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ConnectionController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private ConnectionService $connectionService)
    {
    }
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(Connection $connection)
    {
        $this->authorize('view', [Connection::class, $connection]);

        return ApiResponse::success(new ConnectionResource($connection), "Connection retrieved successfully", 200);
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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

    public function getClientConnections(Request $request, Client $client)
    {
        // Verify user has access to this client's organization
        $this->authorize('view', [Client::class , $client]);

        $validated = $request->only([
            'per_page',
            'page',
            'sort',
            'order',
        ]);
        $connections = $this->connectionService->getClientConnections($client, $validated);
        return ApiResponse::pagination(ConnectionResource::collection($connections), "Client Connections retrieved successfully", 200);
    }
}
