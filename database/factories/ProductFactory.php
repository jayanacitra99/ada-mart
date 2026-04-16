<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => $this->faker->sentence(),
            'description'   => $this->faker->text(),
            'image'         => $this->faker->randomElement([
                'products/0.png',
                'products/1.png',
                'products/2.png',
                'products/3.png',
                'products/4.png',
                'products/5.png',
                'products/6.png',
                'products/7.png',
            ]),
            // 'image'         => "[]"
        ];
    }
}
