<?php

namespace App\Http\Controllers\Headmaster;

use App\Http\Controllers\Controller;
use App\Models\Attendances;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $reports = User::where('role', 'teachers')
            ->with(['attendances' => function ($query) use ($month, $year) {
                $query->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year);
            }])->get();

        return view('headmaster.reports.index', compact('reports', 'month', 'year'));
    }

    public function listPermissions()
    {
        // Ambil data izin yang statusnya masih Pending
        $permissions = \App\Models\Permission::with('user')->where('status', 'Pending')->get();
        return view('headmaster.permission.index', compact('permissions'));
    }

    public function updatePermissionStatus(Request $request, $id)
    {
        $permission = \App\Models\Permission::findOrFail($id);
        $permission->update(['status' => $request->status]);

        if ($request->status == 'Approved') {
            \App\Models\Attendances::create([
                'user_id'       => $permission->user_id,
                'status'        => $permission->type,
                'schedule_id'   => null,
                'room_id'       => null,
                'lat_captured'  => null, 
                'long_captured' => null, 
                'created_at'    => $permission->date . ' 07:00:00',
            ]);
        }

        return back()->with('success', 'Berhasil memperbarui status izin.');
    }

    public function exportPDF(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = date('Y');

        $reports = \App\Models\User::where('role', 'teachers')
            ->with(['attendances' => function ($query) use ($month, $year) {
                $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
            }])->get();

        // Data untuk di oper ke blade PDF
        $data = [
            'reports' => $reports,
            'month' => date('F', mktime(0, 0, 0, $month, 1)),
            'year' => $year
        ];

        $pdf = Pdf::loadView('headmaster.reports.pdf', $data);

        // Download filenya
        return $pdf->download('Laporan-Kehadiran-' . date('M-Y') . '.pdf');
    }
}
