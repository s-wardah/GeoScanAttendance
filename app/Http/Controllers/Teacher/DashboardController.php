<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan Daftar Riwayat Izin (Index Permission)
     */
    public function indexPermission()
    {
        // Mengambil semua data izin milik guru yang sedang login
        $permissions = Permission::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->get();

        return view('teacher.permission.index', compact('permissions'));
    }

    /**
     * Menampilkan Halaman Form Pengajuan (Create Permission)
     */
    public function createPermission()
    {
        return view('teacher.permission.create');
    }

    /**
     * Memproses Simpan Data Izin
     */
    public function storePermission(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:Izin,Sakit',
            'reason' => 'required|string|max:1000',
            'attachment' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->only(['date', 'type', 'reason']);
        $data['user_id'] = auth()->id();
        $data['status'] = 'Pending'; // Otomatis berstatus pending

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('permissions', 'public');
        }

        Permission::create($data);

        // Redirect kembali ke halaman INDEX PERMISSION dengan pesan sukses
        return redirect()->route('teacher.permission.index')
            ->with('success', 'Pengajuan izin berhasil dikirim!');
    }
}