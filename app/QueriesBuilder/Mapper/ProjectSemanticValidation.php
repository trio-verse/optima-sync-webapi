<?php

namespace App\QueriesBuilder\Mapper;

use App\QueriesBuilder\Dtos\QueryCondition;
use App\QueriesBuilder\Dtos\QueryDefinition;
use App\QueriesBuilder\Dtos\QueryGroup;
use App\QueriesBuilder\Registries\ProjectQueryRegistry;
use InvalidArgumentException;

final class ProjectSemanticValidation
{
    private const SINGLE_VALUE_OPERATORS = [
        '=',
        '!=',
        '>',
        '>=',
        '<',
        '<=',
    ];

    private const ARRAY_VALUE_OPERATORS = [
        'in',
        'not_in',
    ];

    private const TWO_VALUE_OPERATORS = [
        'between',
    ];

    private array $fields;

    public function __construct(
        private ProjectQueryRegistry $queryRegistry
    ) {
        $this->fields = $this->queryRegistry->fields();
    }

    public function validate(QueryDefinition $queryDefinition): QueryDefinition
    {
        $this->validateGroup($queryDefinition->query);

        return $queryDefinition;
    }

    private function validateGroup(QueryGroup $group): void
    {
        foreach ($group->conditions as $condition) {
            if ($condition instanceof QueryCondition) {
                $this->validateCondition($condition);
                continue;
            }

            if ($condition instanceof QueryGroup) {
                $this->validateGroup($condition);
                continue;
            }

            throw new InvalidArgumentException(
                'Invalid query node type.'
            );
        }
    }

    private function validateCondition(QueryCondition $condition): void
    {
        $fieldDefinition = $this->getFieldDefinition($condition->field);

        $this->validateOperator(
            $condition->field,
            $condition->operator,
            $fieldDefinition['operators'] ?? []
        );

        $this->validateValue(
            $condition,
            $fieldDefinition
        );
    }

    private function getFieldDefinition(string $field): array
    {
        if (!array_key_exists($field, $this->fields)) {
            throw new InvalidArgumentException(
                "Field '{$field}' not found."
            );
        }

        return $this->fields[$field];
    }

    private function validateOperator(
        string $field,
        string $operator,
        array $allowedOperators
    ): void {
        if (!in_array($operator, $allowedOperators, true)) {
            throw new InvalidArgumentException(
                "Operator '{$operator}' is not allowed for field '{$field}'."
            );
        }
    }

    private function validateValue(
        QueryCondition $condition,
        array $fieldDefinition
    ): void {
        
        $operator = $condition->operator;
        $value = $condition->value;

        if (in_array($operator, self::SINGLE_VALUE_OPERATORS, true)) {
            $this->validateSingleValue(
                $condition->field,
                $value,
                $fieldDefinition
            );

            return;
        }

        if (in_array($operator, self::ARRAY_VALUE_OPERATORS, true)) {
            $this->validateMultipleValue(
                $condition->field,
                $value,
                $fieldDefinition
            );

            return;
        }

        if (in_array($operator, self::TWO_VALUE_OPERATORS, true)) {
            $this->validateTwoValues(
                $condition->field,
                $value,
                $fieldDefinition
            );

            return;
        }

        throw new InvalidArgumentException(
            "Value validation is not defined for operator '{$operator}'."
        );
    }

    private function validateSingleValue(
        string $field,
        mixed $value,
        array $fieldDefinition
    ): void {
        $this->validateValueByFieldType(
            $field,
            $value,
            $fieldDefinition
        );
    }

    private function validateMultipleValue(
        string $field,
        mixed $value,
        array $fieldDefinition
    ): void {
        if (!is_array($value)) {
            throw new InvalidArgumentException(
                "Value for field '{$field}' must be an array."
            );
        }

        if ($value === []) {
            throw new InvalidArgumentException(
                "Value for field '{$field}' cannot be empty."
            );
        }

        foreach ($value as $item) {
            $this->validateValueByFieldType(
                $field,
                $item,
                $fieldDefinition
            );
        }
    }

    private function validateTwoValues(
        string $field,
        mixed $value,
        array $fieldDefinition
    ): void {
        if (!is_array($value) || count($value) !== 2) {
            throw new InvalidArgumentException(
                "Value for field '{$field}' must contain exactly two values."
            );
        }

        foreach ($value as $item) {
            $this->validateValueByFieldType(
                $field,
                $item,
                $fieldDefinition
            );
        }
    }

    private function validateValueByFieldType(
        string $field,
        mixed $value,
        array $fieldDefinition
    ): void {
        $type = $fieldDefinition['type'] ?? null;

        match ($type) {
            'number' => $this->validateNumberValue($field, $value),

            'date' => $this->validateDateValue($field, $value),

            'select', 'enum', 'string' => $this->validateSelectValue($field, $value),

            default => throw new InvalidArgumentException(
                "Unsupported field type '{$type}' for field '{$field}'."
            ),
        };
    }

    private function validateNumberValue(
        string $field,
        mixed $value
    ): void {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException(
                "Value for field '{$field}' must be a number."
            );
        }
    }

    private function validateDateValue(
        string $field,
        mixed $value
    ): void {
        if (!is_string($value)) {
            throw new InvalidArgumentException(
                "Value for field '{$field}' must be a date string."
            );
        }

        $date = \DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $value
        );

        $isValidDate =
            $date !== false &&
            $date->format('Y-m-d') === $value;

        if (!$isValidDate) {
            throw new InvalidArgumentException(
                "Value for field '{$field}' must be a valid date in Y-m-d format."
            );
        }
    }

    private function validateSelectValue(
        string $field,
        mixed $value
    ): void {
        if (!is_int($value) && !is_string($value)) {
            throw new InvalidArgumentException(
                "Value for select field '{$field}' must be a string or integer."
            );
        }
    }
}
