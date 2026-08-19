<?php

namespace App\Http\Requests\Content;

use App\Enums\enContentStatus;
use App\Models\Campaign;
use App\Models\Content;
use App\Singleton\TenantManager;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class StoreContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $campaign = $this->route('campaign');
        return $this->user()->can('create', [Content::class, $campaign]);
    }
    #[Override]
    public function prepareForValidation()
    {
        $this->merge([
            'campaign_id' => (int) $this->route('campaign'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'campaign_id' => ['required', 'exists:campaigns,id'],
            'channel_id' => ['required', 'exists:channels,id'],
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('contents')->where(function ($query) {
                    return $query->where('organization_id', app(TenantManager::class)->getOrganizationId());
                })
            ],
            'type' => ['required', 'string', 'max:255'],
            'script' => ['required', 'string'],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'string', Rule::in(enContentStatus::all())],
            'published_at' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the campaign from the route.
     */
    public function campaign(): Campaign
    {
        return $this->route('campaign');
    }
}
