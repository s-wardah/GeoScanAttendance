@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-lg-5">
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <div>
                <h3 class="fw-bold mb-1" style="color: #1E1B4B;">Form Pengajuan Izin</h3>
                <p class="text-muted small mb-0">Silakan lengkapi detail ketidakhadiran Anda di bawah ini.</p>
            </div>
            <a href="/teacher/permission" class="btn btn-light rounded-pill px-4 shadow-sm border-0 small fw-bold">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 1.5rem;">
                <div class="p-4 text-white text-center" style="background: linear-gradient(135deg, #1E1B4B 0%, #3f3da1 100%);">
                    <h5 class="fw-bold mb-0">Detail Permohonan</h5>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="{{ route('teacher.permission.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted uppercase tracking-wider">Tanggal Absen</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-calendar3 text-primary"></i></span>
                                    <input type="date" name="date" class="form-control bg-light border-0 py-2" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Jenis Pengajuan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-tag text-primary"></i></span>
                                    <select name="type" class="form-select bg-light border-0 py-2" required>
                                        <option value="Izin">Izin (Ada Keperluan)</option>
                                        <option value="Sakit">Sakit (Butuh Istirahat)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Alasan / Keterangan</label>
                                <textarea name="reason" class="form-control bg-light border-0 p-3" rows="4" 
                                    placeholder="Jelaskan secara detail alasan Anda tidak dapat hadir..." required></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Lampiran Dokumen/Foto (Opsional)</label>
                                <div class="border-2 border-dashed rounded-3 p-4 text-center bg-light position-relative">
                                    <input type="file" name="attachment" class="form-control position-absolute opacity-0 w-100 h-100 top-0 start-0 cursor-pointer" accept="image/*,.pdf" style="z-index: 2;">
                                    <div class="upload-placeholder">
                                        <i class="bi bi-cloud-arrow-up fs-2 text-primary mb-2"></i>
                                        <p class="mb-1 small fw-bold text-dark">Klik atau seret file ke sini</p>
                                        <p class="mb-0 extra-small text-muted">Format: JPG, PNG, atau PDF (Maks. 2MB)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="/teacher/dashboard" class="btn btn-light px-5 py-2 rounded-pill fw-bold">Batal</a>
                                    <button type="submit" class="btn btn-warning px-5 py-2 rounded-pill fw-bold shadow-sm" style="color: #1E1B4B;">
                                        Kirim Pengajuan Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .extra-small { font-size: 0.75rem; }
    .cursor-pointer { cursor: pointer; }
    .border-dashed { border-style: dashed !important; border-color: #cbd5e1 !important; }
    
    .form-control:focus, .form-select:focus {
        background-color: #f1f5f9 !important;
        box-shadow: none;
        border: 1px solid #3f3da1 !important;
    }
</style>
@endsection