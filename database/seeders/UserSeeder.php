<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        \App\Models\User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Guru PNS
        \App\Models\User::create([
            'name' => 'Guru PNS',
            'email' => 'pns@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'teachers',
            'employee_type' => 'pns',
            'base_salary' => 4000000,
            'salary_per_presence' => 10000,
        ]);

        // Guru Honorer
        \App\Models\User::create([
            'name' => 'Guru Honorer',
            'email' => 'guru@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'teachers',
            'employee_type' => 'honorer',
            'base_salary' => 0,
            'salary_per_presence' => 50000,
        ]);

        // Kepala Sekolah
        \App\Models\User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'headmaster@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'headmaster',
        ]);

        // Rooms
        \App\Models\Rooms::create([
            'room_name' => 'Lab Komputer RPL',
            'latitude' => -6.200000,
            'longitude' => 106.816666,
            'radius' => 50,
            'qr_content' => 'ROOM-LABKOM-01',
        ]);

        // Class
        \App\Models\Classes::create([
            'class_name' => 'XII RPL 1',
        ]);
    }
}
