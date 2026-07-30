<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\GetClientsListRequest;
use App\Http\Resources\V1\ClientResource;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private ClientService $client_service;
    public function __construct(ClientService $client_service)
    {
        $this->client_service = $client_service;
    }
    /**
     * Display a listing of Clients
     * @param GetClientsListRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GetClientsListRequest $request)
    {
        $clients = $this->client_service->getClientsList($request->validated());

        return ApiResponse::success(
            ClientResource::collection($clients),
            'Clients list fetched successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
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
