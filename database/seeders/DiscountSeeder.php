<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Discount;
use App\Models\category;
use App\Models\bundle;
use App\Models\subject;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Discount::factory()
        ->count(20)
        ->create([
            'category_id' => category::factory(),
            'subject_id' => subject::factory(),
            'bundle_id' => bundle::factory(), 
        ]);
    }
}
