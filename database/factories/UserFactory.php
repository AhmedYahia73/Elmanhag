<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password='123';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = User::class;
    
    public function definition(): array
    {
       
        return [
            'firstName' => fake()->firstName(),
            'lastName' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'type' => $this->faker->randomElement(['student','admin','parent','teacher','subAdmin']),
        
            'phone' => fake()->unique()->phoneNumber(),
            'parent_phone' => fake()->unique()->phoneNumber(),
            'parent_name' => fake()->name(),
            'image' => 'student/user/default.png',
            'status' => $this->faker->randomElement(['1','0']),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(20),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
