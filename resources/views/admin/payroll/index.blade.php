@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm p-4" style="border-radius: 1.25rem;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-indigo mb-0">Laporan Gaji Guru - {{ now()->format('F Y') }}</h4>
            <button onclick="window.print()" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-printer me-2"></i>Cetak Laporan
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Nama Guru</th>
                        <th>Tipe</th>
                        <th class="text-center">Total Hadir</th>
                        <th class="text-end">Total Gaji (Bulan Ini)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payrollData as $data)
                    <tr>
                        <td class="fw-bold">{{ $data['name'] }}</td>
                        <td>
                            <span class="badge {{ $data['type'] == 'pns' ? 'bg-indigo-soft text-indigo' : 'bg-success-soft text-success' }} px-3">
                                {{ strtoupper($data['type']) }}
                            </span>
                        </td>
                        <td class="text-center">{{ $data['hadir'] }} kali</td>
                        <td class="text-end fw-bold text-indigo">
                            Rp {{ number_format($data['total'], 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection