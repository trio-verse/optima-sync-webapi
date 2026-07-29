<?php

namespace App\Http\Requests\Organization;

use App\Models\Organization;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrganizationRequest extends FormRequest
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
        $organization = $this->route('organization') ?? $this->route('id');
        $id = $organization instanceof Organization ? $organization->getKey() : $organization;
        return [
            'name' => ['sometimes', 'string', 'min:3', 'max:255'],
            'email' => ['sometimes', 'email', Rule::unique('organizations', 'email')->ignore($id, 'id')],
            'phone' => ['sometimes', 'string', 'regex:/^\+?[0-9\s\-\(\)]{7,20}$/', Rule::unique('organizations', 'phone')->ignore($id, 'id')],
            'description' => ['nullable', 'string', 'min:10', 'max:500'],
            'address' => ['sometimes', 'string', 'min:5', 'max:255'],
        ];
    }
}
