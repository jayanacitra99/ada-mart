<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promo>
 */
class PromoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['discount','voucher']);
        $validFrom = $this->faker->dateTimeThisDecade();
        $until = Carbon::now()->addYear();
        $validUntil = $this->faker->dateTimeBetween($validFrom, $until);
        return [
            'name'          => $this->faker->words(3, true),
            'promo_code'    => $this->faker->regexify('[A-Z]{5}[0-9]{3}'),
            'type'          => $type,
            'amount'        => $type == 'discount' ? $this->faker->numberBetween(10,90) : $this->faker->numberBetween(1,20) * 1000,
            'max_amount'    => $type == 'discount' ? $this->faker->numberBetween(1, 20) * 1000 : null,
            'valid_from'    => $validFrom,
            'valid_until'   => $validUntil,
        ];
    }
}
