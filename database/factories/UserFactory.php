<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $phone = $this->faker->regexify('/^08[1-9]\d{8,9}$/');

        $birthdate = $this->faker->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d');
        $numberOfAddresses = 5;
        $addresses = [];

        for ($i = 0; $i < $numberOfAddresses; $i++) {
            $addresses[] = $this->faker->streetAddress;
        }

        $defaultAddress = $this->faker->randomElement($addresses);
        $addresses = \json_encode($addresses);
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'birth_date'        => $birthdate,
            'role'              => $this->faker->randomElement(['admin','customer']),
            'addresses'         => $addresses, 
            'phone'             => $phone,
            'default_address'   => $defaultAddress,
            'profile_image'     => $this->faker->randomElement([
                'users_profile_image/man.png',
                'users_profile_image/man-1.png',
                'users_profile_image/man-2.png',
                'users_profile_image/woman.png',
                'users_profile_image/woman-1.png',
                'users_profile_image/woman-2.png'
            ]),
            'remember_token'    => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
