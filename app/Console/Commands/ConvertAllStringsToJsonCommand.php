<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ConvertAllStringsToJsonCommand extends Command
{
    protected $signature = 'convert:image-strings-to-json';

    protected $description = 'Converts string to JSON and moves the image file for all products';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get all products
        $products = Product::all();

        foreach ($products as $product) {
            $this->info($product->id);
            // Extract image filename from the string
            $imagePath = $product->image;
            $imageName = basename($imagePath);
            $newImageName = [];

            $oldPath = public_path($product->image);
            $newFolder = 'products/PRODUCTS_' . $product->id;
            // Create the new folder if it doesn't exist
            if (!File::exists(public_path($newFolder))) {
                File::makeDirectory(public_path($newFolder), 0755, true, true);
            }

            $newPath = public_path($newFolder.'/' . $imageName);

            // Move the file to the new folder
            File::move($oldPath, $newPath);
            
            $newImageName[] = $newFolder.'/' . $imageName;
            // Update the image path in the product data
            $product->image = \json_encode($newImageName);

            // Save the product
            $product->save();
        }

        $this->info('All strings converted to JSON and images moved successfully.');
    }
}
