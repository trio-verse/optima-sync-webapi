<?php

namespace App\Http\Requests\Workspace\Members;

use App\Rules\AcceptedOrganizationMember;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkspaceMemberRequest extends FormRequest
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
            'member_id' => [
                'required',
                'integer',
                'exists:users,id',
                new AcceptedOrganizationMember,
                // Ensure the member is not already part of the workspace
                Rule::unique('workspace_members', 'member_id')
                    ->where('workspace_id', $this->route('workspace')->id),
            ],
        ];
    }
}
