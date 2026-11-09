<?php

namespace App\Http\Requests\Workspace\Members;

use App\Models\WorksapceModels\Workspace;
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
        $workspace = $this->route('workspace') instanceof(Workspace::class) ? $this->route('workspace') : Workspace::find($this->route('workspace'));
        return [
            'member_id' => [
                'required',
                'integer',
                'exists:users,id',
                'not_in:' . $workspace?->members()->pluck('users.id')->implode(','),
                new AcceptedOrganizationMember,
            ],
        ];
    }
}
