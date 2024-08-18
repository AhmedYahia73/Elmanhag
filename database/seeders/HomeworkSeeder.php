<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\homework;
use App\Models\category;
use App\Models\subject;
use App\Models\chapter;
use App\Models\lesson;

class HomeworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        homework::factory()
        ->count(20)
        ->create([
            'category_id' => category::factory(),
            'subject_id' => subject::factory(),
            'chapter_id' => chapter::factory(),
            'lesson_id' => lesson::factory(),
        ]);
    }
}
