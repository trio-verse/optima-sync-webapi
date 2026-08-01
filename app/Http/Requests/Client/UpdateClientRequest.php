<?php

namespace App\Http\Requests\Client;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
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
            'organization_id' => ['sometimes', 'integer', 'exists:organizations,id'],
            'name' => ['sometimes', 'string', 'max:255'],
            'client_type' => [
                'sometimes',
                'string',
                Rule::in(['company', 'individual', 'government', 'charity', 'agency'])
            ],
            'industry_id' => ['sometimes', 'integer', 'exists:industries,id'],
            'city_id' => ['sometimes', 'integer', 'exists:cities,id'],

            'phone' => ['sometimes', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
