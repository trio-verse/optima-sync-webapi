<?php

namespace App\Http\Requests\Workspace\Task;

use App\Enums\enTaskPriority;
use App\Enums\enTaskStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'title' => ['string', 'nullable', 'max:255'],
            'description' => ['string', 'nullable', 'max:255'],
            'workspace_id' => ['nullable', 'exists:workspaces,id'],
            'assignee_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
