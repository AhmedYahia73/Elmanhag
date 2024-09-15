<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seen_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homework_id')->nullable()->constrained('homework')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('live_id')->nullable()->constrained('lives')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('student_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seen_notifications');
    }
};
