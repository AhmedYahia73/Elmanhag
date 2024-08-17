<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bundle>
 */
class BundleFactory extends Factory
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
            'semester' => fake()->randomElement(['first', 'second']) ,
        ];
    }
}
