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


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required', 'max:255'],
            'description' => ['string', 'required', 'max:255'],
            'start_date' => ['date', 'nullable'],
            'end_date' => ['date', 'nullable', 'after:start_date'],
            'expected_budget' => ['numeric', 'nullable', 'min:0'],
            'estimated_content_count' => ['integer', 'nullable', 'min:0'],
            'status' => ['string', 'nullable', Rule::in(enCampaignStatus::all())],
            'target' => ['string', 'required'],
        ];
    }
}
