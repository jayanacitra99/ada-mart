<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $faker = Faker::create();
        
        foreach ($products as $product){
            $unitTypes = ['karton', 'kardus', 'pcs'];
        
            foreach ($unitTypes as $unitType) {
                $data = [
                    'product_id' => $product->id,
                    'promo_id' => \random_int(0,1) ? \random_int(1,100) : null,
                    'unit_type' => $unitType,
                    'price' => $faker->numberBetween(10, 50) * 1000,
                    'quantity' => $faker->numberBetween(0, 100),
                ];
                ProductDetail::create($data);
            }
        }
    }
}
