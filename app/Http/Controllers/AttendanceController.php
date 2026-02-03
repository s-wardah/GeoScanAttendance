<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rooms;
use App\Models\Attendances;
use App\Models\Schedule;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = auth()->user();
            $qrContent = $request->qr_content;
            $userLat = $request->lat;
            $userLng = $request->lng;

            // 1. Validasi Ruangan via QR
            $room = Rooms::where('qr_content', $qrContent)->first();
            if (!$room) {
                return response()->json(['message' => 'QR Code Tidak Valid!'], 404);
            }

            // 2. Cek Radius (Geo-fencing)
            $distance = $this->calculateDistance($userLat, $userLng, $room->latitude, $room->longitude);
            $tolerance = 10;
            if ($distance > ($room->radius + $tolerance)) {
                return response()->json([
                    'message' => 'Di luar radius! Jarak: ' . round($distance) . 'm. Anda butuh mendekat ' . round($distance - $room->radius) . 'm lagi.'
                ], 403);
            }

            // 3. CARI JADWAL YANG COCOK (LOGIC BARU)
            $today = now()->format('l'); // Mengambil hari Inggris: Monday, Tuesday, dst.
            $currentTime = now()->format('H:i:s');

            $schedule = Schedule::where('user_id', $user->id)
                ->where('day', $today)
                ->where('is_active', true)
                ->where('start_time', '<=', $currentTime)
                ->where('end_time', '>=', $currentTime)
                ->first();

            // Jika tidak ada jadwal yang pas, tolak absensi
            if (!$schedule) {
                return response()->json([
                    'message' => 'Gagal! Tidak ada jadwal aktif untuk Anda saat ini (Hari: ' . $today . ', Jam: ' . $currentTime . ').'
                ], 403);
            }

            // 4. Simpan Absensi (Gunakan nama kolom sesuai Migration)
            Attendances::create([
                'user_id'              => $user->id,
                'room_id'              => $room->id,
                'schedule_id'          => $schedule->id,
                'lat_captured'         => $userLat,
                'long_captured'        => $userLng,
                'status'               => 'Hadir',
                'distance_from_target' => round($distance),
                'check_in_time'        => now(),
            ]);

            return response()->json(['message' => 'Absensi Berhasil! Matapelajaran: ' . $schedule->subject]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
        }
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function history()
    {
        $attendances = auth()->user()->attendances()
            ->with(['room', 'schedule']) // Load relasi biar ga berat (Eager Loading)
            ->latest() // Data terbaru di atas
            ->get();

        return view('teacher.history', compact('attendances'));
    }

    public function PaySlip()
    {
        $user = auth()->user();

        $presentCount = $user->attendances()
            ->whereMonth('created_at', now()->month)
            ->where('status', 'Hadir')
            ->count();

        $tunjanganJabatan = ($user->employee_type == 'pns') ? 500000 : 0;
        $totalHonor = $presentCount * $user->salary_per_presence;
        $totalGaji = ($user->base_salary ?? 0) + $totalHonor + $tunjanganJabatan;

        return view('teacher.payroll', compact('user', 'presentCount', 'totalHonor', 'totalGaji', 'tunjanganJabatan'));
    }
}
