<?php

namespace App\Http\Requests\connections;

use App\Enums\enConnectionStages;
use App\Rules\CheckConnectionStatusRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreConnectionRequest extends FormRequest
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
            'organization_id' => ['required', 'exists:organizations,id'],
            // "client_id" => ['required', 'exists:clients,id'],
            "product_id" => ['required', 'exists:products,id' , new CheckConnectionStatusRule( $this->client->id , $this->product_id)],
            'stage' => ['required', Rule::in(enConnectionStages::all())],
            'channel_id' => ['nullable', 'exists:channels,id'],
            'assignee_id' => ['nullable', 'exists:users,id'],
            'initiated_by' => ['string', 'nullable']
        ];
    }
}
