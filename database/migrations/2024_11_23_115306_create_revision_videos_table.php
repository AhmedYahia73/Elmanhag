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
        Schema::create('revision_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('revision_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('file');
            $table->enum('type', ['video', 'pdf']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revision_videos');
    }
};
