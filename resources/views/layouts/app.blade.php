<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoScan - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --gs-dark: #1E1B4B;
            /* Warna Sidebar */
            --gs-indigo: #3f3da1;
            /* Warna Card Welcome */
            --gs-bg: #F4F7FE;
            /* Warna Background Body */
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--gs-bg);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        #sidebar {
            width: 280px;
            height: 100vh;
            background-color: var(--gs-dark);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s;
            padding: 2rem 1.5rem;
        }

        .sidebar-logo {
            max-width: 70px;
            margin-bottom: 0;
            filter: brightness(2);
        }

        .sidebar-text {
            max-height: 50px;
            margin-bottom: 0;
            filter: brightness(2);
        }

        .logo-divider {
            height: 1px;
            width: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.2), transparent);
            margin-bottom: 2rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 8px;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .nav-link.active {
            color: #fff !important;
            background-color: rgba(255, 255, 255, 0.15) !important;
        }

        /* Main Content Styling */
        #content {
            margin-left: 280px;
            /* Geser konten agar tidak tertutup sidebar */
            padding: 2rem;
            min-height: 100vh;
        }

        /* Header / Navbar Atas */
        .top-navbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding-bottom: 2rem;
        }

        .btn-logout {
            background-color: rgba(255, 0, 0, 0.1);
            color: #ff4d4d;
            border: none;
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background-color: #ff4d4d;
            color: white;
        }

        /* Styling Ikon agar sejajar dan konsisten */
        .nav-link i {
            font-size: 1.2rem;
            vertical-align: middle;
            transition: transform 0.3s;
        }

        .nav-link:hover i {
            transform: translateX(3px);
            /* Efek ikon bergeser sedikit saat dihover */
        }

        /* Heading pemisah kategori menu */
        .sidebar-heading {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            padding: 1.5rem 1.2rem 0.5rem;
        }

        /* Merapikan posisi footer sidebar */
        .sidebar-footer {
            position: absolute;
            bottom: 20px;
            left: 0;
            width: 100%;
            padding: 0 1.5rem;
        }

        /* Transisi halus untuk active state */
        .nav-link.active {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .dropdown-toggle::after {
            display: none !important;
        }

        /* Efek hover pada item dropdown */
        .dropdown-item {
            transition: all 0.2s;
            border-radius: 8px;
            margin: 0 8px;
            width: calc(100% - 16px);
        }

        .dropdown-item:hover {
            background-color: var(--gs-bg);
            color: var(--gs-indigo);
            transform: translateX(5px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -280px;
            }

            #content {
                margin-left: 0;
            }

            #sidebar.active {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <nav id="sidebar">
        <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom" style="border-color: rgba(255,255,255,0.1) !important;">
            <img src="{{ asset('image/onlylogo.png') }}" alt="GeoScan Logo" class="sidebar-logo mb-0">
            <img src="{{ asset('image/onlytext.png') }}" alt="GeoScan Text" class="sidebar-text mb-0">
        </div>

        <div class="nav flex-column mt-4">
            <a href="/dashboard" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-3"></i> Dashboard
            </a>

            @if(auth()->user()->role == 'admin')
            <div class="sidebar-heading">Admin System</div>
            <a href="/admin/schedule" class="nav-link {{ request()->is('admin/schedule*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event me-3"></i> Kelola Jadwal
            </a>
            <a href="/admin/rooms" class="nav-link {{ request()->is('admin/rooms*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt me-3"></i> Kelola Ruangan
            </a>
            <a href="/admin/teachers" class="nav-link {{ request()->is('admin/teachers*') ? 'active' : '' }}">
                <i class="bi bi-people me-3"></i> Data Guru
            </a>
            <a href="/admin/payroll" class="nav-link {{ request()->is('admin/payroll*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack me-3"></i> Laporan Gaji
            </a>
            @endif

            @if(auth()->user()->role == 'headmaster')
            <div class="sidebar-heading">Management</div>
            <a href="{{ route('headmaster.permissions.index') }}" class="nav-link {{ request()->routeIs('headmaster.permissions.index') ? 'active' : '' }}">
                <div class="d-flex align-items-center w-100">
                    <i class="bi bi-shield-check me-3"></i>
                    <span>Validasi Izin</span>
                    @php $pendingCount = \App\Models\Permission::where('status', 'Pending')->count(); @endphp
                    @if($pendingCount > 0)
                    <span class="badge bg-danger rounded-pill ms-auto" style="font-size: 0.65rem;">{{ $pendingCount }}</span>
                    @endif
                </div>
            </a>
            <a href="{{ route('headmaster.reports.index') }}" class="nav-link {{ request()->routeIs('headmaster.reports.index') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line me-3"></i> Rekap Bulanan
            </a>
            <a href="/admin/payroll" class="nav-link {{ request()->is('admin/payroll*') ? 'active' : '' }}">
                <i class="bi bi-wallet2 me-3"></i> Monitoring Gaji
            </a>
            @endif

            @if(auth()->user()->role == 'teachers')
            <div class="sidebar-heading">Personal Menu</div>
            <a href="/teacher/scan" class="nav-link {{ request()->is('teacher/scan*') ? 'active' : '' }}">
                <i class="bi bi-qr-code-scan me-3"></i> Scan QR Absensi
            </a>
            <a href="{{ route('teacher.permission.index') }}" class="nav-link {{ request()->routeIs('teacher.permission.*') ? 'active' : '' }}">
                <i class="bi bi-envelope-paper me-3"></i> Ajukan Izin/Sakit
            </a>
            <a href="/teacher/history" class="nav-link {{ request()->is('teacher/history*') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-3"></i> Riwayat Kehadiran
            </a>
            <a href="/teacher/payroll" class="nav-link {{ request()->is('teacher/payroll*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-medical me-3"></i> Slip Gaji
            </a>
            @endif
        </div>

        <div class="sidebar-footer">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn-logout w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-box-arrow-left me-2"></i> Keluar Aplikasi
                </button>
            </form>
        </div>
    </nav>

    <div id="content">
        <div class="top-navbar">
            <div class="d-flex align-items-center">
                <span class="me-3 fw-medium text-secondary">{{ now()->translatedFormat('l, d F Y') }}</span>
                <div class="bg-white px-3 py-1 rounded-pill shadow-sm border border-primary">
                    <small class="fw-bold">{{ strtoupper(auth()->user()->role) }}</small>
                </div>
            </div>
            <div class="d-flex align-items-center ps-3 border-start ms-3" style="border-color: #dee2e6 !important;">
                <div class="dropdown">
                    <div class="d-flex align-items-center ps-3 border-start dropdown-toggle"
                        id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false"
                        style="border-color: #dee2e6 !important; cursor: pointer;">

                        <div class="position-relative">
                            @if(auth()->user()->profile_photo)
                            <img src="{{ asset('storage/'.auth()->user()->profile_photo) }}"
                                alt="Profile" class="rounded-circle border border-2 border-white shadow-sm"
                                style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                            <div class="rounded-circle shadow-sm d-flex align-items-center justify-content-center border border-2 border-white"
                                style="width: 40px; height: 40px; background-color: var(--gs-indigo);">
                                <span class="text-white fw-bold small">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            @endif
                            <span class="position-absolute bottom-0 end-0 badge border border-white rounded-circle bg-success p-1"></span>
                        </div>
                    </div>

                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3 py-2"
                        aria-labelledby="dropdownUser"
                        style="border-radius: 1rem; min-width: 200px;">
                        <li class="px-3 py-2 d-sm-none">
                            <div class="fw-bold">{{ auth()->user()->name }}</div>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="/profile">
                                <i class="bi bi-person-circle me-2 text-primary"></i>My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="/profile/security">
                                <i class="bi bi-shield-lock me-2 text-primary"></i>Account Security
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @yield('content')

        <footer class="mt-5 py-4 border-top">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="text-muted small mb-0">
                            &copy; {{ date('Y') }} <span class="fw-bold" style="color: var(--gs-dark);">GeoScan Attendance</span>. All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <small class="text-muted">Dibuat untuk Ujikom RPL 2026</small>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>