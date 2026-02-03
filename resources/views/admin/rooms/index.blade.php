@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-lg-4">
    <div class="row align-items-center mb-4 animate__animated animate__fadeIn">
        <div class="col">
            <h3 class="fw-bold mb-1" style="color: #1E1B4B;">Infrastructure Engine</h3>
            <p class="text-muted small mb-0">Manajemen Geofencing & Smart QR Deployment untuk sistem presensi presisi.</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-indigo shadow-indigo rounded-pill py-2 px-4 fw-bold text-white border-0"
                data-bs-toggle="modal" data-bs-target="#deployRoomModal">
                <i class="bi bi-plus-circle-fill me-2"></i>Register New Point
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 1.5rem; overflow: hidden;">
        <div class="card-header bg-white border-0 p-4">
            <div class="d-flex align-items-center">
                <div class="bg-indigo-soft p-2 rounded-3 me-3">
                    <i class="bi bi-hdd-network text-indigo"></i>
                </div>
                <h5 class="fw-bold text-dark mb-0">Active Deployment Grid</h5>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-slate-50">
                    <tr class="text-muted small text-uppercase tracking-wider">
                        <th class="px-4 py-3 border-0">Entity Identifier</th>
                        <th class="py-3 border-0">Spatial Data</th>
                        <th class="py-3 border-0">Security Radius</th>
                        <th class="py-3 text-center border-0">QR Asset</th>
                        <th class="py-3 text-end pe-4 border-0">Control System</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                    <tr class="transition">
                        <td class="px-4 py-4">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-indigo-soft text-indigo rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs-6">{{ $room->room_name }}</div>
                                    <small class="text-muted">ID: #{{ str_pad($room->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="p-2 bg-light rounded-3 d-inline-block border border-white shadow-sm">
                                <code class="text-indigo small" style="font-size: 0.7rem;">
                                    LAT: {{ number_format($room->latitude, 8) }}<br>
                                    LNG: {{ number_format($room->longitude, 8) }}
                                </code>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1 me-2" style="height: 6px; width: 80px;">
                                    <div class="progress-bar bg-indigo" role="progressbar" style="width: {{ ($room->radius / 500) * 100 }}%"></div>
                                </div>
                                <span class="fw-bold text-slate-700 small">{{ $room->radius }}m</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="qr-preview-card p-2 bg-white border rounded-3 d-inline-block shadow-sm transition"
                                title="Click to expand QR" style="cursor: pointer;">
                                {!! QrCode::size(35)->margin(1)->generate($room->qr_content) !!}
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group gap-2">
                                <a href="{{ route('admin.rooms.print', $room->id) }}" target="_blank"
                                    class="btn btn-white border shadow-none rounded-pill px-3 btn-sm fw-bold">
                                    <i class="bi bi-printer me-1"></i>Print
                                </a>

                                <button class="btn btn-white border shadow-none rounded-pill px-3 btn-sm text-indigo fw-bold"
                                    onclick="editRoom({{ json_encode($room) }})"
                                    title="Edit Infrastructure">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </button>

                                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="d-inline" id="delete-form-{{ $room->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-white border shadow-none rounded-pill px-3 btn-sm text-danger fw-bold"
                                        onclick="confirmDelete({{ $room->id }})" title="Delete Point">
                                        <i class="bi bi-trash3-fill me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="deployRoomModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-header border-0 p-4 pb-0">
                <div class="bg-indigo-soft p-2 rounded-3 me-3">
                    <i class="bi bi-geo-alt-fill text-indigo fs-4"></i>
                </div>
                <div>
                    <h5 class="modal-title fw-bold text-dark">Infrastructure Deployment</h5>
                    <p class="text-muted small mb-0">Konfigurasi titik koordinat presensi baru.</p>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="small fw-bold text-muted mb-2">Location Name</label>
                        <div class="input-group bg-light rounded-3 overflow-hidden">
                            <span class="input-group-text bg-transparent border-0"><i class="bi bi-building text-indigo"></i></span>
                            <input type="text" name="room_name" class="form-control bg-transparent border-0 py-2 shadow-none" placeholder="Contoh: Ruang Guru Lt. 1" required>
                        </div>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-4 border mb-4">
                        <label class="small fw-bold text-indigo mb-3 d-block">Global Positioning System (GPS)</label>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="text" name="latitude" id="lat" class="form-control border-0 shadow-none font-monospace small" placeholder="Lat" readonly required>
                                    <label class="text-muted small">Latitude</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="text" name="longitude" id="lng" class="form-control border-0 shadow-none font-monospace small" placeholder="Lng" readonly required>
                                    <label class="text-muted small">Longitude</label>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="getLocation(event)" id="gpsBtn" class="btn btn-outline-indigo w-100 rounded-3 py-2 fw-bold small transition">
                            <i class="bi bi-crosshair2 me-2"></i>Lock Coordinates
                        </button>
                    </div>

                    <div class="p-3 bg-indigo-soft rounded-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="small fw-bold text-indigo">Geo-fence Radius Boundary</label>
                            <span class="badge bg-indigo text-white rounded-pill" id="radiusValModal">50m</span>
                        </div>
                        <input type="range" name="radius" class="form-range custom-range" min="10" max="500" value="50"
                            oninput="document.getElementById('radiusValModal').innerText = this.value + 'm'">
                        <div class="d-flex justify-content-between mt-1">
                            <span class="text-muted" style="font-size: 0.65rem;">10m (Strict)</span>
                            <span class="text-muted" style="font-size: 0.65rem;">500m (Wide)</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold text-muted" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-indigo rounded-pill px-4 fw-bold text-white shadow-indigo border-0">Deploy Point</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --indigo: #4f46e5;
        --indigo-dark: #1E1B4B;
        --indigo-soft: #eef2ff;
        --slate-50: #f8fafc;
        --slate-700: #334155;
    }

    body {
        background-color: #f1f5f9;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .text-indigo {
        color: var(--indigo);
    }

    .bg-indigo {
        background-color: var(--indigo);
    }

    .bg-indigo-soft {
        background-color: var(--indigo-soft);
    }

    .bg-slate-50 {
        background-color: var(--slate-50);
    }

    .btn-indigo {
        background: var(--indigo-dark);
        transition: all 0.3s;
    }

    .btn-indigo:hover {
        background: #312e81;
        transform: translateY(-2px);
    }

    .shadow-indigo {
        box-shadow: 0 10px 15px -3px rgba(30, 27, 75, 0.3);
    }

    .btn-outline-indigo {
        border: 2px solid var(--indigo);
        color: var(--indigo);
    }

    .btn-outline-indigo:hover {
        background: var(--indigo);
        color: white;
    }

    .qr-preview-card:hover {
        transform: scale(1.1);
        border-color: var(--indigo) !important;
    }

    .custom-range::-webkit-slider-thumb {
        background: var(--indigo);
    }

    .custom-range::-moz-range-thumb {
        background: var(--indigo);
    }

    .transition {
        transition: all 0.2s ease-in-out;
    }

    .tracking-wider {
        letter-spacing: 0.05rem;
    }

    .form-control:focus {
        background: white !important;
        box-shadow: none;
        border: 1px solid var(--indigo) !important;
    }

    .progress {
        background-color: #e2e8f0;
        border-radius: 10px;
    }
