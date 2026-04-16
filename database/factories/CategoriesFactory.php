<?php

namespace Database\Factories;

use App\Models\Promo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categories>
 */
class CategoriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'promo_id'  => \random_int(0,1) ? Promo::factory() : null,  
            'name'      => $this->faker->sentence(3),
            'image'     => $this->faker->randomElement([
                'categories/0.png',
                'categories/1.png',
                'categories/2.png',
                'categories/3.png',
                'categories/4.png',
                'categories/5.png',
                'categories/6.png',
                'categories/7.png',
            ]),
        ];      
    }
}
