<?php

namespace App\Domains\Inventories\Services;

use App\Domains\Inventories\DTO\InventoryDTO;
use App\Domains\Inventories\Models\Inventories;
use App\Domains\Shared\CalculatorService;

class AddInventoryService
{
    protected $calculatorService;

    public function __construct(CalculatorService $calculatorService)
    {
        $this->calculatorService = $calculatorService;
    }

    public function create(InventoryDTO $inventoryDTO): Inventories
    {
        $data = $inventoryDTO->toArray();

        $inventory = Inventories::where('product_id', $data['product_id'])->first();
        if ($inventory) {
            $inventory->quantity = $this->calculatorService->add($inventory->quantity, $data['quantity']);
            $inventory->save();

            return $inventory;
        }

        return Inventories::create($data);
    }
}
