<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Carousel>
 */
class CarouselFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $showFrom = $this->faker->dateTimeThisDecade();
        $showUntil = $this->faker->dateTimeBetween($showFrom);
        $setShow = \random_int(0,1);
        return [
            'name'          => $this->faker->sentence(),
            'image'         => $this->faker->randomElement([
                'carousels/1.jpg',
                'carousels/2.jpg',
                'carousels/3.jpg',
            ]),
            'status'        => $this->faker->randomElement(['active','inactive']),
            'show_from'     => $setShow ? $showFrom : null,
            'show_until'    => $setShow ? $showUntil : null,
        ];
    }
}
