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
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price');
            $table->enum('semester', ['first', 'second']);
            $table->foreignId('category_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('education_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->date('expired_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundles');
    }
};
