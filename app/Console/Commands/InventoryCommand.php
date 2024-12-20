<?php

namespace App\Console\Commands;

use App\Domains\Inventories\DTO\InventoryDTO;
use App\Domains\Inventories\Services\AddInventoryService;
use Illuminate\Console\Command;

class InventoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:service';

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
    protected $addInventoryService;

    /**
     * Create a new command instance.
     *
     * @param  GetProductService  $getProductService
     */
    public function __construct(AddInventoryService $addInventoryService)
    {
        parent::__construct();
        $this->addInventoryService = $addInventoryService;
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
            ['Add Inventory'],
            0 // Default option
        );

        // Handle the choice
        switch ($choice) {
            case 'Add Inventory':
                $this->addInventory();
                break;

            default:
                $this->error('Invalid choice!');
                break;
        }

        return Command::SUCCESS;
    }

    private function addInventory()
    {
        $productId = $this->ask('Enter product id');
        $qty = $this->ask('Enter quantity');

        $data = $this->addInventoryService->create(InventoryDTO::fromArray([
            'product_id' => $productId,
            'quantity' => $qty,
        ]));

        $this->info("Inventory add successfully: ID {$data->id}");
    }
}
