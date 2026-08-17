<?php

namespace App\Http\Requests\Client;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetClientsListRequest extends FormRequest
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
            // 'organization_id' => ['required' , "exists:organizations,id"],
            'search' => ['nullable', 'array'],
            'search.name' => ['nullable', 'string', 'max:255'],
            'search.contact_info' => ['nullable', 'string', 'max:255'],

            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'industry_id' => ['nullable', 'integer', 'exists:industries,id'],
            'client_type' => ['nullable', 'string'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
