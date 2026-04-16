<?php

namespace App\Console\Commands;

use App\Models\ProductDetail;
use Illuminate\Console\Command;

class FillProductDetailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:product-detail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill Type, Min Order, Max Order in Product Details';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bar = $this->output->createProgressBar(ProductDetail::count());
        $bar->start();
        ProductDetail::chunk(100, function ($productDetails) use ($bar){
            foreach ($productDetails as $productDetail) {
                if (strpos($productDetail->unit_type, '3 pcs') !== false or strpos($productDetail->unit_type, '3pcs') !== false) {
                    $productDetail->min_order = 3;
                    $productDetail->save();
                }
                $bar->advance();
            }
        });
        $bar->finish();
    }
}
