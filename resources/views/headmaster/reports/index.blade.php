@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Rekapitulasi Kehadiran Guru</h4>
            <p class="text-muted small mb-0">Periode laporan bulanan untuk Kepala Sekolah</p>
        </div>

        <div class="d-flex gap-2">
            <form action="{{ route('headmaster.reports.index') }}" method="GET" class="d-flex gap-2">
                <select name="month" class="form-select border-0 shadow-sm" style="min-width: 150px;">
                    @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary shadow-sm px-3">
                    <i class="bi bi-filter"></i> Filter
                </button>
            </form>

            <a href="{{ route('headmaster.reports.pdf', ['month' => $month]) }}" class="btn btn-danger shadow-sm px-3">
                <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="px-4 py-3">Nama Guru</th>
                        <th class="text-center">Hadir</th>
                        <th class="text-center">Telat</th>
                        <th class="text-center">Izin</th>
                        <th class="text-center">Sakit</th>
                        <th class="text-center">Alfa</th>
                        <th class="text-center">Persentase</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $teacher)
                    @php
                    $present = $teacher->attendances->where('status', 'Hadir')->count();
                    $late = $teacher->attendances->where('status', 'Terlambat')->count();
                    $permission = $teacher->attendances->where('status', 'Izin')->count();
                    $sick = $teacher->attendances->where('status', 'Sakit')->count();
                    $absent = $teacher->attendances->where('status', 'Alfa')->count();

                    $total = $present + $late + $permission + $sick + $absent;
                    // Persentase: (Hadir + Telat + Izin + Sakit) / Total
                    $percent = $total > 0 ? round((($present + $late + $permission + $sick) / $total) * 100) : 0;
                    @endphp
                    <tr>
                        <td class="px-4">
                            <div class="fw-bold">{{ $teacher->name }}</div>
                            <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                {{ $teacher->employee_type }}
                            </small>
                        </td>
                        <td class="text-center fw-bold text-success">{{ $present }}</td>
                        <td class="text-center fw-bold text-warning">{{ $late }}</td>
                        <td class="text-center fw-bold text-info">{{ $permission }}</td>
                        <td class="text-center fw-bold text-primary">{{ $sick }}</td>
                        <td class="text-center fw-bold text-danger">{{ $absent }}</td>
                        <td class="text-center">
                            <div class="d-flex flex-column align-items-center">
                                <div class="progress mb-1" style="height: 6px; width: 80px;">
                                    <div class="progress-bar {{ $percent < 75 ? 'bg-danger' : 'bg-primary' }}"
                                        style="width: {{ $percent }}%"></div>
                                </div>
                                <small class="fw-bold">{{ $percent }}%</small>
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection