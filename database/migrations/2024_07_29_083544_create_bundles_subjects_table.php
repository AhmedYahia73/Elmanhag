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
        Schema::create('bundles_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('subject_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundles_subjects');
    }
};
