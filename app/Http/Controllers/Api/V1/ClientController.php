<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Requests\Client\GetClientsListRequest;
use App\Http\Resources\V1\ClientResource;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(protected ClientService $client_service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetClientsListRequest $request)
    {
        
        // dd($request->input("organization_id"));
        $clients = $this->client_service->getClientsList($request->validated(), (int) $request->input("organization_id"));

        return ApiResponse::pagination(
            ClientResource::collection($clients),
            'Clients list fetched successfully'
        );
    }
    /**
     * create client.
     * 
     * this endpoint create new client
     * response new client
     */
    public function store(StoreClientRequest $request)
    {
        $client = $this->client_service->createClient($request->validated());

        return ApiResponse::success(new ClientResource($client), 'The client was created successfully', 201);
    }

    /**
     * Update client.
     * 
     * this endpoint update client data
     * response updated client data
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $is_updated = $this->client_service->updateClient($request->validated(), $client);
        if ($is_updated) {
            return ApiResponse::success(new ClientResource($client), 'The client was updated successfully', 200);
        } else
            return ApiResponse::error(null, "bad request", 400);
    }
    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
