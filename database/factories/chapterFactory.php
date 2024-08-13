<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\chapter>
 */
class chapterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // This Factory About Chapter
            'name' => fake()->name(),
            'cover_photo' => fake()->image(),
            'thumbnail' => fake()->image(),
        ];
    }
}
