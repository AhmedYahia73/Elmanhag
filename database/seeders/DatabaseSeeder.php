<?php

namespace Database\Seeders;

use App\Models\city;
use App\Models\country;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            User::class,
        ]);
        country::factory()
            ->count(5)
            ->create();
        city::factory()
            ->count(5)
            ->create();
        User::factory()
            ->count(20)
            ->create(
                [
                    'country_id'=>country::factory(),
                    'city_id'=>city::factory(),
                ]
            );
    }
}
