<?php

namespace App\Http\Requests\Campaign;

use App\Enums\enCampaignStatus;
use App\Singleton\TenantManager;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        if($this->has('end_date')&& ! $this->has('start_date')){
            $this->merge([
                'start_date' => now()->format('Y-m-d')
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required', 'max:255' , Rule::unique('campaigns')->where('organization_id' , app(TenantManager::class)->getOrganizationId())],
            'description' => ['string', 'required', 'max:255'],
            'start_date' => ['date_format:Y-m-d', 'nullable'],
            'end_date' => ['date_format:Y-m-d', 'nullable', 'after:start_date'],
            'expected_budget' => ['numeric', 'nullable', 'min:0'],
            'estimated_content_count' => ['integer', 'nullable', 'min:0'],
            'status' => ['string', 'nullable', Rule::in(enCampaignStatus::all())],
            'target' => ['string', 'required'],
        ];
    }
}
