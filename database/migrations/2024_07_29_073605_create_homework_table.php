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
        Schema::create('homework', function (Blueprint $table) {
            $table->id();
            $table->enum('title', ['H.W1', 'H.W2', 'H.W3']);
            $table->enum('semester', ['first', 'second']);
            $table->foreignId('category_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('subject_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('chapter_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('lesson_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->enum('difficulty', ['A', 'B', 'C']);
            $table->float('mark');
            $table->float('pass');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homework');
    }
};
