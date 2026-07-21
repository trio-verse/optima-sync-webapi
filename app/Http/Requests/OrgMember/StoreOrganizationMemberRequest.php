<?php

namespace App\Http\Requests\OrgMember;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationMemberRequest extends FormRequest
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
            // 'organization_id' => ['required', 'exists:organizations,id'],
            'user_id' => ['required', 'exists:users,id'],
            'role' => ['required', 'in:admin,member'],
        ];
    }
}
