<?php

namespace App\Services;

use App\Contracts\FileStorageInterface;
use App\Helper\V1\ApiResponse;
use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Policies\OrganizationPolicy;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class OrganizationService
{

    public function __construct(private FileStorageInterface $file_storage)
    {
    }

    public function createOrganization(array $data): Organization
    {
        return DB::transaction(function () use ($data) {
            $organization = Organization::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'description' => $data['description'] ?? null,
                'address' => $data['address'],
                'user_id' => request()->user()->id,
            ]);
            return $organization;
        });
    }

    public function updateOrg(int $id, array $data): Organization|false
    {
        $org = Organization::findOrFail($id);
        Gate::authorize('update', $org);
        DB::transaction(function () use ($org, $data ) {
            $org->update($data);
        });
        return $org;
    }

    public function addMember(int $organizationId, array $data): OrganizationMember|false
    {
        $org = Organization::find($organizationId)->firstOrFail();

        Gate::authorize('addMember', $org);

        return DB::transaction(function () use ($org, $data) {
            return $org->members()->create($data);
        });
    }

    public function updateMemberRole(int $organizationId, int $memberId, array $data): OrganizationMember|false
    {
        $org = Organization::find($organizationId)->firstOrFail();

        Gate::authorize('updateMemberRole', $org);

        return DB::transaction(function () use ($org, $memberId, $data) {
            $member = $org->members()->findOrFail($memberId);
            $member->update($data);
            return $member;
        });
    }
}
