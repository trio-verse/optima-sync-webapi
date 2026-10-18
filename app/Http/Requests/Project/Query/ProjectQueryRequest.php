<?php

namespace App\Http\Requests\Project\Query;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProjectQueryRequest extends FormRequest
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
            'query' => [
                'required',
                'array',
            ],

            'query.logic' => [
                'required',
                'string',
                'in:and,or',
            ],

            'query.conditions' => [
                'present',
                'array',
                'max:50',
            ],

            'query.conditions.*' => [
                'array',
            ],

            'metrics' => [
                'nullable',
                'array',
            ],

            'metrics.*' => [
                'string',
            ],

            'charts' => [
                'nullable',
                'array',
            ],

            'charts.*' => [
                'string',
            ],

            'page' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ];
    }

    /**
     * Validate leaf conditions and nested condition groups recursively.
     */
    protected function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $conditions = $this->input('query.conditions');

            if (! is_array($conditions)) {
                return;
            }

            foreach ($conditions as $index => $condition) {
                if (is_array($condition)) {
                    $this->validateQueryNode(
                        $condition,
                        "query.conditions.{$index}",
                        $validator
                    );
                }
            }
        });
    }

    /**
     * A query node is either a leaf condition or a nested logic group.
     */
    private function validateQueryNode(
        array $node,
        string $path,
        Validator $validator
    ): void {
        if (
            array_key_exists('field', $node)
            || (! array_key_exists('logic', $node) && ! array_key_exists('conditions', $node))
        ) {
            if (! isset($node['field']) || $node['field'] === '') {
                $validator->errors()->add(
                    "{$path}.field",
                    "The {$path}.field field is required when {$path} is present."
                );
            } elseif (! is_string($node['field'])) {
                $validator->errors()->add(
                    "{$path}.field",
                    "The {$path}.field field must be a string."
                );
            }

            if (! isset($node['operator']) || $node['operator'] === '') {
                $validator->errors()->add(
                    "{$path}.operator",
                    "The {$path}.operator field is required when {$path} is present."
                );
            } elseif (! is_string($node['operator'])) {
                $validator->errors()->add(
                    "{$path}.operator",
                    "The {$path}.operator field must be a string."
                );
            }

            if (! array_key_exists('value', $node)) {
                $validator->errors()->add(
                    "{$path}.value",
                    "The {$path}.value field must be present."
                );
            }

            return;
        }

        if (! isset($node['logic']) || $node['logic'] === '') {
            $validator->errors()->add(
                "{$path}.logic",
                "The {$path}.logic field is required when {$path} is present."
            );
        } elseif (! is_string($node['logic']) || ! in_array($node['logic'], ['and', 'or'], true)) {
            $validator->errors()->add(
                "{$path}.logic",
                "The {$path}.logic field must be either and or or."
            );
        }

        if (! array_key_exists('conditions', $node)) {
            $validator->errors()->add(
                "{$path}.conditions",
                "The {$path}.conditions field must be present."
            );

            return;
        }

        if (! is_array($node['conditions'])) {
            $validator->errors()->add(
                "{$path}.conditions",
                "The {$path}.conditions field must be an array."
            );

            return;
        }

        if (count($node['conditions']) > 50) {
            $validator->errors()->add(
                "{$path}.conditions",
                "The {$path}.conditions may not have more than 50 items."
            );
        }

        foreach ($node['conditions'] as $index => $child) {
            if (! is_array($child)) {
                $validator->errors()->add(
                    "{$path}.conditions.{$index}",
                    "The {$path}.conditions.{$index} must be an array."
                );

                continue;
            }

            $this->validateQueryNode(
                $child,
                "{$path}.conditions.{$index}",
                $validator
            );
        }
    }
}
