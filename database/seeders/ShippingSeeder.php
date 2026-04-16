<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::with('user')->get();
        $faker = Faker::create();

        foreach($orders as $order){
            $status = $order->status;
            $data = [
                'order_id'          => $order->id,
                'shipping_number'   => $faker->regexify('[A-Z0-9]{16}'),
                'type'              => $faker->randomElement(['delivery','pick-up']),
                'destination'       => $order->user->default_address,
                'subtotal'          => $faker->numberBetween(1,10) * 1000,
                'status'            => $status == 'paid' ? 'ongoing' : ($status == 'canceled' ? 'canceled' : ($status == 'completed' ? 'arrived' : 'waiting')),
            ];
            Shipping::create($data);
        }
    }
}
