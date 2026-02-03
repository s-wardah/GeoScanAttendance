<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Classes::insert([
            ['class_name' => 'X-RPL 1'],
            ['class_name' => 'XI-RPL 1'],
            ['class_name' => 'XII-RPL 1'],
        ]);
    }
}
