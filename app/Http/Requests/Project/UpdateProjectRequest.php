<?php

namespace App\Http\Requests\Project;

use App\Enums\enProjectSource;
use App\Enums\enProjectStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reference_id' => ['sometimes', 'string', 'max:100'],
            'client_id' => ['sometimes', 'integer', 'min:1'],
            'status' => ['sometimes', 'string', Rule::in(enProjectStatus::all())],
            'source' => ['sometimes', 'string', Rule::in(enProjectSource::all())],
            'sub_total' => ['sometimes', 'numeric', 'min:0'],
            'profit_percentage' => ['sometimes', 'integer', 'min:0', 'max:100'],
            'total_amount' => ['sometimes', 'numeric', 'min:0'],
            'current_version_id' => ['sometimes', 'nullable', 'integer', 'min:1'],
        ];
    }
}
