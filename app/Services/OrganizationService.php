<?php

namespace App\Services;

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
}