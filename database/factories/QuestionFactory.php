<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class questionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => fake()->name(),
            'image' => fake()->image(),
            'audio' => fake()->image(),
            'status' => fake()->randomElement([1, 0]),
            'semester' => fake()->randomElement(['first', 'second']) ,
            'answer_type' => fake()->randomElement(['Mcq', 'T/F', 'Join', 'Essay']) ,
            'question_type' => fake()->randomElement(['text', 'image', 'audio']) ,
            'difficulty' => fake()->randomElement(['A', 'B', 'C']) ,
        ];
    }
}
