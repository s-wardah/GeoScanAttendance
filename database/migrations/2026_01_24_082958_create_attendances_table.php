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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->timestamp('check_in_time')->useCurrent(); 
            $table->decimal('lat_captured', 10, 8);
            $table->decimal('long_captured', 11, 8);
            $table->integer('distance_from_target'); 
            $table->enum('status', ['Hadir', 'Terlambat', 'Izin', 'Gagal'])->default('Hadir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
