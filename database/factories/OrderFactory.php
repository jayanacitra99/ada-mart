<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Promo;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['billed','paid','canceled','completed']);
        return [
            'user_id'       => User::factory(),
            'promo_id'      => random_int(0, 1) ? Promo::factory() : null,
            'status'        => $status,
            'total'         => $this->faker->numberBetween(10,500) * 1000,
            'billed_at'     => $this->faker->dateTimeThisDecade(),
            'paid_at'       => ($status == 'paid' or $status == 'completed') ? $this->faker->dateTimeThisDecade() : null
        ];
    }
}
