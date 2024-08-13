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
         // Category
        $categories =
         [
            [
                'name' => 'ابتدائي',
                'thumbnail' =>fake()->image(),
                'tags' => fake()->name(),
                'status'=>'1',
            ],
            [
                'name' => 'اعدادي',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'status'=>'1',
            ],
            [
                'name' => 'ثنوي',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'status'=>'1',
            ],
        ];
       
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
       foreach ($categories as $category) {
       category::factory()
       ->create($category);
       }
          //  Start Make Grade Category
               $grades = [
            [
                'name' => 'الاول الابتدائي',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'1',
                'status' => '1',
            ],
            [
                'name' => 'الثاني الابتدائي',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'1',
                'status' => '1',
            ],
            [
                'name' => 'الثالث الابتدائي',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'1',
                'status' => '1',
            ],
            [
                'name' => 'الثالث الاعدادي',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'2',
                'status' => '1',
            ],
            [
                'name' => 'الثالث الاعدادي',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'2',
                'status' => '1',
            ],
            [
                'name' => 'الثالث الاعدادي',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'2',
                'status' => '1',
            ],
            [
                'name' => 'الثالث الثانوي',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'3',
                'status' => '1',
            ],
            [
                'name' => 'الثالث الثانوي',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'3',
                'status' => '1',
            ],
            [
                'name' => 'الثالث الثانوي',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'3',
                'status' => '1',
            ],
        ];
          foreach ($grades as $grade) {
           category::factory()
           ->create($grade);
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

        subject::factory()
        ->count(20)
        ->create([
            'category_id' => category::factory()
        ]);

        chapter::factory()
        ->count(20)
        ->create([
            'subject_id' => subject::factory()
        ]);
         
         
    }
}
