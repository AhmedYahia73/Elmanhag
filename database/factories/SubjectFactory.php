<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubjectsFactory extends Factory
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
            'price' => fake()->number(),
            'demo_video' => fake()->image(),
            'cover_photo' => fake()->image(),
            'thumbnail' => fake()->image(),
            'url' => fake()->name(),
            'description' => fake()->name(),
            'status' => fake()->randomElement(['1','0']),
            'description' => fake()->randomElement(['first', 'second']),
            'expired_date' => fake()->date(),
        ];
    }
}
