<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\QuestionGroup;
use App\Models\homework;
use App\Models\question;

class QuestionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = QuestionGroup::factory()
        ->count(20)
        ->create([
            'homework_id' => homework::factory(),
        ]);

        foreach ($groups as $group) {
            $group->roles()->attach(question::factory);
        }
    }
}
