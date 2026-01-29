@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4">
        <h3 class="fw-bold mb-1" style="color: #1E1B4B;">Scanner Kehadiran</h3>
        <p class="text-muted small">Dekatkan QR Code ke area kotak kamera</p>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 1.5rem;">
                <div class="row g-0">
                    <div class="col-md-8 bg-black position-relative" style="min-height: 500px;">
                        <div id="reader" style="width: 100%; height: 100%;"></div>

                        <div class="scan-line"></div>
                    </div>

                    <div class="col-md-4 bg-white d-flex flex-column justify-content-center p-5 text-center">
                        <div id="status-container">
                            <div class="mb-4">
                                <h5 class="fw-bold" style="color: #1E1B4B;">Siap Memindai</h5>
                                <p class="text-muted small">Sistem sedang menunggu deteksi QR Code dari kamera Anda.</p>
                            </div>

                            <div id="result" class="mt-3">
                                <span class="badge bg-light text-dark p-3 w-100 border text-wrap" style="border-radius: 12px;">
                                    Status: Menunggu Kamera...
                                </span>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="button" onclick="stopScannerAndExit()" class="btn btn-outline-secondary w-100 py-3 fw-bold" style="border-radius: 12px; border-style: dashed;">
                                Batalkan Scan
                            </button>
                        </div>

                        <div class="mt-4 p-3 bg-white shadow-sm border-start border-4 border-warning" style="border-radius: 10px;">
                            <small class="text-secondary d-block text-center">
                                <i class="bi bi-info-circle me-1"></i> GPS akan otomatis mengambil titik koordinat setelah QR terdeteksi.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Membuat scanner mengisi container */
    #reader {
        border: none !important;
    }

    #reader__dashboard,
    #reader__status_span {
        display: none !important;
        /* Sembunyikan kontrol bawaan yang ganggu */
    }

    #reader video {
        object-fit: cover !important;
        /* Video jadi full */
        width: 100% !important;
        height: 100% !important;
        border-radius: 0;
    }

    /* Animasi Garis Scan */
    .scan-line {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(to bottom, rgba(63, 61, 161, 0), #3f3da1);
        box-shadow: 0px 0px 15px 2px rgba(63, 61, 161, 0.7);
        animation: scan 3s infinite linear;
        z-index: 10;
    }

    @keyframes scan {
        0% {
            top: 0;
        }

        100% {
            top: 100%;
        }
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        background: #f4f7fe;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Styling tombol bawaan library */
    #reader button {
        background-color: #3f3da1 !important;
        border: none !important;
        color: white !important;
        padding: 10px 20px !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
    }
</style>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let html5QrCode;

    // 1. Fungsi saat Scan Berhasil
    function onScanSuccess(decodedText, decodedResult) {
        html5QrCode.stop().then(() => {
            document.getElementById('status-container').innerHTML = `
                <div class="animate__animated animate__fadeIn">
                    <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;"></div>
                    <h5 class="fw-bold text-primary">QR Terdeteksi!</h5>
                    <p class="text-muted">Sedang memproses lokasi GPS...</p>
                </div>
            `;
            getLocation(decodedText);
        });
    }

    function getLocation(qrContent) {
        if (navigator.geolocation) {
            // Tambahkan opsi akurasi tinggi di sini
            const geoOptions = {
                enableHighAccuracy: true, 
                timeout: 10000000, 
                maximumAge: 0 
            };

            navigator.geolocation.getCurrentPosition(function(position) {
                fetch('/attendance/store', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            qr_content: qrContent,
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        window.location.href = "/dashboard";
                    })
                    .catch(error => {
                        alert("Detail Error: " + error.message);
                        console.log(error);
                    });
            }, function(error) {
                // Jika GPS gagal dapet titik
                let msg = "Gagal mengambil lokasi: ";
                if (error.code == 1) msg += "Izin lokasi ditolak.";
                else if (error.code == 2) msg += "Sinyal GPS lemah.";
                else if (error.code == 3) msg += "Waktu pengambilan lokasi habis.";
                alert(msg);
                location.reload(); // Refresh buat coba lagi
            }, geoOptions);
        } else {
            alert("Browser Anda tidak mendukung GPS.");
        }
    }

    // 3. Fungsi Inisialisasi Kamera (Environment = Kamera Belakang)
    function startScanner() {
        html5QrCode = new Html5Qrcode("reader");
        const config = {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            },
            aspectRatio: 1.0
        };

        html5QrCode.start({
                facingMode: "environment"
            },
            config,
            onScanSuccess
        ).catch(err => {
            // Jika gagal, coba cara kedua (bebas kamera apa saja)
            console.error("Gagal kamera belakang, mencoba kamera default...", err);
            html5QrCode.start({
                facingMode: "user"
            }, config, onScanSuccess);
        });
    }

    // Jalankan scanner otomatis saat halaman siap
    document.addEventListener("DOMContentLoaded", function() {
        startScanner();
    });

    function stopScannerAndExit() {
        if (html5QrCode) {
            html5QrCode.stop().finally(() => {
                window.location.href = "{{ url('/dashboard') }}";
            });
        } else {
            window.location.href = "{{ url('/dashboard') }}";
        }
    }
</script>

@endsection