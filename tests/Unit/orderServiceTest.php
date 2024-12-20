<?php

use App\Domains\Orders\DTO\OrderDTO;
use App\Domains\Orders\Models\Orders;
use App\Domains\Orders\Services\StoreOrderService;
use App\Domains\Shared\CalculatorService;
use Mockery;

beforeEach(function () {
    $this->storeOrderService = new StoreOrderService(new CalculatorService);
});

test('it can store new order', function () {
    $mockOrder = Mockery::mock(Orders::class)->makePartial();
    $mockOrder->user_id = 1;
    $mockOrder->product_id = 1;
    $mockOrder->quantity = 10;

    $orderDTO = OrderDTO::fromArray([
        'user_id' => 1,
        'product_id' => 1,
        'quantity' => 10,
    ]);

    $expectedInventory = $mockOrder;

    $serviceMock = Mockery::mock(StoreOrderService::class);
    $serviceMock->shouldReceive('store')
        ->once()
        ->with(Mockery::on(function ($arg) use ($orderDTO) {
            return $arg instanceof OrderDTO && $arg->toArray() === $orderDTO->toArray();
        }))
        ->andReturn($expectedInventory);

    $result = $serviceMock->store($orderDTO);

    expect($result->quantity)->toBe(10);
});
