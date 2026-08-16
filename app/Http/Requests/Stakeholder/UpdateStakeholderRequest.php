<?php

namespace App\Http\Requests\Stakeholder;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStakeholderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'regex:/^\+?[0-9\s\-\(\)]{7,20}$/', 'max:50'],
            'role'  => ['nullable', 'string', 'max:255'],
        ];
    }
}
