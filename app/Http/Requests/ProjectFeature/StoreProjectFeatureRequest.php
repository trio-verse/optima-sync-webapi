<?php

namespace App\Http\Requests\ProjectFeature;

use App\Enums\enProjectFeatureStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectFeatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['sometimes', 'string', Rule::in(enProjectFeatureStatus::all())],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Feature name is required',
        ];
    }
}
