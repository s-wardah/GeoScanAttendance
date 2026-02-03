@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-lg-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h3 class="fw-bold mb-1" style="color: #1E1B4B;">Pengajuan Izin & Sakit</h3>
            <p class="text-muted small">Pantau status kehadiran dan permohonan Anda di sini.</p>
        </div>
        <div class="col-auto">
            <a href="/teacher/permission/create" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Buat Pengajuan
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @php
            $stats = [
                ['label' => 'Menunggu', 'count' => $permissions->where('status', 'Pending')->count(), 'color' => 'warning', 'icon' => 'hourglass-split'],
                ['label' => 'Disetujui', 'count' => $permissions->where('status', 'Approved')->count(), 'color' => 'success', 'icon' => 'check-circle'],
                ['label' => 'Ditolak', 'count' => $permissions->where('status', 'Rejected')->count(), 'color' => 'danger', 'icon' => 'x-circle']
            ];
        @endphp
        @foreach($stats as $stat)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-{{ $stat['color'] }} bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-{{ $stat['icon'] }} text-{{ $stat['color'] }} fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-bold text-uppercase">{{ $stat['label'] }}</small>
                        <h4 class="fw-bold mb-0">{{ $stat['count'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="small text-muted text-uppercase">
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="py-3">Tipe</th>
                        <th class="py-3">Keterangan</th>
                        <th class="py-3">Lampiran</th>
                        <th class="py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $p)
                    <tr>
                        <td class="px-4 py-3 fw-bold">{{ \Carbon\Carbon::parse($p->date)->format('d M Y') }}</td>
                        <td><span class="badge {{ $p->type == 'Sakit' ? 'bg-info' : 'bg-primary' }} rounded-pill">{{ $p->type }}</span></td>
                        <td class="text-muted small">{{ Str::limit($p->reason, 40) }}</td>
                        <td>
                            @if($p->attachment)
                                <a href="{{ asset('storage/'.$p->attachment) }}" target="_blank" class="btn btn-sm btn-light border rounded-pill">Lihat</a>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold text-{{ $p->status == 'Pending' ? 'warning' : ($p->status == 'Approved' ? 'success' : 'danger') }}">
                                {{ $p->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data pengajuan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection