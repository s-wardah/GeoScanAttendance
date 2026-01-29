<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Schedule::create([
            'user_id'       => 3, // Pastikan ID guru benar
            'room_id'       => 1, // Pastikan ID ruangan benar
            'subject'       => 'Matematika',
            'day'           => now()->format('l'), // Otomatis hari ini biar bisa dites langsung
            'start_time' => '06:00:00',
            'end_time'   => '23:59:00',
            'academic_year' => '2025/2026',
            'semester'      => 'Even',
            'is_active'     => true,
        ]);
    }
}
