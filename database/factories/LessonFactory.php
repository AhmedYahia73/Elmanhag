<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->name(),
            'paid' => fake()->randomElement([1, 0]),
            'status' => fake()->randomElement([1, 0]),
            'order' => fake()->randomElement([1, 2]),
            'drip_content' => fake()->randomElement([1, 0]),
        ];
    }
}
