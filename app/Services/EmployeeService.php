<?php

namespace App\Services;

use App\Models\Employee;
use App\Singleton\TenantManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EmployeeService
{
    public function getAllEmployees(): Collection
    {
        return Employee::latest()->get();
    }

    public function create(array $data): Employee
    {
        $tenant = app(TenantManager::class);
        if ($tenant->hasOrganizationId() && empty($data['organization_id'])) {
            $data['organization_id'] = $tenant->getOrganizationId();
        }

        return DB::transaction(function () use ($data) {
            return Employee::create($data);
        });
    }

    public function show(Employee $employee): Employee
    {
        return $employee->fresh();
    }

    public function update(Employee $employee, array $data): Employee
    {
        return DB::transaction(function () use ($employee, $data) {
            $employee->update($data);

            return $employee->fresh();
        });
    }

    public function delete(Employee $employee): bool
    {
        return DB::transaction(function () use ($employee) {
            return (bool) $employee->delete();
        });
    }
}
