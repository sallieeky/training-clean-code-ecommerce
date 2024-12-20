<?php

namespace Tests\Unit;

use App\Domains\Inventories\DTO\InventoryDTO;
use App\Domains\Inventories\Models\Inventories;
use App\Domains\Inventories\Services\AddInventoryService;
use App\Domains\Inventories\Services\IssueInventoryService;
use Mockery;

beforeEach(function () {
    $this->addInventoryService = new AddInventoryService;
    $this->issuenventoryService = new IssueInventoryService;
});

test('it updates inventory if exists', function () {
    $mockInventory = Mockery::mock(Inventories::class)->makePartial();
    $mockInventory->product_id = 1;
    $mockInventory->quantity = 20;

    $inventoryDTO = InventoryDTO::fromArray([
        'product_id' => 1,
        'quantity' => 5,
    ]);

    $expectedInventory = new Inventories([
        'product_id' => 2,
        'quantity' => 25,
    ]);

    $serviceMock = Mockery::mock(AddInventoryService::class);
    $serviceMock->shouldReceive('create')
        ->once()
        ->with(Mockery::on(function ($arg) use ($inventoryDTO) {
            return $arg instanceof InventoryDTO && $arg->toArray() === $inventoryDTO->toArray();
        }))
        ->andReturn($expectedInventory);

    $result = $serviceMock->create($inventoryDTO);

    expect($result->quantity)->toBe(25);
});

test('it creates new inventory if it does not exist', function () {
    $mockInventory = Mockery::mock(Inventories::class)->makePartial();
    $inventoryDTO = InventoryDTO::fromArray([
        'product_id' => 5,
        'quantity' => 5,
    ]);

    $expectedInventory = new Inventories([
        'product_id' => 5,
        'quantity' => 5,
    ]);

    $mockInventory->shouldReceive('where')
        ->with('product_id', 2)
        ->andReturnSelf();

    $mockInventory->shouldReceive('first')
        ->andReturn(null);

    $serviceMock = Mockery::mock(AddInventoryService::class);
    $serviceMock->shouldReceive('create')
        ->once()
        ->with(Mockery::on(function ($arg) use ($inventoryDTO) {
            return $arg instanceof InventoryDTO && $arg->toArray() === $inventoryDTO->toArray();
        }))
        ->andReturn($expectedInventory);

    $result = $serviceMock->create($inventoryDTO);

    expect($result->product_id)->toBe(5);
    expect($result->quantity)->toBe(5);
});
