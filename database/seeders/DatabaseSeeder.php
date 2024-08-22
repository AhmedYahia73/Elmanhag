<?php

namespace Database\Seeders;

use App\Models\category;
use App\Models\city;
use App\Models\country;
use App\Models\User;
use App\Models\subject;
use App\Models\Education;
use App\Models\chapter;
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
        $this->call(PaymentMethodSeeder::class);
        $this->call(categorySeeder::class);
        // Category
        $staticUser =
            [
               [
                 'name' => 'Elmanhag Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'role' => 'admin',
                'phone' => fake()->unique()->phoneNumber(),
                'image' => 'student/user/default.png',
                'status' => '1',
                'password' => '123',
                'remember_token' => str::random(20),
                'country_id' => country::factory(),
                'category_id'=>category::factory(),
                'city_id' => city::factory(),
                
               ],
               [
                 'name' => 'Elmanhag Student',
                'email' => 'student@gmail.com',
                'email_verified_at' => now(),
                'role' => 'student',
                'phone' => fake()->unique()->phoneNumber(),
                'image' => 'student/user/default.png',
                'status' => '1',
                'password' => '123',
                'remember_token' => str::random(20),
                'country_id' => country::factory(),
                'category_id'=>category::factory(),
                'city_id' => city::factory(),
                
               ],
               [
                 'name' => 'Moaz',
                'email' => 'Moaz@gmail.com',
                'email_verified_at' => now(),
                'role' => 'student',
                'phone' => fake()->unique()->phoneNumber(),
                'image' => 'student/user/default.png',
                'status' => '1',
                'password' => '123',
                'remember_token' => str::random(20),
                'country_id' => country::factory(),
                'category_id'=>17,
                'city_id' => city::factory(),
                
               ],
            ];

        // User::factory(10)->create();
        // $this->call([
        //     User::class,
        // ]);
        foreach ($staticUser as $user) {
            User::factory()
            ->create($user);
        }
        
        // Factory of Education
        Education::factory()
        ->count(20)
        ->create();
            //  End Make Grade Category
      country::factory()
            ->count(30)
          ->create();
        city::factory()
            ->count(20)
            ->create(
                [
                    'country_id'=>country::factory(),
                ]
            );
        User::factory()
            ->count(20)
            ->create(
                [
                    'country_id'=>country::factory(),
                    'category_id'=>category::factory(),
                    'city_id'=>city::factory(),
                    'education_id' => Education::factory(),
                ]
            );

        $this->call(SubjectSeeder::class);
        $this->call(ChapterSeeder::class);
        $this->call(BundleSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(HomeworkSeeder::class);
        $this->call(QuestionGroupSeeder::class);
        $this->call(DiscountSeeder::class);
        $this->call(PromoCodeSeeder::class);
        $this->call(PaymentSeeder::class);
         
         
    }
}
