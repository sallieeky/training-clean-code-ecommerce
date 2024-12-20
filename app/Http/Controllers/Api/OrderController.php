<?php

namespace App\Http\Controllers\Api;

use App\Domains\Orders\DTO\OrderDTO;
use App\Domains\Orders\Services\StoreOrderService;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\StoreOrderRequest;

class OrderController extends Controller
{
    protected $storeOrderService;

    public function __construct(
        StoreOrderService $storeOrderService
    ) {
        $this->storeOrderService = $storeOrderService;
    }

    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();

        $this->storeOrderService->create(OrderDTO::fromArray($validated));

        return ApiResponse::sendResponse(null, 'Order Successfully saved');
    }
}
