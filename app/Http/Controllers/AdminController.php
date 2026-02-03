<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class AdminController extends Controller
{
    public function teacherIndex()
    {
        set_time_limit(300);

        try {
            // 1. Tembak API Zielabs
            $response = Http::timeout(5)->get('https://zieapi.zielabs.id/api/getguru?tahun=2025');

            if ($response->successful()) {
                $apiData = $response->json();
                $teachersFromApi = $apiData['data'] ?? $apiData;

                foreach ($teachersFromApi as $item) {
                    // 1. Cek dulu apakah user sudah ada di database?
                    $email = $item['email'] ?? strtolower(str_replace(' ', '', $item['nama'])) . '@zielabs.id';
                    $userExist = User::where('email', $email)->exists();

                    $nip = $item['nip'] ?? null;

                    User::updateOrCreate(
                        ['email' => $email],
                        [
                            'name' => $item['nama'],
                            'nip' => $nip,
                            'role' => 'teachers',
                            'employee_type' => ($nip && strlen($nip) >= 18) ? 'pns' : 'honorer',
                            'password' => $userExist ? $existingPassword : Hash::make('password123'),
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            // Jika internet mati/API down, tetap lanjut menampilkan data yang ada di DB
        }

        $teachers = User::where('role', 'teachers')->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    // Simpan Guru Baru
    public function teacherStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'employee_type' => 'required|in:pns,honorer',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'role' => 'teachers',
            'employee_type' => $request->employee_type,
            'base_salary' => $request->base_salary ?? 0,
            'salary_per_presence' => $request->salary_per_presence ?? 0,
        ]);

        return back()->with('success', 'Guru berhasil didaftarkan!');
    }

    // Halaman Kelola Ruangan
    public function roomIndex()
    {
        $rooms = Rooms::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function roomStore(Request $request)
    {
        $request->validate([
            'room_name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius' => 'required|integer',
        ]);


        \App\Models\Rooms::create([
            'room_name' => $request->room_name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
            'qr_content' => 'QR-' . strtoupper(\Illuminate\Support\Str::random(8)), // Bikin kode unik
        ]);

        return back()->with('success', 'Ruangan dan QR Code berhasil dibuat!');
    }

    public function roomUpdate(Request $request, $id)
    {
        $room = \App\Models\Rooms::findOrFail($id);
        $room->update($request->all());
        return back()->with('success', 'Infrastruktur berhasil diperbarui!');
    }

    public function roomDestroy($id)
    {
        $room = \App\Models\Rooms::findOrFail($id);
        $room->delete();
        return back()->with('success', 'Titik berhasil dihapus!');
    }

    // Print QR (Hanya contoh logika)
    public function roomPrint($id)
    {
        $room = Rooms::findOrFail($id);
        // Logika print biasanya mengarahkan ke view khusus cetak QR
        return view('admin.rooms.print_qr', compact('room'));
    }

    public function payrollIndex()
    {

        $teachers = \App\Models\User::where('role', 'teachers')->get();

        $payrollData = $teachers->map(function ($teacher) {
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
                'type' => $teacher->employee_type,
                'hadir' => $attendanceCount,
                'total' => $totalGaji
            ];
        });

        return view('admin.payroll.index', compact('payrollData'));
    }
}
