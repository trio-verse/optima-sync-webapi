<?php

namespace App\Http\Requests;

use App\Singleton\TenantManager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BaseTagsRequest extends FormRequest
{

    private null|int $org_id = null;
    protected $table_name = '';
    protected $model_name = '';

    public function prepareForValidation()
    {
        if (app()->bound(TenantManager::class)) {
            $tenant = app(TenantManager::class);
            $this->org_id = $tenant->getOrganizationId();
        }
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->storeRequest();
    }

    /**
     * Get body parameters for Scribe documentation.
     *
     * @return array
     */
    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'The name of the item',
                'required' => true,
                'example' => 'Sample Name'
            ],
            'color' => [
                'description' => 'The color associated with the item',
                'required' => true,
                'example' => '#FF0000'
            ]
        ];
    }

    /**
     *  Get the validation rules that apply to the Store (city , industry , channel).
     * @return array{color: string, name: array<string|\Illuminate\Validation\Rules\Unique>}
     */
    public function storeRequest(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique($this->table_name, 'name')->where('organization_id', $this->org_id)],
            'color' => ['required', 'string']
        ];
    }

    /**
     *  Get the validation rules that apply to the update (city , industry , channel).
     * @return array{color: string[], name: array<string|\Illuminate\Validation\Rules\Unique>}
     */
    public function updateRequest(): array
    {
        // Safely retrieve the model or ID from the route parameter
        $model = $this->route($this->model_name);

        // If route parameter is a Model instance, get ->id. If it's already an ID/string, use it directly.
        $modelId = is_object($model) ? $model->id : $model;

        return [
            'name' => ['sometimes', 'string', 'max:255', Rule::unique($this->table_name, 'name')->ignore($modelId)->where('organization_id', $this->org_id)],
            'color' => ['sometimes', 'string']
        ];
    }

}