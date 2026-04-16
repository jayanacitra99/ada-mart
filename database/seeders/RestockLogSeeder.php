<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\RestockLog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RestockLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // Get admin user IDs
        $adminUserIds = User::where('role','admin')->pluck('id')->toArray();
        
        for($i=0;$i < 30;$i++){
            $product = Product::with('productDetails')->where('id',$faker->numberBetween(1,50))->first();
            $unit_type = $faker->randomElement(['karton','kardus','pcs']);
            $before_restock = $product->productDetails()->ofUnitType('karton')->first()->quantity;
            $userId = $faker->randomElement($adminUserIds);
            $data = [
                'user_id'           => $userId,
                'product_id'        => $product->id,
                'quantity'          => $faker->numberBetween(10,100),
                'unit_type'         => $unit_type,
                'before_restock'    => $before_restock,
                'after_restock'     => $before_restock + $faker->numberBetween(1,50),
            ];
            RestockLog::create($data);
        }
    }
}
