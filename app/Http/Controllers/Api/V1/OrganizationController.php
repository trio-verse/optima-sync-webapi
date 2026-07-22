<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Http\Resources\V1\OrganizationResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Gate;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;

class OrganizationController extends Controller
{
    public function __construct(private OrganizationService $organizationservice) {}
    /**
     * create organization
     * 
     * this endpoint create new organization  
     * response new organization 
     */
    public function store(StoreOrganizationRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->safe()->except(['logo']);

            $validatedData['user_id'] = $request->user()->id;

            $logoFile = $request->file('logo');

            $organization  = $this->organizationservice->createOrganization($validatedData, $logoFile);
            return ApiResponse::response(new OrganizationResource($organization), 'The organization was created succsesfully', 201);
        } catch (\Exception $e) {
            return ApiResponse::error(null, "server error", 500);
        }
    }

    /**
     * Update organization
     * 
     * this endpoint update organization data 
     * response updated organization data
     */
    public function update(UpdateOrganizationRequest $request, int $id): JsonResponse
    {
        try {
            $validatedData = $request->safe()->except(['logo']);

            $validatedData['user_id'] = $request->user()->id;

            $logoFile = $request->file('logo');

            $organization = $this->organizationservice->updateOrg($id, $validatedData, $logoFile);
            return ApiResponse::response(new OrganizationResource($organization), 'The organization was updated succsesfully', 200);
        } catch (RecordNotFoundException $e) {
            return ApiResponse::error(null, "organization not found", 404);
        } catch (AuthorizationException $e) {
            return ApiResponse::error(null, "Not allowed", 403);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(null, "server error", 500);
        }
    }
}
