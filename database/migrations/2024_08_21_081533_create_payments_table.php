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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->enum('service', ['Live session', 'Bundle', 'Subject', 'Live Package', 'Revision']);
            $table->foreignId('student_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('payment_method_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->string('receipt')->nullable();
            $table->string('rejected_reason')->nullable();
            $table->date('purchase_date');
            $table->string('merchantRefNum');
            $table->boolean('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
