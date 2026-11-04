<?php

namespace App\Http\Requests\Workspace;

use App\Enums\enWorkspaceStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexWorkspaceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['sometimes', 'string', Rule::in(enWorkspaceStatus::all())],
            'search' => ['sometimes', 'string', 'max:255'],
            'deadline_from' => ['sometimes', 'date'],
            'deadline_to' => ['sometimes', 'date', 'after_or_equal:deadline_from'],
            'sort' => ['sometimes', 'string', Rule::in(['created_at', 'name', 'deadline'])],
            'direction' => ['sometimes', 'string', Rule::in(['asc', 'desc'])],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }
}
