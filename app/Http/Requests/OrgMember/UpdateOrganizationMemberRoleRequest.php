<?php

namespace App\Http\Requests\OrgMember;


use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationMemberRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Merge the 'id' route parameter into the validation data
        $this->merge(['memberId' => $this->route('memberId')]);
        $this->merge(['organizationId' => $this->route('organizationId')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role' => ['required', 'in:admin,member'],
            'memberId' => 'required|integer|exists:organization_members,id',
            'organizationId' => 'required|integer|equals',
        ];
    }
}
