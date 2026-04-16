<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class TransformImagesCommand extends Command
{
    protected $signature = 'images:product-transform';

    protected $description = 'Transform images format';

    public function handle()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $image = $product->image;
            // Decode the JSON string to an associative array
            $images = json_decode($image, true);
            
            // Transform the associative array to an indexed array
            $indexedImages = array_values($images);
            
            // Encode the indexed array back to JSON format
            $updatedImages = json_encode($indexedImages);
            
            // Update the product with the modified image data
            $product->image = $updatedImages;
            $product->save();
        }

        $this->info('Images transformed successfully.');
    }
}
