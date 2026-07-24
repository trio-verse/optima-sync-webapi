<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Contracts\FileStorageInterface;
use App\Helper\V1\ApiResponse;
use App\Http\Requests\Organization\FileUploadRequest;
use App\Http\Resources\V1\OrganizationResource;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Support\Facades\Gate;

class UploadController extends Controller
{
   

    public function __construct(protected OrganizationService $organizationService)
    { }
 /**
     * Upload Organization Logo (Step 2)
     *
     * Upload or update the organization logo after creation.
     *
     * @authenticated
     * @subgroup Organizations
     *
     * @urlParam organization int required The organization ID from Step 1. Example: 5
     *
     * @bodyParam file file required The logo file (max 2MB).
     *
     * @response 200 {
     *   "message": "The organization logo was uploaded successfully",
     *   "data": {
     *     "id": 5,
     *     "name": "Acme Corp",
     *     "logo": "http://localhost/storage/organizations/5/logos/abc123.webp"
     *   }
     * }
     */
    public function upload(FileUploadRequest $request,  Organization $organization)
    {

      try {
            $updatedOrg = $this->organizationService->updateLogo(
                $organization,
                $request->file('file')
            );

            return ApiResponse::response(
                new OrganizationResource($updatedOrg),
                'The organization logo was uploaded successfully',
                200
            );
        } catch (\Exception $e) {
            return ApiResponse::error(null, $e->getMessage(), 500);
        }
    
    }
}
