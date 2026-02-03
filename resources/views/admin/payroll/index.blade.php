@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-lg-4">
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <div>
            <h3 class="fw-bold text-indigo mb-0">Laporan Penggajian Digital</h3>
            <p class="text-muted small">Rekapitulasi honorarium pengajar periode {{ now()->translatedFormat('F Y') }}</p>
        </div>
        <button onclick="window.print()" class="btn btn-indigo px-4 shadow-sm">
            <i class="bi bi-printer me-2"></i> Cetak Laporan
        </button>
    </div>

    <div class="card shadow-lg border-0 position-relative overflow-hidden" style="border-radius: 2rem;">
        <div style="height: 12px; background: linear-gradient(to right, #1E1B4B, #3f3da1);"></div>

        <div class="card-body p-4 p-md-5">
            <div class="position-absolute start-50 top-50 translate-middle opacity-05 z-index-0 pointer-events-none">
                <img src="{{ asset('image/geoscan_logo.png') }}" style="width: 400px; filter: grayscale(100%);">
            </div>

            <div class="position-relative z-index-1">
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ asset('image/geoscan_logo.png') }}" alt="Logo" class="me-3" style="height: 40px;">
                    <h5 class="fw-bold text-indigo mb-0 text-uppercase tracking-wider">Rincian Pendapatan Pengajar</h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless align-middle">
                        <thead>
                            <tr class="text-muted small text-uppercase tracking-widest border-bottom">
                                <th class="py-3 fw-bold">Nama Guru</th>
                                <th class="py-3 fw-bold">Status</th>
                                <th class="py-3 text-center fw-bold">Kehadiran</th>
                                <th class="py-3 text-end fw-bold">Total Gaji</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payrollData as $data)
                            <tr class="border-bottom">
                                <td class="py-3">
                                    <div class="fw-bold text-dark">{{ $data['name'] }}</div>
                                    <small class="text-muted">Periode {{ now()->translatedFormat('M Y') }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ $data['type'] == 'pns' ? 'bg-indigo-soft text-indigo' : 'bg-light text-muted border' }} px-3 py-2 rounded-pill">
                                        {{ strtoupper($data['type']) }}
                                    </span>
                                </td>
                                <td class="text-center text-dark fw-bold">
                                    {{ $data['hadir'] }} <small class="fw-normal text-muted">Hari</small>
                                </td>
                                <td class="py-3 text-end fw-bold text-indigo fs-6">
                                    Rp {{ number_format($data['total'], 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background: #fcfcfd;">
                                <td colspan="3" class="py-4 fw-extrabold fs-5 text-indigo text-uppercase">Total Pengeluaran Kas</td>
                                <td class="py-4 text-end fw-extrabold fs-4 text-indigo">
                                    Rp {{ number_format($payrollData->sum('total'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-5 pt-4">
                    <div class="row align-items-end text-center">
                        <div class="col-7 text-start">
                            <div class="p-3 rounded-3 bg-light border-start border-4 border-indigo">
                                <p class="small text-muted mb-0"><strong>Catatan:</strong></p>
                                <p class="small text-muted mb-0">Laporan ini sah dan dihasilkan secara otomatis oleh sistem GEOSCAN.</p>
                            </div>
                        </div>
                        <div class="col-5">
                            <p class="mb-5 small text-muted">Bandung, {{ now()->translatedFormat('d F Y') }}</p>
                            <div class="mx-auto border-bottom border-dark mb-1" style="width: 150px;"></div>
                            <p class="fw-bold mb-0 text-dark">Bendahara Sekolah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root { --indigo-color: #1E1B4B; }
    .text-indigo { color: var(--indigo-color); }
    .btn-indigo { background-color: var(--indigo-color); color: white; }
    .btn-indigo:hover { background-color: #3f3da1; color: white; }
    .bg-indigo-soft { background-color: #eef2ff; }
    .fw-extrabold { font-weight: 800; }
    .opacity-05 { opacity: 0.05; }
    .tracking-widest { letter-spacing: 0.1em; }

    @media print {
        @page { size: A4; margin: 10mm; }
        nav, .navbar, #sidebar, .btn, .d-print-none { display: none !important; }
        body { background: white !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; border-radius: 0 !important; }
        .card-body { padding: 10mm !important; }
    }
</style>
@endsection