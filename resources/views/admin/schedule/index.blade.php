@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-lg-4">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold mb-1" style="color: #1E1B4B;">Manajemen Jadwal</h3>
            <p class="text-muted small">Atur dan pantau jadwal pelajaran serta pembagian ruang kelas.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg position-relative overflow-hidden" style="border-radius: 1.5rem;">
                <div style="height: 6px; background: linear-gradient(to right, #1E1B4B, #3f3da1);"></div>
                
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4 text-indigo">
                        <i class="bi bi-plus-circle-fill fs-4 me-2"></i>
                        <h5 class="fw-bold mb-0">Tambah Jadwal Baru</h5>
                    </div>

                    <form action="{{ route('admin.schedule.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1 ml-1">Guru Pengajar</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-person text-indigo"></i></span>
                                <select name="user_id" class="form-select bg-light border-0" required>
                                    @foreach($teachers as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold text-muted mb-1 ml-1">Kelas</label>
                                <select name="class_id" class="form-select bg-light border-0">
                                    @foreach($classes as $c)
                                    <option value="{{ $c->id }}">{{ $c->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold text-muted mb-1 ml-1">Ruangan</label>
                                <select name="room_id" class="form-select bg-light border-0">
                                    @foreach($rooms as $r)
                                    <option value="{{ $r->id }}">{{ $r->room_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1 ml-1">Mata Pelajaran</label>
                            <input type="text" name="subject" class="form-control bg-light border-0" placeholder="Contoh: Pemrograman Web" required>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1 ml-1">Hari</label>
                            <select name="day" class="form-select bg-light border-0">
                                <option value="Monday">Senin</option>
                                <option value="Tuesday">Selasa</option>
                                <option value="Wednesday">Rabu</option>
                                <option value="Thursday">Kamis</option>
                                <option value="Friday">Jumat</option>
                                <option value="Saturday">Sabtu</option>
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 ml-1">Jam Mulai</label>
                                <input type="time" name="start_time" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 ml-1">Jam Selesai</label>
                                <input type="time" name="end_time" class="form-control bg-light border-0" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 ml-1">Tahun Ajaran</label>
                                <input type="text" name="academic_year" class="form-control bg-light border-0" placeholder="2025/2026" required>
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 ml-1">Semester</label>
                                <select name="semester" class="form-select bg-light border-0">
                                    <option value="Odd">Ganjil</option>
                                    <option value="Even">Genap</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-indigo w-100 rounded-pill py-2 fw-bold shadow-sm transition">
                            <i class="bi bi-save me-2"></i>Simpan Jadwal
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 1.5rem;">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold text-dark mb-0">Daftar Jadwal Aktif</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="text-muted small text-uppercase tracking-wider">
                                <th class="px-4 py-3">Mata Pelajaran</th>
                                <th class="py-3">Guru</th>
                                <th class="py-3">Ruang & Kelas</th>
                                <th class="py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $s)
                            <tr class="transition">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-indigo-soft text-indigo rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="bi bi-book-fill"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $s->subject }}</div>
                                            <div class="badge bg-light text-muted fw-normal border" style="font-size: 0.7rem;">
                                                <i class="bi bi-calendar-event me-1"></i>{{ $s->day }}, {{ $s->start_time }} - {{ $s->end_time }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium text-dark">{{ $s->teacher->name }}</div>
                                    <div class="extra-small text-muted">NIP: #{{ $s->teacher->id }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-indigo-soft text-indigo px-3 py-2 rounded-pill mb-1 d-inline-block shadow-sm">
                                        <i class="bi bi-door-open me-1"></i>{{ $s->class->class_name ?? 'Kelas Tidak Ada' }}
                                    </span>
                                    <div class="small text-muted ps-1"><i class="bi bi-geo-alt me-1"></i>{{ $s->room->room_name ?? 'Ruangan Tidak Ada' }}</div>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-action-delete rounded-circle shadow-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
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
    :root { --indigo-color: #1E1B4B; }
    .text-indigo { color: var(--indigo-color); }
    .bg-indigo-soft { background-color: #eef2ff; }
    .btn-indigo { background: var(--indigo-color); color: white; }
    .btn-indigo:hover { background: #3f3da1; color: white; transform: translateY(-2px); }
    
    .extra-small { font-size: 0.75rem; }
    .tracking-wider { letter-spacing: 0.5px; }

    /* Action Button Styles */
    .btn-action-delete {
        width: 32px;
        height: 32px;
        background: #fff;
        color: #dc3545;
        border: 1px solid #f8d7da;
        transition: all 0.2s;
    }
    .btn-action-delete:hover {
        background: #dc3545;
        color: white;
    }

    /* Row Hover & Transitions */
    .transition { transition: all 0.3s ease; }
    tbody tr:hover { background-color: #fafaff !important; }

    /* Custom Input Focus */
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border-color: var(--indigo-color) !important;
        box-shadow: 0 0 0 0.25rem rgba(30, 27, 75, 0.1);
    }
</style>
@endsection