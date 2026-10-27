<?php

namespace App\Http\Requests\Project;

use App\Singleton\TenantManager;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestProjectRequest extends FormRequest
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
            // client info
            'name' => ['required' , 'string'],
            'phone' => ['required', 'string', 'regex:/^(\+\d{1,2}\s?)?1?\-?\.?\s?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/', 'max:14'],
            'email' => ['nullable', 'email', 'max:255'],
            'city_id' => ['required', 'integer', Rule::exists('cities' , 'id')->where('organization_id', app(TenantManager::class)->getOrganizationId())],
            'industry_id' => ['required', 'integer', Rule::exists('industries' , 'id')->where('organization_id', app(TenantManager::class)->getOrganizationId())],

            // project info
            'title' => ['required' , 'string'],
            'description' => ['required' , 'string' , 'max:255'],
            'attachments' => ['array' , 'sometimes']
        ];
    }
}
