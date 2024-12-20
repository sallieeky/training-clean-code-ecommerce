<?php

use App\Domains\Shared\CalculatorService;

test('it_add_successfully', function () {
    $calculator = new CalculatorService;
    $result = $calculator->add(1, 2);

    expect(3)->toEqual($result);
});

test('it_substract_successfully', function () {
    $calculator = new CalculatorService;
    $result = $calculator->subtract(2, 1);

    expect(1)->toEqual($result);
});

test('it_multiply_successfully', function () {
    $calculator = new CalculatorService;
    $result = $calculator->multiply(2, 3);

    expect(6)->toEqual($result);
});

test('it_divide_successfully', function () {
    $calculator = new CalculatorService;
    $result = $calculator->divide(6, 3);

    expect(2)->toEqual($result);
});

test('it_divide_by_zero_successfully', function () {
    $calculator = new CalculatorService;
    $result = $calculator->divide(6, 0);

    expect("Unidentified")->toEqual($result);
});
