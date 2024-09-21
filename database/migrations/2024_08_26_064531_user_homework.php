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
         Schema::create('users_homework', function (Blueprint $table) {
         $table->id();
         $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
         $table->foreignId('lesson_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
         $table->foreignId('homework_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
         $table->integer('score');
         $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_homework');
    }
};
