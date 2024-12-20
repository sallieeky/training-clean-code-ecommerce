<?php

namespace App\Console\Commands;

use App\Domains\Products\DTO\ProductDTO;
use App\Domains\Products\Services\GetProductService;
use App\Domains\Products\Services\StoreProductService;
use Illuminate\Console\Command;

class ProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Product service menu for managing products';

    /**
     * GetProductService instance.
     *
     * @var GetProductService
     */
    protected $getProductService;

    protected $storeProductService;

    /**
     * Create a new command instance.
     */
    public function __construct(GetProductService $getProductService, StoreProductService $storeProductService)
    {
        parent::__construct();
        $this->getProductService = $getProductService;
        $this->storeProductService = $storeProductService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Display menu options
        $choice = $this->choice(
            'What do you want to do?',
            ['Get all products', 'Find a product', 'Store a new product'],
            0 // Default option
        );

        // Handle the choice
        switch ($choice) {
            case 'Get all products':
                $this->getAllProducts();
                break;

            case 'Find a product':
                $this->findProduct();
                break;

            case 'Store a new product':
                $this->storeProduct();
                break;

            default:
                $this->error('Invalid choice!');
                break;
        }

        return Command::SUCCESS;
    }

    /**
     * Display all products.
     */
    private function getAllProducts()
    {
        $products = $this->getProductService->getProducts();
        if ($products->isEmpty()) {
            $this->info('No products found.');
        } else {
            $this->table(['ID', 'Name', 'Price', 'Description'], $products->toArray());
        }
    }

    /**
     * Find a product by ID.
     */
    private function findProduct()
    {
        $id = $this->ask('Enter the product ID to find');
        $product = $this->getProductService->getProductById($id);

        if ($product) {
            $this->info("Product Found:
                \nID: {$product->id}
                \nName: {$product->name}
                \nPrice: {$product->price}
                \nDescription: {$product->description}");
        } else {
            $this->error('Product not found.');
        }
    }

    /**
     * Create a new product.
     */
    private function storeProduct()
    {
        $name = $this->ask('Enter product name');
        $price = $this->ask('Enter product price');
        $description = $this->ask('Enter product description (optional)');

        $product = $this->storeProductService->create(ProductDTO::fromArray([
            'name' => $name,
            'price' => $price,
            'description' => $description,
        ]));

        $this->info("Product created successfully: ID {$product->id}");
    }
}
