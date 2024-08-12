<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // This Factory About Ciies
              'name' => fake()->name(),
              'country_id' =>'',
              'status' => $this->fake()->randomElement(['1','0']),
        ];
    }
}
