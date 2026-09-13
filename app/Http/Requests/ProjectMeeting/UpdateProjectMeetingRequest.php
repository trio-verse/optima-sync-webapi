<?php

namespace App\Http\Requests\ProjectMeeting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectMeetingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'meeting_date' => ['sometimes', 'date'],
            'meeting_url' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'stakeholders' => ['nullable', 'array'],
            'stakeholders.*' => ['nullable'],
            'team_members' => ['nullable', 'array'],
            'team_members.*' => ['nullable'],
        ];
    }
}
