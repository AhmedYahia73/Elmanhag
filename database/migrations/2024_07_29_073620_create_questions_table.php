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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('image');
            $table->string('audio');
            $table->boolean('status')->default(1);
            $table->foreignId('category_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('subject_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('chapter_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lesson_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('semester', ['first', 'second']);
            $table->char('difficulty', 1)->nullable();
            $table->enum('answer_type', ['Mcq', 'T/F', 'Join', 'Essay']);
            $table->enum('question_type', ['text', 'image', 'audio']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
