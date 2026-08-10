<?php

namespace App\Http\Requests\City;

use App\Http\Requests\BaseTagsRequest;
use App\Singleton\TenantManager;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class StoreCityRequest extends BaseTagsRequest
{
    protected $table_name = 'cities';
    protected $model_name = 'city';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
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
                'description' => 'The name of the city',
                'required' => true,
                'example' => 'New York'
            ],
            'color' => [
                'description' => 'The color associated with the city',
                'required' => true,
                'example' => '#FF5733'
            ]
        ];
    }
}
