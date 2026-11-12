<?php

namespace App\Http\Requests\Workspace\Task;

use App\Enums\Workspace\enTaskPriority;
use App\Enums\Workspace\enTaskStatus;
use App\Models\WorksapceModels\Workspace;
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
        $workspace = $this->route('workspace') instanceof(Workspace::class) ? $this->route('workspace') : Workspace::find($this->route('workspace'));

        return [
            'title' => ['string', 'required', 'max:255'],
            'description' => ['string', 'required', 'max:255'],
            'status' => ['string', 'nullable', Rule::in(enTaskStatus::all())],
            'priority' => ['string', 'nullable', Rule::in(enTaskPriority::all())],
            // 'workspace_id' => ['required', 'exists:workspaces,id'],
            'member_id' => [
                'nullable',
                'integer',
                Rule::exists('workspace_members', 'member_id')
                    ->where('workspace_id', $workspace?->id),
            ],
        ];
    }
}
