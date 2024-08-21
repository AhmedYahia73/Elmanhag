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
        $lessons = [
            [
                'name' => 'Lesson One',
                'description' => 'Hello with Lesson One',
                'paid' => 1,
                'chapter_id' => 1,
                'status' => 1,
                'order' => 1,
                'drip_content' => 0,
            ],
            [
                'name' => 'Lesson Two',
                'description' => 'Hello with Lesson Two',
                'paid' => 1,
                'chapter_id' => 1,
                'status' => 1,
                'order' => 1,
                'drip_content' => 0,
            ],
            [
                'name' => 'Lesson Three',
                'description' => 'Hello with Lesson Three',
                'paid' => 1,
                'chapter_id' => 1,
                'status' => 1,
                'order' => 1,
                'drip_content' => 0,
            ],
            [
                'name' => 'Lesson One',
                'description' => 'Hello with Lesson One',
                'paid' => 1,
                'chapter_id' => 2,
                'status' => 1,
                'order' => 1,
                'drip_content' => 0,
            ],
            [
                'name' => 'Lesson Two',
                'description' => 'Hello with Lesson Two',
                'paid' => 1,
                'chapter_id' => 2,
                'status' => 1,
                'order' => 1,
                'drip_content' => 0,
            ],
            [
                'name' => 'Lesson One',
                'description' => 'Hello with Lesson One',
                'paid' => 1,
                'chapter_id' => 3,
                'status' => 1,
                'order' => 1,
                'drip_content' => 0,
            ],
            [
                'name' => 'Lesson Two',
                'description' => 'Hello with Lesson Two',
                'paid' => 1,
                'chapter_id' => 3,
                'status' => 1,
                'order' => 1,
                'drip_content' => 0,
            ],
            [
                'name' => 'Lesson One',
                'description' => 'Hello with Lesson One',
                'paid' => 1,
                'chapter_id' => 4,
                'status' => 1,
                'order' => 1,
                'drip_content' => 0,
            ],
            [
                'name' => 'Lesson Two',
                'description' => 'Hello with Lesson Two',
                'paid' => 1,
                'chapter_id' => 4,
                'status' => 1,
                'order' => 1,
                'drip_content' => 0,
            ],
            [
                'name' => 'Lesson One',
                'description' => 'Hello with Lesson One',
                'paid' => 1,
                'chapter_id' => 5,
                'status' => 1,
                'order' => 1,
                'drip_content' => 0,
            ],
        ];
        foreach ($lessons as $item) {
            lesson::factory()
            ->create($item);
        }
        lesson::factory()
        ->count(20)
        ->create([
            'chapter_id' => chapter::factory(),
        ]);
    }
}
