<?php

return [

    'projectManagement' => [

        'industry' => [
            'label' => 'Industry',
            'type' => 'select',
            'source' => 'relation_column',
            'relation' => 'client',
            'column' => 'industry_id',
            'relation_path' => 'client.industry',
            'operators' => [
                'in',
                'not_in',
            ],
        ],

        'status' => [
            'label' => 'Status',
            'type' => 'select',
            'source' => 'column',
            'column' => 'status',
            'enum_class' => \App\Enums\enProjectStatus::class,
            'operators' => [
                'in',
                'not_in',
            ],
        ],

        'total_amount' => [
            'label' => 'Total Amount',
            'type' => 'number',
            'source' => 'column',
            'column' => 'total_amount',
            'operators' => [
                '=',
                '!=',
                '>',
                '>=',
                '<',
                '<=',
                'between',
            ],
        ],

        'profit_percentage' => [
            'label' => 'Profit Percentage',
            'type' => 'number',
            'source' => 'column',
            'column' => 'profit_percentage',
            'operators' => [
                '=',
                '>',
                '<',
                'between',
            ],
        ],

        'source' => [
            'label' => 'Source',
            'type' => 'select',
            'source' => 'column',
            'column' => 'source',
            'enum_class' => \App\Enums\enProjectSource::class,
            'operators' => [
                'in',
                'not_in',
            ],
        ],

        'issue_date' => [
            'label' => 'Issue Date',
            'type' => 'date',
            'source' => 'column',
            'column' => 'issue_date',
            'operators' => [
                '=',
                '>',
                '<',
                'between',
            ],
        ],

        'employees_count' => [
            'label' => 'Employees Count',
            'type' => 'number',
            'source' => 'relation_count',
            'relation' => 'employees',
            'operators' => [
                '=',
                '!=',
                '>',
                '>=',
                '<',
                '<=',
                'between',
            ],
        ],

        'start_date' => [
            'label' => 'Start Date',
            'type' => 'date',
            'source' => 'relation_column',
            'relation' => 'currentVersion',
            'column' => 'start_date',
            'operators' => [
                '>',
                '>=',
                '<',
                '<=',
                'between',
            ],
        ],

        'end_date' => [
            'label' => 'End Date',
            'type' => 'date',
            'source' => 'relation_column',
            'relation' => 'currentVersion',
            'column' => 'end_date',
            'operators' => [
                '>',
                '>=',
                '<',
                '<=',
                'between',
            ],
        ],
    ],
];

