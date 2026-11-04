<?php

namespace App\Http\Requests\Workspace\Task;

use App\Enums\enTaskPriority;
use App\Enums\enTaskStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class StoreTaskRequest extends FormRequest
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
            'title' => ['string', 'required', 'max:255'],
            'description' => ['string', 'required', 'max:255'],
            'status' => ['string', 'nullable', Rule::in(enTaskStatus::all())],
            'priority' => ['string', 'nullable', Rule::in(enTaskPriority::all())],
            // 'workspace_id' => ['required', 'exists:workspaces,id'],
            'assignee_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
