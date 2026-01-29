@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h3 class="fw-bold text-indigo">Riwayat Kehadiran</h3>
        <p class="text-muted">Pantau kedisiplinan dan data absensi Anda di sini.</p>
    </div>

    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 border-0">Tanggal & Waktu</th>
                                <th class="py-3 border-0">Ruangan</th>
                                <th class="py-3 border-0 text-center">Jarak</th>
                                <th class="py-3 border-0">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                            <tr class="align-middle">
                                <td class="px-4 py-3">
                                    <div class="fw-bold">{{ $attendance->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $attendance->created_at->format('H:i') }} WIB</small>
                                </td>
                                <td>
                                    {{ $attendance->room->room_name ?? 'N/A' }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border">
                                        {{ $attendance->distance_from_target }}m
                                    </span>
                                </td>
                                <td>
                                    @php
                                    $badgeClass = [
                                    'Hadir' => 'bg-success',
                                    'Terlambat' => 'bg-warning text-dark',
                                    'Izin' => 'bg-info',
                                    'Gagal' => 'bg-danger'
                                    ][$attendance->status] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill">
                                        {{ $attendance->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <p class="mb-0">Belum ada data kehadiran.</p>
                                        <small>Silakan lakukan scan QR di kelas.</small>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection