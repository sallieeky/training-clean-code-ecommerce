<?php

namespace App\Console\Commands;

use App\Domains\Orders\DTO\OrderDTO;
use App\Domains\Orders\Services\StoreOrderService;
use App\Domains\Products\Services\GetProductService;
use Illuminate\Console\Command;

class OrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an order for a product';

    protected $getProductService;

    protected $storeOrderService;

    /**
     * Execute the console command.
     */
    public function __construct(
        GetProductService $getProductService,
        StoreOrderService $storeOrderService
    ) {
        parent::__construct();
        $this->getProductService = $getProductService;
        $this->storeOrderService = $storeOrderService;
    }

    public function handle()
    {
        $this->getAllProducts();

        $productId = $this->ask('Enter the Product ID');
        $quantity = $this->ask('Enter the Quantity');

        try {
            // Call OrderService to create the order
            $order = $this->storeOrderService->create(OrderDTO::fromArray([
                'product_id' => $productId,
                'quantity' => $quantity,
            ]));

            $this->info('Order created successfully!');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        return Command::SUCCESS;
    }

    private function getAllProducts()
    {
        $products = $this->getProductService->getProducts();
        if ($products->isEmpty()) {
            $this->info('No products found.');
        } else {
            $this->table(['ID', 'Name', 'Price', 'Description'], $products->toArray());
        }
    }
}
