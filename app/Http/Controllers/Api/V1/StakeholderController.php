<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Stakeholder\StoreStakeholderRequest;
use App\Http\Requests\Stakeholder\UpdateStakeholderRequest;
// use App\Http\Resources\StakeholderResource;
use App\Http\Resources\V1\StakeholderResource;
use App\Models\Client;
use App\Models\Stakeholder;
use App\Services\StakeholderService;
use Illuminate\Http\Request;

/**
 * @group Stakeholder
 */
class StakeholderController extends Controller
{
    public function __construct(protected StakeholderService $stakeholder_service) {}

    /**
     * Display all Stakeholders.
     * 
     * this endpoint display all Stakeholder from DB
     * response get all Stakeholder
     */
    public function index(Client $client)
    {
        $stakeholder = $this->stakeholder_service->getClientStakeholders($client);
        return ApiResponse::success(StakeholderResource::collection($stakeholder), 'Stakeholders fetched successfully');
    }



    /**
     * create Stakeholder.
     * 
     * this endpoint create new Stakeholder
     * response new Stakeholder
     */
    public function store(StoreStakeholderRequest $request, Client $client)
    {

        $stakeholder = $this->stakeholder_service->createStakeholder($client, $request->validated());

        return ApiResponse::response(new StakeholderResource($stakeholder), 'The Stakeholder was created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Stakeholder $stakeholder)
    {
        //
    }

    /**
     * Update Stakeholder.
     * 
     * this endpoint update Stakeholder data
     * response updated Stakeholder data
     */
    public function update(UpdateStakeholderRequest $request, Client $client,  Stakeholder $stakeholder)
    {
        $is_updated = $this->stakeholder_service->updateStakeholder($client, $stakeholder, $request->validated());
        if ($is_updated) {
            return ApiResponse::response(new StakeholderResource($stakeholder), 'The Stakeholder was updated successfully', 200);
        } else   return ApiResponse::error(null, "bad request", 400);
    }

    /**
     * Delete Stakeholder.
     * 
     * this endpoint delete Stakeholder data from DB
     * response remove the specified Stakeholder from DB
     */
    public function destroy(Client $client, Stakeholder $stakeholder)
    {
        $isDeleted = $this->stakeholder_service->deleteStakeholder($client, $stakeholder);
        if (!$isDeleted) {
            return ApiResponse::error([], 'deleting fail', 500);
        }

        return ApiResponse::success(
            [],
            'Stakeholder deleted successfully',
            200
        );
    }
}
