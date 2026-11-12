<?php

namespace App\Http\Requests\Workspace\Task;

use App\Models\WorksapceModels\Workspace;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignTaskToMemberRequest extends FormRequest
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
        $workspace_id = $this->route('workspace') instanceof (Workspace::class) ? $this->route('workspace')->id : $this->route('workspace');

        return [
            'member_id' => [
                'required',
                'integer',
                Rule::exists('workspace_members', 'member_id')
                    ->where('workspace_id', $workspace_id), 
            ],
        ];
    }
}
