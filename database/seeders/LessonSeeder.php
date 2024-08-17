<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\lesson;
use App\Models\chapter;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        lesson::factory()
        ->count(20)
        ->create([
            'chapter_id' => chapter::factory(),
        ]);
    }
}
