<?php

namespace App\Domains\Orders\Services;

use App\Domains\Orders\DTO\OrderDTO;
use App\Domains\Orders\Models\Orders;
use App\Domains\Products\Models\Products;
use App\Domains\Shared\CalculatorService;
use App\Events\OrderIssued;

class StoreOrderService
{
    protected $calculatorService;

    public function __construct(CalculatorService $calculatorService)
    {
        $this->calculatorService = $calculatorService;
    }

    public function create(OrderDTO $orderDTO): Orders
    {
        $dto = (object) $orderDTO->toArray();
        $product = Products::find($dto->product_id);
        $price = $product->price;
        $totalPrice = $this->calculatorService->multiply($dto->quantity, $price);
        OrderIssued::dispatch([
            'product_id' => $dto->product_id,
            'quantity' => $dto->quantity,
            'total_price' => $totalPrice,
        ]);
        return Orders::create([
            'product_id' => $dto->product_id,
            'quantity' => $dto->quantity,
            'total_price' => $totalPrice,
        ]);
    }
}
