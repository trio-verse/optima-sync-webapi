<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\FileStorageInterface;
use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\UploadOrganizationLogoRequest;
use App\Models\Organization;

class OrganizationLogoController extends Controller
{

    public function __construct(private FileStorageInterface $storage)
    {
    }

    /**
     * Upload logo to Organization
     *
     * @param UploadOrganizationLogoRequest $request
     * @param Organization $organization
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UploadOrganizationLogoRequest $request, Organization $organization)
    {
        // 1. Delete previous logo if it exists
        if ($organization->logo) {
            $this->storage->delete($organization->logo->file_path);
        }
        // upload
        $logo_path = $this->storage->upload(
            file: $request->file('logo'),
            model: $organization,
            fileType: 'logo',
            directory: 'organizations/logos',
            isSingle: true
        );

        return ApiResponse::success(
            [
                'logo_path' => $logo_path
            ],
            'Organization logo uploaded successfully.'
        );
    }
}
