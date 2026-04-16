<?php

namespace Database\Seeders;

use App\Models\ProductDetail;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ShoppingCartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $faker = Faker::create();

        foreach($users as $user){
            $productDetail = ProductDetail::inRandomOrder()->first();
            $data = [
                'user_id'           => $user->id,
                'product_detail_id' => $productDetail->id,
                'quantity'          => $faker->numberBetween(1,10),
            ];
            ShoppingCart::create($data);
        }
    }
}
