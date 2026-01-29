@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-lg-4">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold mb-1" style="color: #1E1B4B;">Monitoring Eksekutif</h3>
            <p class="text-muted small">Overview kehadiran dan estimasi anggaran operasional.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg overflow-hidden position-relative" 
                 style="background: linear-gradient(135deg, #1E1B4B 0%, #3f3da1 100%); border-radius: 1.5rem; color: white;">
                
                <div class="position-absolute rounded-circle bg-white opacity-10"
                    style="width: 250px; height: 250px; top: -70px; right: -50px;"></div>
                <div class="position-absolute rounded-circle bg-warning opacity-10"
                    style="width: 120px; height: 120px; bottom: -30px; left: 30px;"></div>

                <div class="card-body p-5 position-relative z-index-1">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <p class="text-uppercase fw-bold tracking-wider opacity-75 mb-2" style="font-size: 0.85rem;">
                                <i class="bi bi-wallet2 me-2 text-warning"></i>Estimasi Pengeluaran Gaji Bulan Ini
                            </p>
                            <h1 class="fw-bold mb-0" style="font-size: 3.5rem;">
                                <span class="fs-2 text-warning fw-normal">Rp</span>{{ number_format($stats['total_pengeluaran_gaji'], 0, ',', '.') }}
                            </h1>
                            <p class="mt-2 opacity-50 mb-0 small">Data diperbarui otomatis berdasarkan akumulasi kehadiran harian.</p>
                        </div>

                        <div class="col-md-4 text-md-end mt-4 mt-md-0">
                            <div class="d-inline-block p-4 rounded-4 backdrop-blur shadow-sm border border-white-10" style="background: rgba(255,255,255,0.1); min-width: 220px;">
                                <small class="d-block opacity-75 mb-1 fw-bold text-uppercase">Hadir Hari Ini</small>
                                <div class="d-flex align-items-center justify-content-md-end">
                                    <h2 class="fw-bold mb-0 text-warning me-2" style="font-size: 2.5rem;">{{ $stats['hadir_hari_ini'] }}</h2>
                                    <span class="fs-5 text-white">Guru</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm p-4 hover-shadow transition" style="border-radius: 1.5rem;">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-bold mb-0" style="color: #1E1B4B;">Log Aktivitas Kehadiran</h5>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success-soft text-success p-2 px-3 rounded-pill small me-2">
                             <span class="spinner-grow spinner-grow-sm me-1" role="status"></span> Active
                        </span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="text-muted extra-small text-uppercase fw-bold tracking-wider">
                            <tr class="border-bottom">
                                <th class="border-0 ps-3 py-3">Nama Guru</th>
                                <th class="border-0">Ruangan / Kelas</th>
                                <th class="border-0 text-center">Waktu Scan</th>
                                <th class="border-0 text-end pe-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_attendances as $at)
                            <tr class="transition border-bottom">
                                <td class="ps-3 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-indigo-soft text-indigo rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 40px; height: 40px;">
                                            {{ substr($at->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mb-0">{{ $at->user->name }}</div>
                                            <div class="text-muted extra-small">ID: #{{ $at->user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted small"><i class="bi bi-geo-alt-fill me-1 text-indigo"></i>{{ $at->room->room_name }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="badge bg-light text-dark fw-medium rounded-pill px-3 py-2 border">
                                        <i class="bi bi-clock me-1 text-indigo"></i>{{ $at->created_at->format('H:i') }} WIB
                                    </div>
                                </td>
                                <td class="text-end pe-3">
                                    <span class="badge bg-success shadow-sm px-3 py-2 rounded-pill" style="font-size: 0.7rem;">
                                        HADIR
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .extra-small { font-size: 0.75rem; }
    .bg-indigo-soft { background-color: #f0f3ff; }
    .text-indigo { color: #3f3da1; }
    .bg-success-soft { background-color: #ecfdf5; }
    .text-success { color: #059669; }
    .backdrop-blur { backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
    .border-white-10 { border-color: rgba(255, 255, 255, 0.1) !important; }
    .tracking-wider { letter-spacing: 1px; }

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(30, 27, 75, 0.1) !important;
    }

    .transition {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Table Hover Styling */
    tbody tr:hover {
        background-color: #fafaff;
    }
</style>
@endsection