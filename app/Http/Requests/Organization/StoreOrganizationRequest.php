<?php

namespace App\Http\Requests\Organization;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class StoreOrganizationRequest extends FormRequest
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
            'name'        => ['required', 'string', 'min:3', 'max:255'],
            'email'       => ['required', 'email', Rule::unique('organizations', 'email')],
            'phone'       => ['required', 'string', 'regex:/^\+?[0-9\s\-\(\)]{7,20}$/' ,  Rule::unique('organizations', 'phone')],
            'description' => ['nullable', 'string', 'min:10', 'max:500'],
            'address'     => ['required', 'string', 'min:5', 'max:255'],
        ];
    }
}
