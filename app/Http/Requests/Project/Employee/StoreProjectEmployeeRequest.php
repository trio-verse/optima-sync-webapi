<?php

namespace App\Http\Requests\Project\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'total_points' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Employee selection is required.',
            'employee_id.exists' => 'Selected employee does not exist.',
            'total_points.required' => 'Total points for the employee is required.',
        ];
    }
}
