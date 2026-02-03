@extends('layouts.app')

@section('content')
<div class="container-fluid p-3">

    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold mb-1" style="color: #1E1B4B;">Halo, {{ auth()->user()->name }}</h3>
            <p class="text-muted small">Semoga harimu menyenangkan dan penuh semangat mengajar!</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm p-4 text-center h-100 position-relative overflow-hidden" style="border-radius: 1.5rem;">
                <div class="mb-3 d-flex justify-content-center">
                    <div class="position-relative">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=1E1B4B&color=fff&size=100"
                            class="rounded-circle shadow-sm border border-white" style="width: 90px;">
                        <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle" style="width: 18px; height: 18px;"></span>
                    </div>
                </div>
                <h5 class="fw-bold mb-1" style="color: #1E1B4B;">{{ auth()->user()->name }}</h5>
                <p class="text-muted extra-small mb-3">NIP: #TR-{{ auth()->user()->id }}</p>
                <div class="d-grid">
                    <span class="badge py-2 px-3 shadow-sm" style="background: linear-gradient(45deg, #1E1B4B, #3f3da1); border-radius: 1rem; font-size: 0.75rem;">
                        {{ strtoupper(auth()->user()->employee_type) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card h-100 border-0 shadow-lg overflow-hidden position-relative"
                style="background: linear-gradient(135deg, #1E1B4B 0%, #3f3da1 100%); border-radius: 1.5rem; color: white;">

                <div class="position-absolute rounded-circle bg-white opacity-10"
                    style="width: 300px; height: 300px; top: -100px; right: -80px;"></div>
                <div class="position-absolute rounded-circle bg-warning opacity-10"
                    style="width: 100px; height: 100px; bottom: -20px; left: 20px;"></div>

                <div class="card-body d-flex flex-column justify-content-center p-5 position-relative z-index-1">
                    <h2 class="fw-bold mb-2">Sudah Siap Mengajar?</h2>
                    <p class="opacity-75 mb-4" style="max-width: 500px;">
                        Pastikan Anda sudah berada di area kelas sebelum melakukan pemindaian kehadiran.
                    </p>
                    <div>
                        <a href="/teacher/scan" class="btn btn-warning fw-bold px-5 py-3 shadow border-0 hover-scale"
                            style="border-radius: 1rem; font-size: 1rem; color: #1E1B4B; transition: all 0.3s;">
                            <i class="bi bi-qr-code-scan me-2"></i> Scan QR Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                Cek kembali isian form Anda!
            </div>
            @endif

            <div class="d-grid mb-4">
                <a href="{{ route('teacher.permission.index') }}"
                    class="btn text-white rounded-pill py-3 shadow-sm fw-bold hover-scale transition"
                    style="background: linear-gradient(135deg, #1E1B4B 0%, #3f3da1 100%); border: none;">
                    <i class="bi bi-file-earmark-plus-fill me-2"></i> Ajukan Izin / Sakit
                </a>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-4 h-100 hover-shadow transition" style="border-radius: 1.5rem; border-left: 6px solid #1E1B4B !important;">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <p class="text-muted extra-small fw-bold text-uppercase tracking-wider">Kehadiran Bulan Ini</p>
            </div>
            <div class="d-flex align-items-baseline">
                <h2 class="fw-bold mb-0" style="color: #1E1B4B; font-size: 3rem;">
                    {{ auth()->user()->attendances()->whereMonth('created_at', now()->month)->count() }}
                </h2>
                <span class="ms-2 text-muted fw-medium">Hari Hadir</span>
            </div>
            <div class="mt-3">
                <div class="progress" style="height: 8px; border-radius: 10px;">
                    <div class="progress-bar" role="progressbar" style="width: 75%; background-color: #1E1B4B;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-4 h-100 hover-shadow transition" style="border-radius: 1.5rem; border-left: 6px solid #198754 !important;">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <p class="text-muted extra-small fw-bold text-uppercase tracking-wider">Estimasi Honorarium</p>
            </div>
            @php
            $count = auth()->user()->attendances()->whereMonth('created_at', now()->month)->count();
            $total = auth()->user()->base_salary + ($count * auth()->user()->salary_per_presence);
            @endphp
            <div class="d-flex align-items-baseline">
                <span class="fs-4 fw-bold text-success me-1">Rp</span>
                <h2 class="fw-bold text-success mb-0" style="font-size: 3rem;">
                    {{ number_format($total, 0, ',', '.') }}
                </h2>
            </div>
            <p class="text-muted extra-small mt-3 italic">*Gaji pokok + total insentif kehadiran</p>
        </div>
    </div>
</div>
</div>

<style>
    .extra-small {
        font-size: 0.75rem;
    }

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2rem rgba(30, 27, 75, 0.1) !important;
    }

    .hover-scale:hover {
        transform: scale(1.02);
        filter: brightness(1.1);
    }

    .transition {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #content {
        padding: 2rem !important;
    }

    .progress-bar {
        transition: width 1.5s ease-in-out;
    }
</style>
@endsection