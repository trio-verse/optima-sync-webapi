<?php

namespace App\Services;

use App\Contracts\FileStorageInterface;
use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OrganizationService
{

    public function __construct(private FileStorageInterface $file_storage)
    {
    }

    public function show(int $id)
    {

        $org = Organization::with(['members.user'])->findOrFail($id);
        return $org;
    }

    public function createOrganization(array $data): Organization
    {

        return DB::transaction(function () use ($data) {
            // dd($data['address']);

            $organization = Organization::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'description' => $data['description'],
                'address' => $data['address'],
                'user_id' => $data['user_id'],
            ]);
            // dd($data);
            return $organization;
        });
    }

    public function updateOrg(int $id, array $data): Organization|false
    {
        // dd($data);
        $org = Organization::findOrFail($id);
        Gate::authorize('update', $org);
        DB::transaction(function () use ($org, $data) {
            $org->fill($data)->saveOrFail();
        });
        return $org;
    }

    public function addMember(int $organizationId, array $data): OrganizationMember|false
    {
        $org = Organization::find($organizationId)->firstOrFail();

        Gate::authorize('addMember', $org);

        return DB::transaction(function () use ($org, $data) {
            $user = User::whereEmail($data['email'])->first();
            if (!$user) {
                $userService = new UserService();
                $user = $userService->createUser($data['email']);
            }
            return $org->members()->create(
                [
                    'user_id' => $user->id,
                    'role' => $data['role']
                ]
            );
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
    public function getMyOrganizations(User $user): Collection
    {
        Gate::authorize('getMyOrganizations', Organization::class);
        return $user->organizations()->get();
    }
}
