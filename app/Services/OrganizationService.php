<?php

namespace App\Services;

use App\Contracts\FileStorageInterface;
use App\Helper\V1\ApiResponse;
use App\Models\Organization;
use App\Policies\OrganizationPolicy;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OrganizationService
{
    private FileStorageInterface $file_storage;

    public function __construct(FileStorageInterface $file_storage)
    {
        $this->file_storage = $file_storage;
    }

    public function createOrganization(array $data, ?UploadedFile $logoFile = null): Organization
    {
        return DB::transaction(function () use ($data, $logoFile) {

            if ($logoFile) {
                $data['logo'] = $this->file_storage->storeImageAsWebp($logoFile, 'logos');
            }
            return Organization::create($data);
        });
    }

    public function updateOrg(int $id, array $data, ?UploadedFile $logoFile = null): Organization|false
    {
        $org = Organization::find($id)->firstOrFail();

        Gate::authorize('update', $org);

        DB::transaction(function () use ($org, $data, $logoFile) {
            if ($logoFile) {
                $newLogoPath = $this->file_storage->storeImageAsWebp($logoFile, 'logos');
                $data['logo'] = $newLogoPath;

                if ($org->logo) {
                    $this->file_storage->delete($org->logo);
                }
            }
            $org->update($data);
        });

        return $org;
    }
}
