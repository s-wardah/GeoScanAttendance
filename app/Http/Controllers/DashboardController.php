<?php

namespace App\Http\Controllers;

// WAJIB ADA: Panggil model agar tidak error "Class not found"
use App\Models\User;
use App\Models\Rooms;
use App\Models\Attendances;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user) return redirect()->route('login');

        $role = $user->role; // Sesuai database: admin, headmaster, teachers

        // 1. DASHBOARD ADMIN
        if ($role == 'admin') {
            $stats = [
                'total_teachers' => User::where('role', 'teachers')->count(), // Pakai s
                'total_rooms'    => Rooms::count(),
                'today_presents' => Attendances::whereDate('created_at', now())->count(),
                'total_pns'      => User::where('employee_type', 'pns')->count(),
                'total_honorer'  => User::where('employee_type', 'honorer')->count(),
            ];
            return view('admin.dashboard', compact('stats'));
        }

        // 2. DASHBOARD HEADMASTER (Kepsek)
        if ($role == 'headmaster') {
            $stats = [
                'total_guru' => User::where('role', 'teachers')->count(), // Pakai s
                'hadir_hari_ini' => Attendances::whereDate('created_at', now())->count(),
                'total_pengeluaran_gaji' => $this->calculateTotalPayroll(),
            ];

            $recent_attendances = Attendances::with(['user', 'room'])
                ->latest()
                ->take(5) 
                ->get();

            return view('headmaster.dashboard', compact('stats', 'recent_attendances'));
        }

        // 3. DASHBOARD TEACHERS (Guru)
        if ($role == 'teachers') {
            return view('teacher.dashboard');
        }

        return abort(403, 'Role "' . $role . '" tidak terdaftar di sistem.');
    }

    // Fungsi pembantu agar tidak error "Method not found"
    private function calculateTotalPayroll()
    {
        $pns_salary = User::where('employee_type', 'pns')->sum('base_salary');
        $honorer_salary = Attendances::whereMonth('created_at', now()->month)->count() * 50000;
        return $pns_salary + $honorer_salary;
    }
}
