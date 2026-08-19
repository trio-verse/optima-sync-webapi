<?php

namespace App\Services;

use App\Contracts\FileStorageInterface;
use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrganizationService
{

    public function __construct(private FileStorageInterface $file_storage)
    {
    }

    public function show(int $id)
    {
        Gate::authorize('view', [Organization::class, $id]);

        $org = Organization::with(['members.user', 'user', 'products'])->withCount('clients', 'members')->findOrFail($id);
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
                'description' => $data['description'] ?? null,
                'address' => $data['address'],
                'user_id' => $data['user_id'],
            ]);
            $organization->members()->create([
                'user_id' => $data['user_id'],
                'role' => 'admin'
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
        $org = Organization::findOrFail($organizationId);

        Gate::authorize('addMember', $org);

        return DB::transaction(function () use ($org, $data) {
            $user = User::whereEmail($data['email'])->first();
            if (!$user) {
                $userService = new UserService();
                $user = $userService->createUser(['email' => $data['email']]);
            }
            $member = $org->members()->create(
                [
                    'user_id' => $user->id,
                    'role' => $data['role']
                ]
            );
            return $member->load('user');
        });
    }

    public function updateMemberRole(int $organizationId, int $memberId, array $data): bool
    {
        $org = Organization::findOrFail($organizationId);

        Gate::authorize('updateMemberRole', $org);

        return DB::transaction(function () use ($org, $memberId, $data) {
            $member = $org->members()->findOrFail($memberId);
            return $member->update($data);
        });
    }
    public function getMyOrganizations(User $user): Collection
    {
        Gate::authorize('getMyOrganizations', Organization::class);

        return Organization::forUser($user)->withCount('members')->get();
    }
}
