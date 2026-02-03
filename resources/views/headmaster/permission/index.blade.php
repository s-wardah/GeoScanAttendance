@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Validasi Izin & Sakit</h4>
            <p class="text-muted small">Menunggu persetujuan Kepala Sekolah</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Guru</th>
                        <th>Tgl Absen</th>
                        <th>Jenis</th>
                        <th>Alasan</th>
                        <th class="text-center">Lampiran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $p)
                    <tr>
                        <td class="px-4">
                            <div class="fw-bold">{{ $p->user->name }}</div>
                            <small class="text-muted text-uppercase" style="font-size: 0.65rem">ID: #{{ $p->user_id }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($p->date)->format('d M Y') }}</td>
                        <td>
                            <span class="badge {{ $p->type == 'Sakit' ? 'bg-info' : 'bg-primary' }} rounded-pill px-3">
                                {{ $p->type }}
                            </span>
                        </td>
                        <td style="max-width: 200px;" class="text-truncate">{{ $p->reason }}</td>
                        <td class="text-center">
                            @if($p->attachment)
                            <button type="button" class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#preview{{ $p->id }}">
                                <i class="bi bi-eye"></i> Lihat
                            </button>

                            <div class="modal fade" id="preview{{ $p->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0">
                                        <div class="modal-header border-0 pb-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center p-4">
                                            <img src="{{ asset('storage/' . $p->attachment) }}" class="img-fluid rounded-3 shadow">
                                            <p class="mt-3 mb-0 fw-bold">{{ $p->type }} - {{ $p->user->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <span class="text-muted small">Tanpa Foto</span>
                            @endif
                        </td>
                        <td class="text-center px-4">
                            <div class="d-flex gap-2 justify-content-center">
                                <form action="{{ route('headmaster.permissions.update', $p->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="Approved">
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 fw-bold">Terima</button>
                                </form>

                                <form action="{{ route('headmaster.permissions.update', $p->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="Rejected">
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">Tolak</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-check-all display-4 text-muted"></i>
                            <p class="text-muted mt-2">Semua pengajuan sudah diproses!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection