<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name'      => 'Admin',
            'phone'     => '00000000001',
            'email'     => 'admin@karomahjaya.com',
            'password'  => Hash::make('1234qwer'),
            'role'      => 'admin',
        ]);
        User::create([
            'name'      => 'Customer',
            'phone'     => '00000000002',
            'email'     => 'customer@karomahjaya.com',
            'password'  => Hash::make('1234qwer'),
            'role'      => 'customer',
        ]);
//        User::factory()->count(50)->create();
//        $this->call(PromoSeeder::class);
//        $this->call(CategoriesSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductCategoriesSeeder::class);
        $this->call(ProductDetailSeeder::class);
//        $this->call(OrderSeeder::class);
//        $this->call(OrderDetailSeeder::class);
//        $this->call(PaymentSeeder::class);
//        $this->call(ShippingSeeder::class);
//        $this->call(RestockLogSeeder::class);
//        $this->call(RestockFromWarehouseLogsSeeder::class);
//        $this->call(ShoppingCartSeeder::class);
//        $this->call(CarouselSeeder::class);
    }
}
