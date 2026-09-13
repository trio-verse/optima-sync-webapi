<?php

namespace App\Http\Requests\Project\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'total_points' => ['required', 'integer', 'min:0'],
        ];
    }
}
