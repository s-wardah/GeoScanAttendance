@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-indigo mb-1">Manajemen Data Guru</h3>
            <p class="text-muted small mb-0">Kelola informasi kepegawaian dan konfigurasi penggajian.</p>
        </div>
        <div class="badge bg-indigo-soft text-indigo p-2 px-3 rounded-pill">
            <i class="bi bi-person-check-fill me-1"></i> Total: {{ $teachers->count() }} Guru
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px; border-radius: 1.25rem;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-indigo text-white rounded-3 p-2 me-3">
                            <i class="bi bi-person-plus-fill fs-5"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Daftarkan Guru</h5>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    <form action="{{ route('admin.teachers.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="name" class="form-control bg-light border-0" placeholder="Nama tanpa gelar..." required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2">Email Guru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-0" placeholder="guru@sekolah.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2">Tipe Pegawai</label>
                            <select name="type" id="typeSelector" class="form-select bg-light border-0">
                                <option value="pns">PNS (Gaji Tetap)</option>
                                <option value="honorer">Honorer (Per Kehadiran)</option>
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 mb-3" id="salaryGroup">
                                <label class="small fw-bold text-muted mb-2">Gaji Pokok (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">Rp</span>
                                    <input type="number" name="base_salary" class="form-control bg-light border-0" placeholder="0">
                                </div>
                            </div>

                            <div class="col-12" id="honorGroup" style="display:none;">
                                <label class="small fw-bold text-muted mb-2">Honor / Kehadiran (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">Rp</span>
                                    <input type="number" name="salary_per_presence" class="form-control bg-light border-0" placeholder="0">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-indigo w-100 py-2 shadow-sm mt-2" style="border-radius: 10px;">
                            <i class="bi bi-save2 me-2"></i>Simpan Data Guru
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 1.25rem; overflow: hidden;">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-0">Daftar Aktif</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3">Info Guru</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Komponen Gaji</th>
                                <th class="py-3 text-end px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $t)
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-indigo-soft text-indigo rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold">
                                            {{ substr($t->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $t->name }}</div>
                                            <small class="text-muted">{{ $t->email ?? 'Belum ada email' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $t->employee_type == 'pns' ? 'bg-indigo-soft text-indigo' : 'bg-success-soft text-success' }} px-3 py-2 rounded-pill">
                                        {{ strtoupper($t->employee_type) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small">
                                        <span class="text-muted d-block">Pokok: <span class="text-dark fw-bold">Rp{{ number_format($t->base_salary, 0, ',', '.') }}</span></span>
                                        <span class="text-muted d-block">Honor: <span class="text-dark fw-bold">Rp{{ number_format($t->salary_per_presence, 0, ',', '.') }}</span></span>
                                    </div>
                                </td>
                                <td class="text-end px-4">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-pill shadow-none" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm p-2">
                                            <li><a class="dropdown-item rounded-3" href="#"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item rounded-3 text-danger" href="#"><i class="bi bi-trash me-2"></i> Hapus</a></li>
                                        </ul>
                                    </div>
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
    :root {
        --indigo-color: #1E1B4B;
        --indigo-soft: #eef2ff;
        --success-soft: #ecfdf5;
    }

    .text-indigo {
        color: var(--indigo-color);
    }

    .bg-indigo {
        background-color: var(--indigo-color);
    }

    .btn-indigo {
        background-color: var(--indigo-color);
        color: white;
        transition: 0.3s;
    }

    .btn-indigo:hover {
        background-color: #312E81;
        color: white;
    }

    .bg-indigo-soft {
        background-color: var(--indigo-soft);
    }

    .bg-success-soft {
        background-color: var(--success-soft);
    }

    .avatar-sm {
        width: 40px;
        height: 40px;
    }

    .tracking-wider {
        letter-spacing: 0.05rem;
    }

    /* Form Styling */
    .form-control:focus,
    .form-select:focus {
        background-color: #fff !important;
        border: 1px solid var(--indigo-color) !important;
        box-shadow: none;
    }

    .input-group-text {
        border-radius: 10px 0 0 10px;
    }

    input.form-control {
        border-radius: 0 10px 10px 0;
    }
</style>

<script>
    document.getElementById('typeSelector').addEventListener('change', function() {
        const salaryGroup = document.getElementById('salaryGroup');
        const honorGroup = document.getElementById('honorGroup');

        if (this.value === 'pns') {
            salaryGroup.style.display = 'block';
            honorGroup.style.display = 'none';
        } else {
            salaryGroup.style.display = 'none';
            honorGroup.style.display = 'block';
        }
    });
</script>
@endsection