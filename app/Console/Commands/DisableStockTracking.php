<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class DisableStockTracking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:disable-stock-tracking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable stock tracking for all products (sets is_track_stock to false)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $count = Product::query()->update(['is_track_stock' => false]);

        $this->info("Stock tracking disabled for {$count} products.");

        return Command::SUCCESS;
    }
}
