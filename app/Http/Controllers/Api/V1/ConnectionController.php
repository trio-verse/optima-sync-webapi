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
use Illuminate\Support\Facades\Gate;

class ConnectionController extends Controller
{

    public function __construct(private ConnectionService $connectionService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', [Connection::class, $request->organization_id]);

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
        Gate::authorize('create', [Connection::class, $client->id]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConnectionRequest $request, Connection $connection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Connection $connection)
    {
        //
    }

    public function getClientConnections(Request $request , Client $client){
        Gate::authorize('viewAny', [Connection::class, $client->id]);
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
