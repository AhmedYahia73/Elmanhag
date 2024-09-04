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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('image')->nullable()->default('default.png');
            $table->enum('role',['supAdmin','admin','teacher','parent','student', 'affilate']);
            $table->enum('gender',['mail','femail']);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->foreignId('parent_relation_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->string('password');
            $table->string('affilate_code')->nullable();
            $table->foreignId('admin_position_id')->nullable()->constrained('admin_positions')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('parent_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('education_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('affilate_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('sudent_job_id')->nullable()->constrained('student_jobs');
            $table->boolean('status')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
