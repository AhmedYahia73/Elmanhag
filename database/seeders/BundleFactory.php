<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\bundle;
use App\Models\category;
use App\Models\Education;

class BundleFactory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        bundle::factory()
        ->count(20)
        ->create([
            'category_id' => category::factory(),
            'education_id' => Education::factory(),
        ]);
    }
}