</style>

<script>
    function getLocation(event) {
        const btn = event.currentTarget;
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Pinging Satellites...';
        btn.disabled = true;

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('lat').value = position.coords.latitude.toFixed(8);
                document.getElementById('lng').value = position.coords.longitude.toFixed(8);

                btn.innerHTML = '<i class="bi bi-shield-check me-2"></i>Coordinates Locked';
                btn.className = 'btn btn-success w-100 rounded-3 py-2 fw-bold small text-white border-0';
                btn.disabled = false;
            }, function(error) {
                btn.innerHTML = originalContent;
                btn.disabled = false;
                alert("GPS Access Denied: Pastikan HTTPS aktif dan izinkan lokasi.");
            }, {
                enableHighAccuracy: true,
                timeout: 5000
            });
        } else {
            alert("Geolocation unsupported.");
            btn.innerHTML = originalContent;
            btn.disabled = false;
        }
    }

    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus titik infrastruktur ini?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    // Fungsi Edit
    function editRoom(room) {
        const modalElement = document.getElementById('deployRoomModal');
        const form = modalElement.querySelector('form');

        // 1. Ganti URL form ke route update
        form.action = `/admin/rooms/${room.id}`;

        // 2. Tambahkan _method PUT jika belum ada
        let methodInput = form.querySelector('input[name="_method"]');
        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
        }

        // 3. Isi field input modal
        form.querySelector('input[name="room_name"]').value = room.room_name;
        form.querySelector('input[name="latitude"]').value = room.latitude;
        form.querySelector('input[name="longitude"]').value = room.longitude;
        form.querySelector('input[name="radius"]').value = room.radius;
        document.getElementById('radiusValModal').innerText = room.radius + 'm';

        // 4. Update UI Modal
        modalElement.querySelector('.modal-title').innerText = 'Update Infrastructure';
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerText = 'Save Changes';
        submitBtn.classList.remove('btn-indigo');
        submitBtn.classList.add('btn-success');

        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }

    // LOGIKA TAMBAHAN: Reset form saat modal ditutup agar kembali ke mode "Register New Point"
    document.getElementById('deployRoomModal').addEventListener('hidden.bs.modal', function() {
        const form = this.querySelector('form');
        form.action = "{{ route('admin.rooms.store') }}"; // Kembalikan ke route store
        form.reset(); // Kosongkan input

        // Hapus input _method PUT
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();

        // Kembalikan UI
        this.querySelector('.modal-title').innerText = 'Infrastructure Deployment';
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerText = 'Deploy Point';
        submitBtn.classList.remove('btn-success');
        submitBtn.classList.add('btn-indigo');

        // Reset GPS Button jika perlu
        const gpsBtn = document.getElementById('gpsBtn');
        gpsBtn.innerHTML = '<i class="bi bi-crosshair2 me-2"></i>Lock Coordinates';
        gpsBtn.className = 'btn btn-outline-indigo w-100 rounded-3 py-2 fw-bold small transition';
    });
</script>
@endsection