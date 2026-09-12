<?php

namespace App\Http\Requests\Employee;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('employees', 'email')->ignore($this->route('employee'))],
            'phone' => ['sometimes', 'string', 'max:20', Rule::unique('employees', 'phone')->ignore($this->route('employee'))],
            'position' => ['sometimes', 'string', 'max:255'],
            'cost_per_hour' => ['sometimes', 'numeric', 'min:0'],
            'houres_per_point' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
