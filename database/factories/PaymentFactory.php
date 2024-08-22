<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->numberBetween(100, 1000),
            'service' => fake()->randomElement(['Subject','Bundle', 'Live session', 'Live Package', 'Revision']),
            'receipt' => fake()->image(),
            'purchase_date' => fake()->date(),
        ];
    }
}
