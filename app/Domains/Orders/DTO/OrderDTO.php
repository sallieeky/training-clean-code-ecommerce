<?php

namespace App\Domains\Orders\DTO;

class OrderDTO
{
    public int $productId;

    public int $quantity;

    public function __construct(int $productId, int $quantity)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['product_id'],
            $data['quantity']
        );
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->productId,
            'quantity' => $this->quantity,
        ];
    }
}
