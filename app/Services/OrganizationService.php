<?php

namespace App\Services;

use App\Helper\V1\ApiResponse;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

class OrganizationService{
    public function createOrganization(array $data): Organization
    {
       return DB::transaction(function() use ($data) {
        $organization = Organization::create([
              'name'        => $data['name'],
              'email'       =>$data['email'],
              'phone'       =>$data['phone'],
              'description' => $data['description'] ?? null,
              'address'     => $data['address'],
        ]);
        return $organization;
       } );
    }

    public function updateOrg(int $id , array $data) : Organization|false{
        $org = Organization::find($id)->firstOrFail();

        DB::transaction(function() use ($org , $data) {
            $org->update($data);
        });

        return $org ;
    }
}
