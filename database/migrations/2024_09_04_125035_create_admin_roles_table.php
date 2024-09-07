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
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['students', 'teachers', 'admins', 'categories',
            'subjects', 'bundles', 'questions', 'hw', 'revisions', 'exams', 'live',
            'discounts', 'promocode', 'pop up', 'reviews', 'payments', 'affilate', 
            'support', 'reports', 'settings', 'notice board',
            'chapters', 'lessons', 'admin_roles']);
            $table->foreignId('admin_position_id')->nullable()->constrained('admin_positions')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_roles');
    }
};
