<?php

namespace App\Http\Requests\Channel;

use App\Http\Requests\BaseTagsRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreChannelRequest extends BaseTagsRequest
{

    public function __construct()
    {
        $this->table_name = 'channels';
        $this->model_name = 'channel';
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
