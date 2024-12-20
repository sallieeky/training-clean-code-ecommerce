<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it can get all products', function () {
    $service = new \App\Domains\Products\Services\GetProductService(
        sortBy: 'name',
        sortDirection: 'asc',
        searchTerm: null,
    );
    $result = $service->getProducts();

    expect($result)->toBeInstanceOf(\Illuminate\Support\Collection::class);
});

test('it can get product by id', function () {
    $product = \App\Domains\Products\Models\Products::query()->create([
        'name' => 'Product 1',
        'description' => 'Description 1',
        'price' => 100.00,
    ]);
    $service = new \App\Domains\Products\Services\GetProductService(
        sortBy: 'name',
        sortDirection: 'asc',
        searchTerm: null,
    );
    $result = $service->getProductById($product->id);

    expect($result)->toBeInstanceOf(\App\Domains\Products\Models\Products::class)
        ->and($result->id)->toBe($product->id);
});
