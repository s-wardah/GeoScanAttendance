<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoScan - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            max-width: 180px;
            margin-bottom: 3rem;
            filter: brightness(2);
            /* Membuat logo putih bersih */
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
        <div class="text-center">
            <img src="{{ asset('image/geoscan_logo.png') }}" alt="GeoScan Logo" class="sidebar-logo">
        </div>

        <div class="nav flex-column mt-4">
            <a href="/dashboard" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                Dashboard
            </a>

            @if(auth()->user()->role == 'admin')
            <div class="small fw-bold text-uppercase px-3 mt-4 mb-2" style="letter-spacing: 1px; font-size: 0.7rem; color: #ffffff">Admin Menu</div>
            <a href="/admin/rooms" class="nav-link {{ request()->is('admin/rooms*') ? 'active' : '' }}">Kelola Ruangan</a>
            <a href="/admin/teachers" class="nav-link {{ request()->is('admin/teachers*') ? 'active' : '' }}">Data Guru</a>
            <a href="/admin/payroll" class="nav-link {{ request()->is('admin/payroll*') ? 'active' : '' }}">Laporan Gaji</a>
            @endif

            @if(auth()->user()->role == 'headmaster')
            <div class="small fw-bold text-uppercase px-3 mt-4 mb-2" style="letter-spacing: 1px; font-size: 0.7rem; color: #ffffff">Headmaster Menu</div>
            <a href="/admin/payroll" class="nav-link {{ request()->is('admin/payroll*') ? 'active' : '' }}">Monitoring Gaji</a>
            @endif

            @if(auth()->user()->role == 'teachers')
            <div class="small fw-bold text-uppercase px-3 mt-4 mb-2" style="letter-spacing: 1px; font-size: 0.7rem; color: #ffffff">Teacher Menu</div>
            <a href="/teacher/scan" class="nav-link {{ request()->is('teacher/scan*') ? 'active' : '' }}">Scan QR</a>
            <a href="/teacher/history" class="nav-link {{ request()->is('teacher/history*') ? 'active' : '' }}">Attendance History</a>
            <a href="/teacher/payroll" class="nav-link {{ request()->is('teacher/payroll*') ? 'active' : '' }}">Pay Slip</a>
            @endif
        </div>

        <div style="position: absolute; bottom: 30px; width: 80%;">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn-logout w-100 text-center">Logout</button>
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