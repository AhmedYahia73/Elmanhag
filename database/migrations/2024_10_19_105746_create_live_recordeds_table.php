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
        Schema::create('live_recordeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('chapter_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('lesson_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->boolean('paid')->default(1);
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_recordeds');
    }
};
