<?php

namespace App\Http\Requests\Employee;

use App\Singleton\TenantManager;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('employees', 'email')->where('organization_id', app(TenantManager::class)->getOrganizationId())],
            'phone' => ['required', 'string', 'max:20' /*, Rule::unique('employees', 'phone')*/],
            'position' => ['required', 'string', 'max:255'],
            'cost_per_hour' => ['required', 'numeric', 'min:0'],
            'houres_per_point' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
