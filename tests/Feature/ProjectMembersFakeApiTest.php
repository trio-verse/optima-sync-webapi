<?php

it('keeps the project value aligned with sub_total, profit_percentage, and total_amount', function () {
    $project = app(\App\Support\FakePersistence\ProjectModuleFakeStore::class)
        ->projects()
        ->find(1);

    expect((float) $project['sub_total'])->toBe(10000.0)
        ->and((int) $project['profit_percentage'])->toBe(20)
        ->and((float) $project['total_amount'])->toBe(12000.0);
});

it('uses the project profit-adjusted total as the quotation subtotal and applies tax and discount to the final total', function () {
    $store = app(\App\Support\FakePersistence\ProjectModuleFakeStore::class);
    $quotation = $store->quotations()->find(1);
    $resource = new \App\Http\Resources\V1\QuotationResource($quotation);

    $payload = $resource->toArray(request());

    expect($payload['subtotal'])->toBe('12000.00')
        ->and($payload['discount'])->toBe('0.00')
        ->and($payload['tax'])->toBe('350.00')
        ->and($payload['total'])->toBe('12350.00');
});
