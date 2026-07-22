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
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $organizationId = $this->route('id');
        return [
            'name' => ['sometimes', 'string', 'min:3', 'max:255'],
            'email' => ['sometimes', 'email', Rule::unique('organizations', 'email')->ignore($organizationId)],
            'phone' => ['sometimes', 'string', 'regex:/^\+?[0-9\s\-\(\)]{7,20}$/', Rule::unique('organizations', 'phone')->ignore($organizationId)],
            'description' => ['nullable', 'string', 'min:10', 'max:500'],
            'address' => ['sometimes', 'string', 'min:5', 'max:255'],
            'logo'        => ['sometimes', 'nullable', 'image', 'mimes:webp', 'max:2048'],
        ];
    }
}
