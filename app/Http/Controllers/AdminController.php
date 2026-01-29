<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Halaman Kelola Guru
    public function teacherIndex() {
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    // Simpan Guru Baru (PNS/Honorer)
    public function teacherStore(Request $request) {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'role' => 'teacher',
            'employee_type' => $request->type, // pns atau honorer
            'base_salary' => $request->base_salary,
            'salary_per_presence' => $request->salary_per_presence,
        ]);
        return back()->with('success', 'Guru berhasil didaftarkan!');
    }

    // Halaman Kelola Ruangan
    public function roomIndex() {
        $rooms = Rooms::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function roomStore(Request $request) {
    $request->validate([
        'room_name' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
        'radius' => 'required|integer',
    ]);

    // Pakai model Rooms (sesuai namamu yang pakai 's')
    \App\Models\Rooms::create([
        'room_name' => $request->room_name,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'radius' => $request->radius,
        'qr_content' => 'QR-' . strtoupper(\Illuminate\Support\Str::random(8)), // Bikin kode unik
    ]);

    return back()->with('success', 'Ruangan dan QR Code berhasil dibuat!');
}
    public function payrollIndex()
    {
        $teachers = \App\Models\User::where('role', 'teacher')->get();

        $payrollData = $teachers->map(function($teacher) {
            $attendanceCount = \App\Models\Attendances::where('user_id', $teacher->id)
                                ->whereMonth('created_at', now()->month)
                                ->count();
            
            if ($teacher->employee_type == 'pns') {
                $totalGaji = $teacher->base_salary;
            } else {
                $totalGaji = $attendanceCount * $teacher->salary_per_presence;
            }

            return [
                'name' => $teacher->name,
                'tyoe' => $teacher->employee_type,
                'hadir' => $attendanceCount,
                'total' => $totalGaji
            ];
        });
        return view('admin.payroll.index', compact('payrollData'));
    }
}