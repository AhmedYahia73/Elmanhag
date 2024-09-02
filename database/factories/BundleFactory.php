<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bundle>
 */
class bundleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name() ,
            'price' => fake()->numberBetween(100, 1000) ,
            'expired_date' => fake()->date() ,
            'status' => $this->faker()->randomElement(['1','0']) ,
            'semester' => fake()->randomElement(['first', 'second']) ,
        ];
    }
}
