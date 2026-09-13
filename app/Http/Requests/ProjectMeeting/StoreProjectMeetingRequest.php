<?php

namespace App\Http\Requests\ProjectMeeting;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectMeetingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'meeting_date' => ['required', 'date'],
            'meeting_url' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'stakeholders' => ['nullable', 'array'],
            'stakeholders.*' => ['nullable'],
            'team_members' => ['nullable', 'array'],
            'team_members.*' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Meeting title is required.',
            'meeting_date.required' => 'Meeting date and time is required.',
            'meeting_date.date' => 'Meeting date must be a valid date/time format.',
        ];
    }
}
