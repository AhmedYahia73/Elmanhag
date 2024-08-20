<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PromoCode>
 */
class PromoCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $value =fake()->optional()->numberBetween(100, 1000);
        $precentage = $value == null ? fake()->numberBetween(10, 90) : null;
        $usage_type = fake()->randomElement(['fixed', 'unlimited']);
        $usage = $usage_type == 'fixed' ? fake()->numberBetween(100, 300) : null;
        return [
            'title' => fake()->name(),
            'code' => fake()->name(),
            'value' => $value,
            'precentage' => $precentage,
            'usage_type' => $usage_type,
            'usage' => $usage,
            'number_users' => fake()->numberBetween(10, 90),
            'status' => fake()->randomElement([1, 0]),
        ];
    }
}
