@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-lg-4">
    <div class="row align-items-center mb-4">
        <div class="col-auto">
            <div class="bg-dark p-3 rounded-4 shadow-sm">
                <i class="bi bi-geo-alt-fill text-white fs-4"></i>
            </div>
        </div>
        <div class="col">
            <h4 class="fw-bold text-slate-900 mb-0">QR & Infrastructure</h4>
            <p class="text-muted small mb-0">Konfigurasi titik koordinat ruangan dan enkripsi kode QR presensi.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 1.25rem;">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h6 class="fw-bold mb-0 text-slate-800">Konfigurasi Titik Baru</h6>
                </div>
                <div class="card-body p-4 pt-0">
                    <form action="{{ route('admin.rooms.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="small fw-bold text-slate-600 mb-2">Identifier Ruangan</label>
                            <input type="text" name="room_name" class="form-control custom-input" placeholder="Misal: Laboratorium Fisika A" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="small fw-bold text-slate-600 mb-2">Latitude</label>
                                <input type="text" name="latitude" id="lat" class="form-control custom-input bg-light-soft" placeholder="-6.xxx" required>
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold text-slate-600 mb-2">Longitude</label>
                                <input type="text" name="longitude" id="lng" class="form-control custom-input bg-light-soft" placeholder="107.xxx" required>
                            </div>
                        </div>

                        <button type="button" onclick="getLocation()" class="btn btn-outline-indigo w-100 mb-4 py-2 small fw-bold">
                            <i class="bi bi-crosshair2 me-2"></i>Ambil Koordinat GPS
                        </button>

                        <div class="mb-4 p-3 bg-slate-50 rounded-4 border border-dashed">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="small fw-bold text-slate-600">Geo-fence Radius</label>
                                <span class="badge bg-indigo-soft text-indigo" id="radiusVal">50m</span>
                            </div>
                            <input type="range" name="radius" class="form-range custom-range" min="10" max="500" value="50" oninput="document.getElementById('radiusVal').innerText = this.value + 'm'">
                            <small class="text-muted d-block mt-2" style="font-size: 0.7rem;">
                                <i class="bi bi-info-circle me-1"></i> Guru hanya bisa scan jika berada di dalam area ini.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-indigo w-100 py-2 shadow-indigo">
                            Register Infrastructure
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 1.25rem; overflow: hidden;">
                <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-slate-800">Deployment Ruangan</h6>
                    <button class="btn btn-white btn-sm border fw-bold text-muted px-3"><i class="bi bi-printer me-2"></i>Print All QR</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-slate-50 text-muted small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4 py-3">Point of Interest</th>
                                <th class="py-3">Coordinate Info</th>
                                <th class="py-3 text-center">QR Token</th>
                                <th class="py-3 text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse($rooms as $room)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-slate-900">{{ $room->room_name }}</div>
                                    <div class="d-flex align-items-center mt-1">
                                        <span class="badge bg-success-soft text-success small border-0 me-2">Active</span>
                                        <span class="text-muted small"><i class="bi bi-broadcast me-1"></i>{{ $room->radius }}m</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="small font-monospace text-muted">
                                        {{ number_format($room->latitude, 5) }}<br>
                                        {{ number_format($room->longitude, 5) }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="qr-container p-2 bg-white border rounded-4 d-inline-block shadow-sm transition-all" data-bs-toggle="modal" data-bs-target="#qrModal{{ $room->id }}" style="cursor: zoom-in;">
                                        {!! QrCode::size(50)->margin(1)->generate($room->qr_content) !!}
                                    </div>
                                    <div class="small text-muted mt-1 font-monospace" style="font-size: 0.65rem;">{{ $room->qr_content }}</div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <button class="btn btn-light-soft btn-sm rounded-3 me-2 text-indigo"><i class="bi bi-pencil-square"></i></button>
                                        <button class="btn btn-light-soft btn-sm rounded-3 text-danger"><i class="bi bi-trash3"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://illustrations.popsy.co/slate/empty-state.svg" style="width: 150px;" alt="Empty">
                                    <p class="text-muted small mt-3">Belum ada infrastruktur yang terdaftar.</p>
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

<style>
    /* Senada dengan Dashboard Modern */
    :root {
        --indigo-primary: #4f46e5;
        --indigo-soft: #eef2ff;
        --slate-900: #0f172a;
    }

    body { background-color: #f8fafc; font-family: 'Plus Jakarta Sans', sans-serif; }
    
    .bg-indigo { background-color: var(--indigo-primary); }
    .bg-indigo-soft { background-color: var(--indigo-soft); }
    .text-indigo { color: var(--indigo-primary); }
    .btn-indigo { background: var(--indigo-primary); color: white; border-radius: 0.75rem; border: none; font-weight: 600; transition: 0.3s; }
    .btn-indigo:hover { background: #4338ca; transform: translateY(-2px); }
    .shadow-indigo { box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3); }

    .custom-input {
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.6rem 1rem;
        transition: all 0.2s;
        font-size: 0.9rem;
    }
    .custom-input:focus {
        border-color: var(--indigo-primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }

    .bg-light-soft { background-color: #f1f5f9; }
    .bg-success-soft { background-color: #ecfdf5; }
    .text-success { color: #059669; }

    .btn-outline-indigo {
        border: 2px solid var(--indigo-soft);
        color: var(--indigo-primary);
        border-radius: 0.75rem;
    }
    .btn-outline-indigo:hover {
        background: var(--indigo-soft);
        border-color: var(--indigo-primary);
    }

    .btn-light-soft { background: #f1f5f9; border: none; }
    .btn-light-soft:hover { background: #e2e8f0; }

    .qr-container:hover {
        transform: scale(1.1);
        border-color: var(--indigo-primary) !important;
    }

    .custom-range::-webkit-slider-thumb { background: var(--indigo-primary); }

    .font-monospace { font-family: 'Fira Code', 'Courier New', monospace; }
</style>

<script>
    function getLocation() {
    const btn = event.currentTarget;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sourcing GPS...';
    
    if (navigator.geolocation) {
        // Tambahkan opsi akurasi tinggi agar satelit GPS aktif
        const options = {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        };

        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('lat').value = position.coords.latitude.toFixed(8);
            document.getElementById('lng').value = position.coords.longitude.toFixed(8);
            
            btn.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Coordinate Secured';
            btn.className = 'btn btn-success w-100 mb-4 py-2 small fw-bold text-white';
        }, function(error) {
            console.error(error);
            alert("GPS Error: Pastikan GPS HP aktif dan izin browser diberikan.");
            btn.innerHTML = '<i class="bi bi-crosshair2 me-2"></i>Try Again';
        }, options); 
    } else {
        alert("Browser tidak mendukung Geolocation");
    }
}
</script>
@endsection