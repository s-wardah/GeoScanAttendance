@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-lg-4">
    <div class="row align-items-center mb-4">
        <div class="col-auto">
            <div class="bg-indigo p-3 rounded-4 shadow-sm">
                <i class="bi bi-grid-1x2-fill text-white fs-4"></i>
            </div>
        </div>
        <div class="col">
            <h4 class="fw-bold text-slate-900 mb-0">System Overview</h4>
            <p class="text-muted small mb-0">Selamat datang kembali, Administrator. Berikut adalah ringkasan hari ini.</p>
        </div>
        <div class="col-12 col-md-auto mt-3 mt-md-0">
            <div class="btn-group shadow-sm">
                <button class="btn btn-white border-0 py-2 px-3 small fw-bold">Daily</button>
                <button class="btn btn-white border-0 py-2 px-3 small fw-bold text-muted">Weekly</button>
                <button class="btn btn-white border-0 py-2 px-3 small fw-bold text-muted">Monthly</button>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        @php
            $cards = [
                ['label' => 'Guru Hadir', 'value' => $stats['today_presents'], 'icon' => 'bi-check2-circle', 'color' => '#6366f1', 'trend' => '+12%'],
                ['label' => 'Total Ruangan', 'value' => $stats['total_rooms'], 'icon' => 'bi-building', 'color' => '#64748b', 'trend' => 'Stable'],
                ['label' => 'Pegawai PNS', 'value' => $stats['total_pns'], 'icon' => 'bi-person-badge', 'color' => '#0ea5e9', 'trend' => 'Active'],
                ['label' => 'Guru Honorer', 'value' => $stats['total_honorer'], 'icon' => 'bi-person-workspace', 'color' => '#f59e0b', 'trend' => 'Active'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm overflow-hidden card-hover" style="border-radius: 1rem;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: {{ $card['color'] }}15;">
                            <i class="bi {{ $card['icon'] }} fs-5" style="color: {{ $card['color'] }};"></i>
                        </div>
                        <span class="badge bg-light text-muted border-0 fw-medium">{{ $card['trend'] }}</span>
                    </div>
                    <h6 class="text-muted small fw-bold text-uppercase mb-1" style="letter-spacing: 0.5px;">{{ $card['label'] }}</h6>
                    <h3 class="fw-extrabold mb-0 text-slate-900">{{ $card['value'] }}</h3>
                </div>
                <div style="height: 4px; background: {{ $card['color'] }}; opacity: 0.3;"></div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 1.25rem;">
                <h6 class="fw-bold mb-4 text-slate-800">Quick Operations</h6>
                <div class="row g-4">
                    <div class="col-md-4">
                        <a href="/admin/teachers" class="text-decoration-none group">
                            <div class="p-4 rounded-4 border border-dashed text-center transition-all hover-indigo">
                                <div class="icon-box-lg bg-indigo text-white mx-auto mb-3 shadow-indigo">
                                    <i class="bi bi-people fs-4"></i>
                                </div>
                                <h6 class="fw-bold text-slate-900 mb-1">Database Guru</h6>
                                <p class="small text-muted mb-0">Manajemen data & profil</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/admin/rooms" class="text-decoration-none group">
                            <div class="p-4 rounded-4 border border-dashed text-center transition-all hover-indigo">
                                <div class="icon-box-lg bg-dark text-white mx-auto mb-3 shadow-dark">
                                    <i class="bi bi-qr-code-scan fs-4"></i>
                                </div>
                                <h6 class="fw-bold text-slate-900 mb-1">QR Infrastructure</h6>
                                <p class="small text-muted mb-0">Generate & print kode</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/admin/payroll" class="text-decoration-none group">
                            <div class="p-4 rounded-4 border border-dashed text-center transition-all hover-indigo">
                                <div class="icon-box-lg bg-success text-white mx-auto mb-3 shadow-success">
                                    <i class="bi bi-currency-dollar fs-4"></i>
                                </div>
                                <h6 class="fw-bold text-slate-900 mb-1">Financial Report</h6>
                                <p class="small text-muted mb-0">Rekapitulasi gaji bulanan</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm mt-4 overflow-hidden" style="border-radius: 1.25rem;">
                <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-slate-800">System Logs</h6>
                    <a href="#" class="small text-indigo text-decoration-none">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <tbody class="border-top-0">
                            <tr>
                                <td class="ps-4 py-3"><i class="bi bi-record-fill text-success me-2"></i> Syncing attendance data...</td>
                                <td class="text-muted small">Just now</td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3"><i class="bi bi-record-fill text-indigo me-2"></i> Payroll report generated for January</td>
                                <td class="text-muted small">2 hours ago</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 1.25rem;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4 text-slate-800">System Health</h6>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted fw-medium">GPS Accuracy</span>
                            <span class="text-indigo fw-bold">98%</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 6px;">
                            <div class="progress-bar bg-indigo shadow-none" style="width: 98%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted fw-medium">Server Uptime</span>
                            <span class="text-success fw-bold">99.9%</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 6px;">
                            <div class="progress-bar bg-success shadow-none" style="width: 99.9%"></div>
                        </div>
                    </div>

                    <div class="p-4 rounded-4 bg-slate-50 border text-center mt-4">
                        <div class="spinner-border spinner-border-sm text-indigo mb-2" role="status"></div>
                        <p class="small text-slate-600 mb-0 fw-bold">Security Monitor Active</p>
                        <p class="text-muted" style="font-size: 0.75rem;">SHA-256 Encryption Secured</p>
                    </div>

                    <div class="mt-4 pt-3 border-top text-center text-muted">
                        <small class="d-block mb-1">Current Instance Time</small>
                        <h5 class="fw-bold text-slate-900 mb-0">{{ now()->format('H:i:s') }}</h5>
                        <small style="font-size: 0.7rem;">Jakarta, Indonesia</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
    }

    .text-slate-900 { color: #0f172a; }
    .text-slate-800 { color: #1e293b; }
    .text-slate-600 { color: #475569; }
    .bg-slate-50 { background-color: #f8fafc; }
    .bg-indigo { background-color: #4f46e5; }
    .text-indigo { color: #4f46e5; }
    .shadow-indigo { box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3); }
    .shadow-success { box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3); }
    .shadow-dark { box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.3); }

    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05) !important; }

    .btn-white { background: white; border: 1px solid #e2e8f0; transition: all 0.2s; }
    .btn-white:hover { background: #f1f5f9; }

    .icon-box-lg {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .transition-all { transition: all 0.3s ease; }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; border-color: #e2e8f0 !important; }

    .hover-indigo:hover {
        border-color: #4f46e5 !important;
        background-color: #f5f3ff;
        transform: translateY(-3px);
    }

    .fw-extrabold { font-weight: 800; }
</style>
@endsection