<?php

namespace App\Http\Requests\Workspace\Task;

use App\Models\OrganizationMember;
use App\Models\WorksapceModels\Workspace;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignTaskToMemberRequest extends FormRequest
{
    private ?Workspace $workspace = null;

    protected function prepareForValidation(): void
    {
        $this->workspace = $this->route('workspace') instanceof (Workspace::class)
            ? $this->route('workspace')
            : Workspace::find($this->route('workspace'));

        $organizationMemberId = OrganizationMember::query()
            ->where('organization_id', $this->workspace?->organization_id)
            ->where('user_id', $this->input('member_id'))
            ->value('id');

        $workspaceMemberId = $this->workspace?->workspaceMembers()
            ->where('organization_member_id', $organizationMemberId)
            ->value('organization_member_id');

        $this->replace([
            ...$this->except('member_id', 'organization_member_id'),
            'organization_member_id' => $workspaceMemberId,
        ]);
    }

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
            'organization_member_id' => [
                'required',
                'integer',
                Rule::exists('workspace_members', 'organization_member_id')
                    ->where('workspace_id', $this->workspace?->id),
            ],
        ];
    }
}
