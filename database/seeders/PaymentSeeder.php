<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Payment;
use App\Models\User;
use App\Models\PaymentMethod;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::factory()
        ->count(20)
        ->create([
            'student_id' => User::factory()->create(['role' => 'student'])->id,
            'payment_method_id' => PaymentMethod::factory(),
        ]);
    }
}
