<?php

namespace App\Http\Requests\Project;

use App\Enums\enProjectSource;
use App\Enums\enProjectStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'integer', 'min:1'],
            'status' => ['sometimes', 'string', Rule::in(enProjectStatus::all())],
            'source' => ['required', 'string', Rule::in(enProjectSource::all())],
            'sub_total' => ['sometimes', 'numeric', 'min:0'],
            'profit_percentage' => ['sometimes', 'integer', 'min:0', 'max:100'],
            'total_amount' => ['sometimes', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => 'Client is required',
            'source.required' => 'Source is required',
        ];
    }
}
