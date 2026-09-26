<?php

use App\Models\Project;
use App\Models\ProjectCost;
use App\Services\ProjectManagment\ProjectEmployeeService;
use App\Services\ProjectManagment\ProjectPricingService;

it('derives quotation totals from project pricing and project add-on costs', function () {
    $project = new Project([
        'sub_total' => 2737,
        'profit_percentage' => 20,
        'total_amount' => 3284.40,
    ]);
    $project->setRelation('costs', collect([
        new ProjectCost(['quantity' => 2, 'amount' => 50]),
        new ProjectCost(['quantity' => 1, 'amount' => 15.50]),
    ]));

    $pricing = new ProjectPricingService(new ProjectEmployeeService());
    $totals = $pricing->calculateQuotationTotals($project, 100, 250);

    expect($totals)->toMatchArray([
        'development_fee' => 3284.40,
        'added_costs_total' => 115.50,
        'subtotal' => 3399.90,
        'discount' => 100.00,
        'tax' => 250.00,
        'total' => 3549.90,
    ]);
});

it('uses project quotation settings when calculating quotation totals', function () {
    $project = new Project([
        'sub_total' => 2700,
        'profit_percentage' => 0,
        'discount' => 0,
        'tax' => 50,
    ]);
    $project->setRelation('costs', collect());

    $pricing = new ProjectPricingService(new ProjectEmployeeService());
    $totals = $pricing->calculateQuotationTotals($project);

    expect($totals['subtotal'])->toBe(2700.0)
        ->and($totals['total'])->toBe(2750.0);
});
