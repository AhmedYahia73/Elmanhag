<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\homework>
 */
class homeworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'semester' => fake()->randomElement(['first', 'second']),
            'difficulty' => fake()->randomElement(['A', 'B', 'C']) ,
            'mark' => fake()->randomElement([100, 150, 200]),
            'pass' => fake()->randomElement([50, 60, 80]),
            'status'  => fake()->randomElement([true, false]),
        ];
    }
}
