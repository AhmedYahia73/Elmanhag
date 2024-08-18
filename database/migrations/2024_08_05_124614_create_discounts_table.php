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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('subject_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('bundle_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->float('amount');
            $table->enum('type', ['precentage', 'value']);
            $table->string('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('statue');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
