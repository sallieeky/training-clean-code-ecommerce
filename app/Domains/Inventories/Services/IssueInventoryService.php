<?php

namespace App\Domains\Inventories\Services;

use App\Domains\Inventories\DTO\InventoryDTO;
use App\Domains\Inventories\Models\Inventories;
use App\Domains\Shared\CalculatorService;

class IssueInventoryService
{
    protected $calculatorService;

    public function __construct(CalculatorService $calculatorService)
    {
        $this->calculatorService = $calculatorService;
    }

    public function issue(InventoryDTO $inventoryDTO): Inventories
    {
        $data = $inventoryDTO->toArray();
        $inventory = Inventories::where('product_id', $data['product_id'])->first();
        $inventory->quantity = $this->calculatorService->subtract($inventory->quantity, $data['quantity']);
        $inventory->save();

        return $inventory;
    }
}
