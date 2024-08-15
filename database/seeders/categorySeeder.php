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
        // Category
       $categories =
        [
           [
               'name' => 'Primary',
               'thumbnail' =>fake()->image(),
               'tags' => fake()->name(),
               'status'=>'1',
           ],
           [
               'name' => 'Middle',
               'thumbnail' =>fake()->image(),
               'tags' => fake()->name(),
               'status'=>'1',
           ],
           [
               'name' => 'Senior',
               'thumbnail' =>fake()->image(),
               'tags' => fake()->name(),
               'status'=>'1',
           ],
       ];
       foreach ($categories as $category) {
       category::create($category);
       }
          //  Start Make Grade Category
               $grades = [
            [
                'name' => 'Primary One',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'1',
                'status' => '1',
                'order' => 1,
            ],
            [
                'name' => 'Primary Two',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'1',
                'status' => '1',
                'order' => 2,
            ],
            [
                'name' => 'Primary Three',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'1',
                'status' => '1',
                'order' => 3,
            ],
            [
                'name' => 'Primary Four',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'1',
                'status' => '1',
                'order' => 4,
            ],
            [
                'name' => 'Primary Five',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'1',
                'status' => '1',
                'order' => 5,
            ],
            [
                'name' => 'Primary Six',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'1',
                'status' => '1',
                'order' => 6,
            ],
            [
                'name' => 'Middle One',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'2',
                'status' => '1',
                'order' => 7,
            ],
            [
                'name' => 'Middle Two',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'2',
                'status' => '1',
                'order' => 8,
            ],
            [
                'name' => 'Middle Three',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'2',
                'status' => '1',
                'order' => 9,
            ],
            [
                'name' => 'Senior One',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'3',
                'status' => '1',
                'order' => 10,
            ],
            [
                'name' => 'Senior Two',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'3',
                'status' => '1',
                'order' => 11,
            ],
            [
                'name' => 'Senior Three',
                'thumbnail' => fake()->image(),
                'tags' => fake()->name(),
                'category_id'=>'3',
                'status' => '1',
                'order' => 12,
            ],
        ];
          foreach ($grades as $grade) {
           category::create($grade);
          }
    }
}
