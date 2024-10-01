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
        Schema::table('admin_roles', function (Blueprint $table) {
            Schema::table('admin_roles', function (Blueprint $table) {
                $table->enum('role', ['students', 'teachers', 'admins', 'categories',
                'subjects', 'bundles', 'questions', 'hw', 'revisions', 'exams', 'live',
                'discounts', 'promocode', 'pop up', 'reviews', 'payments', 'affilate', 
                'support', 'reports', 'settings', 'notice board', 'parent', 'material',
                'chapters', 'lessons', 'admin_roles', 'complaint', 'issues'])->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_roles', function (Blueprint $table) {
            Schema::table('admin_roles', function (Blueprint $table) {
                $table->enum('role', ['students', 'teachers', 'admins', 'categories',
                'subjects', 'bundles', 'questions', 'hw', 'revisions', 'exams', 'live',
                'discounts', 'promocode', 'pop up', 'reviews', 'payments', 'affilate', 
                'support', 'reports', 'settings', 'notice board',
                'chapters', 'lessons', 'admin_roles', 'complaint', 'issues'])->change();
            });
        });
    }
};
