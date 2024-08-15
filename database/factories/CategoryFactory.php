<?php

namespace Database\Factories;

use App\Models\category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // This About All Category

             'name' => fake()->name(),
             'thumbnail' => fake()->image(),
             'tags' => fake()->name(),
             'status' => $this->faker->randomElement(['1','0']),
             'order' => fake()->numberBetween(1, 15),
        ];
           
            
    }
}
