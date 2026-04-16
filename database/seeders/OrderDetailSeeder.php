<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        $faker = Faker::create();

        foreach ($orders as $order) {
            for ($i=0; $i < \random_int(1,5); $i++) { 
                $productDetail = ProductDetail::inRandomOrder()->first();
                $data = [
                    'order_id' => $order->id,
                    'product_detail_id' => $productDetail->id,
                    'quantity' => $faker->numberBetween(10, 50),
                    'subtotal' => $faker->numberBetween(10, 100) * 1000,
                ];
                OrderDetail::create($data);   
            }
        }
    }
}
