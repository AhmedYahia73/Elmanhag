<?php

namespace Database\Seeders;

use App\Models\city;
use App\Models\country;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $staticUser =
            [
               [
                 'name' => 'Elmanhag Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'type' => 'admin',
                'phone' => fake()->unique()->phoneNumber(),
                'image' => 'student/user/default.png',
                'status' => '1',
                'password' => '123',
                'remember_token' => str::random(20),
                'country_id' => country::factory(),
                'city_id' => city::factory(),
                
               ],
               [
                 'name' => 'Elmanhag Student',
                'email' => 'student@gmail.com',
                'email_verified_at' => now(),
                'type' => 'student',
                'phone' => fake()->unique()->phoneNumber(),
                'image' => 'student/user/default.png',
                'status' => '1',
                'password' => '123',
                'remember_token' => str::random(20),
                'country_id' => country::factory(),
                'city_id' => city::factory(),
                
                ]
            ];

        // User::factory(10)->create();
        // $this->call([
        //     User::class,
        // ]);
      foreach ($staticUser as $user) {
                  User::factory()
                  ->create($user);
    }
        city::factory()
            ->count(20)
            ->create(
                [
                    'country_id'=>country::factory(),
                ]
            );
             User::factory()
             ->create(
           
             );
        User::factory()
            ->count(20)
            ->create(
                [
                    'country_id'=>country::factory(),
                    'city_id'=>city::factory(),
                ]
            );
    }
}
