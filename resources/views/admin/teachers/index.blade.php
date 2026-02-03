@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-lg-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h3 class="fw-bold text-slate-900 mb-1">Database Guru</h3>
            <p class="text-muted small mb-0">Kelola profil kepegawaian dan konfigurasi sistem penggajian.</p>
        </div>
        <div class="col-auto d-flex gap-3">
            <div class="bg-white shadow-sm border rounded-pill px-3 py-2 d-none d-md-flex align-items-center">
                <i class="bi bi-people-fill text-indigo me-2"></i>
                <span class="small fw-bold text-slate-700">{{ $teachers->count() }} Terdaftar</span>
            </div>
            <button class="btn btn-indigo shadow-indigo rounded-3 py-2 px-4 fw-bold text-white border-0"
                data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah Guru Baru
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center">
        <i class="bi bi-check-circle-fill fs-5 me-3"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 1.25rem;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-slate-50 border-bottom">
                    <tr>
                        <th class="ps-4 py-3 text-muted small fw-bold text-uppercase">Identitas & Alamat</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Alamat</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Kontak</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Gaji</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Status</th>
                        <th class="text-end pe-4 py-3 text-muted small fw-bold text-uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($teachers as $t)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-md bg-indigo text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold shadow-sm">
                                    {{ strtoupper(substr($t->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-slate-900 mb-0">{{ $t->name }}</div>
                                    <div class="small text-slate-600">
                                        <i class="bi bi-card-heading"></i>NIP: <span class="text-indigo">{{ $t->nip ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="small text-muted text-truncate" style="max-width: 150px;" title="{{ $t->address }}">
                                <i class="bi bi-geo-alt me-1"></i>{{ $t->address ?? 'Alamat belum diset' }}
                            </div>
                        </td>
                        <td>
                            <div class="small mb-1">
                                <i class="bi bi-envelope-fill text-indigo me-1"></i>
                                <span class="text-slate-700">{{ $t->email ?? '-' }}</span>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex flex-column">
                                @if($t->employee_type == 'pns')
                                <span class="text-indigo fw-bold small mb-1"></span>
                                <span class="fw-bold text-slate-800">Rp{{ number_format($t->base_salary, 0, ',', '.') }}</span>
                                @else
                                <span class="text-amber fw-bold small mb-1"></span>
                                <span class="fw-bold text-slate-800">Rp{{ number_format($t->salary_per_presence, 0, ',', '.') }} <small class="text-muted fw-normal">/hadir</small></span>
                                @endif
                            </div>
                        </td>

                        <td>
                            <span class="badge bg-success-soft text-success border-0 px-2 py-1 rounded-pill small">
                                <i class="bi bi-check-circle-fill me-1"></i>Aktif
                            </span>
                        </td>

                        <td class="text-end pe-4">
                            <div class="btn-group gap-2">
                                <button class="btn btn-white border shadow-none rounded-pill px-3 btn-sm fw-bold"
                                    title="Detail Guru">
                                    <i class="bi bi-person-badge me-1"></i>Detail Guru
                                </button>

                                <button class="btn btn-white border shadow-none rounded-pill px-3 btn-sm text-indigo fw-bold"
                                    title="Edit Guru">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </button>

                                <form action="#" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-white border shadow-none rounded-pill px-3 btn-sm text-danger fw-bold"
                                        title="Hapus Guru">
                                        <i class="bi bi-trash3-fill me-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data guru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addTeacherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-header border-0 p-4 pb-0">
                <div class="bg-indigo-soft p-2 rounded-3 me-3">
                    <i class="bi bi-person-plus text-indigo fs-5"></i>
                </div>
                <h5 class="modal-title fw-bold text-slate-900">Registrasi Guru Baru</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.teachers.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">Nama Lengkap (Tanpa Gelar)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-slate-50 border-0"><i class="bi bi-person text-indigo"></i></span>
                            <input type="text" name="name" class="form-control bg-slate-50 border-0 py-2 shadow-none" placeholder="Contoh: Ahmad Subarjo" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-bold text-muted mb-2">Alamat Email Aktif</label>
                        <div class="input-group">
                            <span class="input-group-text bg-slate-50 border-0"><i class="bi bi-envelope-at text-indigo"></i></span>
                            <input type="email" name="email" class="form-control bg-slate-50 border-0 py-2 shadow-none" placeholder="nama@sekolah.com" required>
                        </div>
                    </div>

                    <div class="p-3 bg-indigo-soft rounded-4 mb-4">
                        <label class="small fw-bold text-indigo mb-2">Tipe & Konfigurasi Penggajian</label>
                        <select name="employee_type" id="typeSelector" class="form-select border-0 py-2 mb-3 shadow-none fw-bold text-slate-800">
                            <option value="pns">PNS (Sistem Gaji Tetap)</option>
                            <option value="honorer">HONORER (Sistem Per Kehadiran)</option>
                        </select>

                        <div id="salaryGroup">
                            <label class="small fw-bold text-muted mb-2">Gaji Pokok Bulanan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0 text-slate-400 fw-bold">Rp</span>
                                <input type="number" name="base_salary" class="form-control border-0 py-2 shadow-none fw-bold" value="0">
                            </div>
                        </div>

                        <div id="honorGroup" style="display:none;">
                            <label class="small fw-bold text-muted mb-2">Honor Per Kehadiran</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0 text-slate-400 fw-bold">Rp</span>
                                <input type="number" name="salary_per_presence" class="form-control border-0 py-2 shadow-none fw-bold" value="0">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 py-2 px-4 fw-bold text-muted" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-indigo rounded-3 py-2 px-4 fw-bold text-white shadow-indigo border-0">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    :root {
        --indigo: #4f46e5;
        --indigo-soft: #eef2ff;
        --slate-900: #0f172a;
        --slate-700: #334155;
        --slate-50: #f8fafc;
        --amber: #d97706;
        --amber-soft: #fffbeb;
    }

    .text-slate-900 {
        color: var(--slate-900);
    }

    .bg-slate-50 {
        background-color: var(--slate-50);
    }

    .bg-indigo-soft {
        background-color: var(--indigo-soft);
    }

    .text-indigo {
        color: var(--indigo);
    }

    .bg-indigo {
        background-color: var(--indigo);
    }

    .bg-amber-soft {
        background-color: var(--amber-soft);
    }

    .text-amber {
        color: var(--amber);
    }

    .btn-indigo {
        background-color: var(--indigo);
        transition: all 0.3s;
    }

    .btn-indigo:hover {
        background-color: #4338ca;
        transform: translateY(-1px);
    }

    .shadow-indigo {
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }

    .avatar-md {
        width: 45px;
        height: 45px;
        font-size: 1.1rem;
    }

    .fs-xs {
        font-size: 0.6rem;
    }

    .btn-icon-sm {
        padding: 0.25rem 0.5rem;
    }

    .btn-white:hover {
        background-color: var(--slate-50);
    }

    .salary-display {
        min-width: 140px;
    }

    .form-control:focus,
    .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.1) !important;
    }

    .border-dashed {
        border-style: dashed !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selector = document.getElementById('typeSelector');
        const salaryGroup = document.getElementById('salaryGroup');
        const honorGroup = document.getElementById('honorGroup');

        function toggleFields() {
            if (selector.value === 'pns') {
                salaryGroup.style.display = 'block';
                honorGroup.style.display = 'none';
            } else {
                salaryGroup.style.display = 'none';
                honorGroup.style.display = 'block';
            }
        }

        selector.addEventListener('change', toggleFields);
        toggleFields(); // Init on load
    });
</script>
@endsection