<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        $faker = Faker::create();
        foreach($orders as $order){
            $status = $order->status;
            $data = [
                'order_id'          => $order->id,
                'payment_receipt'   => $faker->randomElement([
                    'payment_receipts/receipt.png',
                    'payment_receipts/receipt(1).png',
                    'payment_receipts/receipt(2).png',
                ]),
                'total'             => $order->total,
                'status'            => $status == 'billed' ? 'waiting' : ($status == 'canceled' ? 'canceled' : ($status == 'paid' or $status == 'completed' ? 'success' : 'failed'))
            ];
            Payment::create($data);
        }
    }
}
