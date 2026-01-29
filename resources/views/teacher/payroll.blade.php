@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
                <div>
                    <h3 class="fw-bold text-indigo mb-0">Slip Gaji Digital</h3>
                    <p class="text-muted small">Anda dapat mengunduh atau mencetak slip ini</p>
                </div>
                <button onclick="window.print()" class="btn btn-indigo px-4 shadow-sm">
                    <i class="bi bi-printer me-2"></i> Cetak Slip Gaji
                </button>
            </div>

            <div class="card shadow-lg border-0 position-relative overflow-hidden p-0" style="border-radius: 2rem;">
                <div style="height: 12px; background: linear-gradient(to right, #1E1B4B, #3f3da1);"></div>

                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center mb-5">
                        <div class="col-sm-7 text-center text-sm-start mb-3 mb-sm-0">
                            <div class="d-flex align-items-center justify-content-center justify-content-sm-start">
                                <img src="{{ asset('image/geoscan_logo.png') }}" alt="Logo" class="me-3" style="height: 50px;">
                                <div>
                                    <h4 class="fw-bold mb-0 text-indigo">GEOSCAN</h4>
                                    <p class="text-muted small mb-0">Sistem Absensi & Penggajian Digital</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-end">
                            <div class="bg-light p-3 rounded-4 border">
                                <h6 class="fw-bold text-uppercase small text-muted mb-1">Periode Gaji</h6>
                                <p class="fw-bold text-indigo mb-0">{{ now()->translatedFormat('F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-5">
                        <div class="col-6 col-md-3">
                            <small class="text-muted d-block text-uppercase fw-bold tracking-wider" style="font-size: 0.65rem;">Nama Lengkap</small>
                            <span class="fw-bold text-dark">{{ $user->name }}</span>
                        </div>
                        <div class="col-6 col-md-3 text-sm-center">
                            <small class="text-muted d-block text-uppercase fw-bold tracking-wider" style="font-size: 0.65rem;">ID Guru</small>
                            <span class="fw-bold text-dark">#TR-{{ $user->id }}</span>
                        </div>
                        <div class="col-6 col-md-3 text-sm-center">
                            <small class="text-muted d-block text-uppercase fw-bold tracking-wider" style="font-size: 0.65rem;">Status Pegawai</small>
                            <span class="badge bg-indigo-soft text-indigo px-3">{{ strtoupper($user->employee_type) }}</span>
                        </div>
                        <div class="col-6 col-md-3 text-end">
                            <small class="text-muted d-block text-uppercase fw-bold tracking-wider" style="font-size: 0.65rem;">Tanggal Cetak</small>
                            <span class="text-dark">{{ now()->format('d M Y') }}</span>
                        </div>
                    </div>

                    <div class="position-absolute start-50 top-50 translate-middle opacity-05 z-index-0 pointer-events-none">
                        <img src="{{ asset('image/geoscan_logo.png') }}" style="width: 300px; filter: grayscale(100%);">
                    </div>

                    <div class="position-relative z-index-1">
                        <h6 class="fw-bold text-indigo mb-3 flex-grow-1 border-bottom pb-2">Rincian Pendapatan (Earnings)</h6>
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle">
                                <thead>
                                    <tr class="text-muted small text-uppercase tracking-widest border-bottom">
                                        <th class="py-3 fw-bold">Deskripsi</th>
                                        <th class="py-3 text-end fw-bold">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-3">
                                            <div class="fw-bold text-dark">Gaji Pokok</div>
                                            <small class="text-muted">Gaji standar sesuai posisi {{ $user->employee_type }}</small>
                                        </td>
                                        <td class="py-3 text-end fw-bold text-dark">Rp {{ number_format($user->base_salary, 0, ',', '.') }}</td>
                                    </tr>

                                    @if($user->employee_type == 'pns')
                                    <tr>
                                        <td class="py-3">
                                            <div class="fw-bold text-dark">Tunjangan Jabatan</div>
                                            <small class="text-muted">Tunjangan fungsional PNS</small>
                                        </td>
                                        <td class="py-3 text-end fw-bold text-dark">Rp {{ number_format($tunjanganJabatan, 0, ',', '.') }}</td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td class="py-3">
                                            <div class="fw-bold text-dark">Insentif Kehadiran</div>
                                            <small class="text-muted">{{ $presentCount }} kehadiran x Rp {{ number_format($user->salary_per_presence, 0, ',', '.') }}</small>
                                        </td>
                                        <td class="py-3 text-end fw-bold text-dark">Rp {{ number_format($totalHonor, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="border-top" style="background: #fcfcfd;">
                                        <td class="py-4 fw-extrabold fs-5 text-indigo">TOTAL GAJI BERSIH (TAKE HOME PAY)</td>
                                        <td class="py-4 text-end fw-extrabold fs-4 text-indigo">
                                            Rp {{ number_format($totalGaji, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="mt-5 pt-4">
                        <div class="row align-items-end">
                            <div class="col-7">
                                <div class="p-3 rounded-3 bg-light border-start border-4 border-indigo">
                                    <p class="small text-muted mb-0"><strong>Catatan:</strong></p>
                                    <p class="small text-muted mb-0">Slip gaji ini adalah bukti pembayaran yang sah. Mohon disimpan dengan baik.</p>
                                </div>
                            </div>
                            <div class="col-5 text-center">
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
</div>

<style>
    /* Warna Kustom Tetap */
    :root { --indigo-color: #1E1B4B; }
    .text-indigo { color: var(--indigo-color); }
    .btn-indigo { background-color: var(--indigo-color); color: white; }
    .bg-indigo-soft { background-color: #eef2ff; }
    .fw-extrabold { font-weight: 800; }
    .opacity-05 { opacity: 0.05; }
    .tracking-wider { letter-spacing: 0.05rem; }

    /* --- LOGIKA PRINT AGAR 1 HALAMAN --- */
    @media print {
        @page {
            size: A4;
            margin: 10mm; /* Margin kertas dipersempit biar muat */
        }

        /* Sembunyikan SEMUA elemen dashboard selain area konten utama */
        nav, .navbar, #sidebar, .sidebar, footer, .btn, .d-print-none, .breadcrumb {
            display: none !important;
        }

        /* Paksa body dan container pakai lebar penuh tanpa scroll */
        body, html {
            height: auto;
            background: #fff !important;
            font-size: 11pt; /* Mengecilkan sedikit ukuran font saat print */
        }

        /* Hilangkan padding container yang bikin slip jadi lebar banget */
        .container, .container-fluid {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Modifikasi Card agar pas di kertas */
        .card {
            border: 1px solid #eee !important;
            box-shadow: none !important;
            border-radius: 0 !important; /* Biar rapi di kertas */
            width: 100% !important;
            overflow: visible !important;
        }

        .card-body {
            padding: 15mm !important; /* Beri ruang pas di kertas */
        }

        /* Pastikan tabel tidak terpotong */
        .table {
            width: 100% !important;
        }

        /* Hilangkan watermark saat print jika bikin lambat/berbayang di printer murah */
        .opacity-05 {
            opacity: 0.1 !important;
        }

        /* Paksa warna muncul (Logo & Header) */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>
@endsection