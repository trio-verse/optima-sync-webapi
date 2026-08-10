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

    public function __construct()
    {
        $this->table_name = 'cities';
        $this->model_name = 'city';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->storeRequest();
    }
}
