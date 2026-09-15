<?php

namespace App\Http\Requests\Connections;

use App\Singleton\TenantManager;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateConnectionRequest extends FormRequest
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
            'channel_id' => ['string', 'sometimes', Rule::exists('channels' , 'id')->where('organization_id', app(TenantManager::class)->getOrganizationId())],
            'assignee_id' => ['string', 'sometimes', 'exists:users,id'],
            'initiated_by' => ['string', 'nullable'],
            'campaign_id' => ['nullable', 'exists:campaigns,id'],
            'product_id' => ['nullable', Rule::exists('products' , 'id')->where('organization_id' , app(TenantManager::class)->getOrganizationId())],
        ];
    }
}
