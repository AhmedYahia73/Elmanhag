<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = fake()->dateTimeBetween('-1 year', 'now');
        $end_date = fake()->dateTimeBetween($start_date, '+1 year');
        return [
            'amount' => fake()->numberBetween(100, 1000),
            'type' => fake()->randomElement(['precentage','value']),
            'description' => fake()->name(),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'statue' => fake()->randomElement(['1','0']),
        ];
    }
}
