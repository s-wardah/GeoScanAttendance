<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'employee_type' => 'required|in:pns,honorer',
            'base_salary' => 'nullable|numeric',
            'salary_per_presence' => 'nullable|numeric',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt('password123'),
            'role' => 'teachers',
            'employee_type' => $validated['employee_type'], 
            'base_salary' => $request->base_salary ?? 0,
            'salary_per_presence' => $request->salary_per_presence ?? 0,
        ]);

        return back()->with('success', 'Guru berhasil didaftarkan!');
    }
}
