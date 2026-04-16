<?php

namespace Database\Seeders;

use App\Models\ProductDetail;
use App\Models\RestockFromWarehouseLogs;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RestockFromWarehouseLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // Get admin user IDs
        $adminUserIds = User::where('role','admin')->pluck('id')->toArray();
        for($i = 0; $i < 10; $i++){
            $openedProductId = ProductDetail::whereNot('unit_type', 'pcs')->inRandomOrder()->first();
            $convertedToProductId = ProductDetail::where('product_id',$openedProductId->product_id)->where('unit_type', 'pcs')->first();
            $userId = $faker->randomElement($adminUserIds);
            $data =  [
                'user_id'                   => $userId,
                'opened_product_id'         => $openedProductId->id,
                'converted_to_product_id'   => $convertedToProductId->id,
                'opened_amount'             => $faker->numberBetween(0,5),
                'received_amount'           => $faker->numberBetween(10,50),
            ];
            RestockFromWarehouseLogs::create($data);
        }
    }
}
