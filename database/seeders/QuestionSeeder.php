<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\question;
use App\Models\category;
use App\Models\subject;
use App\Models\chapter;
use App\Models\lesson;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        question::factory()
        ->count(20)
        ->create([
            'subject_id'=>subject::factory(),
            'category_id'=>category::factory(),
            'chapter_id' => chapter::factory(),
            'lesson_id'=>lesson::factory(),
        ]);
    }
}
