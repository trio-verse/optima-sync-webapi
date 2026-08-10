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
        $tenant = app(TenantManager::class);
        $this->org_id = $tenant->getOrganizationId();
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
        return [
            'name' => ['sometimes', 'string', 'max:255', Rule::unique($this->table_name, 'name')->ignore($this->route($this->model_name)->id)->where('organization_id', $this->org_id)],
            'color' => ['sometimes', 'string']
        ];
    }

}