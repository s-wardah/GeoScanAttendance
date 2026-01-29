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
        Schema::create('payrolls', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('month'); 
        $table->integer('year');
        $table->integer('total_attendance')->default(0);
        $table->decimal('total_amount', 12, 2)->default(0);
        $table->enum('status', ['pending', 'paid'])->default('pending');
        $table->timestamp('payment_date')->nullable();
        $table->string('academic_year');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
