<?php

namespace Database\Seeders;

use App\Models\category;
use App\Models\city;
use Illuminate\Support\Str;
use App\Models\country;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // This About All Category 

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
            //  End Make Grade Category
    }
}
