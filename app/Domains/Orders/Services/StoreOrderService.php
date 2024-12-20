<?php

namespace App\Domains\Orders\Services;

use App\Domains\Orders\DTO\OrderDTO;
use App\Domains\Orders\Models\Orders;
use App\Domains\Products\Models\Products;
use App\Events\OrderIssued;

class StoreOrderService
{
    public function create(OrderDTO $orderDTO): Orders
    {
        $dto = (object) $orderDTO->toArray();
        $product = Products::find($dto->product_id);
        $price = $product->price;
        $totalPrice = $dto->quantity * $price;

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
