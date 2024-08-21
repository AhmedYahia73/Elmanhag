<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\chapter;
use App\Models\subject;

class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chapters = [
            [
                'name' => 'Capter 1',
                'subject_id' => 1,
            ],
            [
                'name' => 'Capter 2',
                'subject_id' => 1,
            ],
            [
                'name' => 'Capter 3',
                'subject_id' => 2,
            ],
            [
                'name' => 'Capter 4',
                'subject_id' => 2,
            ],
            [
                'name' => 'Capter 5',
                'subject_id' => 2,
            ],
        ];
        foreach ($chapters as $chapter) {
            chapter::factory()
            ->create($chapter);
        }

        chapter::factory()
        ->count(20)
        ->create([
            'subject_id' => subject::factory()
        ]);
    }
}
