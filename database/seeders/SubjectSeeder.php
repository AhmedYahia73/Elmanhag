<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\subject;
use App\Models\category;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'name' => 'Arabic',
                'price' => 400,
                'category_id' => 17,
                'status' => 1,
                'semester' => 'first',
                'expired_date' => '2025-09-13',
            ],
            [
                'name' => 'Maths',
                'price' => 700,
                'category_id' => 17,
                'status' => 1,
                'semester' => 'first',
                'expired_date' => '2025-11-10',
            ],
        ];
        foreach ($subjects as $subject) {
            subject::factory()
            ->create($subject);
        }

        subject::factory()
        ->count(20)
        ->create([
            'category_id' => category::factory()
        ]);
    }
}
