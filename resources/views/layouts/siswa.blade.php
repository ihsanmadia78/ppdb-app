<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Siswa - PPDB SMK BaktiNusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            background: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #212529;
        }
        .navbar-brand img { width: 40px; height: 40px; }
        .sidebar { 
            min-height: 100vh; 
            background: #6c757d;
            width: 250px;
        }
        .sidebar .nav-link { 
            color: #e9ecef; 
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin: 2px 0;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { 
            color: #212529; 
            background: #e9ecef;
        }
        .main-content { margin-left: 250px; }
        @media (max-width: 768px) { .main-content { margin-left: 0; } }
        .card {
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-primary:hover {
            background-color: #495057;
            border-color: #495057;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar position-fixed">
        <div class="p-3 text-center border-bottom">
            <img src="{{ asset('img/smk.png') }}" alt="Logo" class="rounded-circle mb-2" width="60">
            <h6 class="text-white mb-0">Portal Siswa</h6>
            <small class="text-muted">SMK BaktiNusantara 666</small>
        </div>
        <nav class="nav flex-column p-3">
            <a class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}" href="{{ route('siswa.dashboard') }}">
                <i class="fas fa-home me-2"></i>Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('siswa.profile') ? 'active' : '' }}" href="{{ route('siswa.profile') }}">
                <i class="fas fa-user me-2"></i>Profil Saya
            </a>
            <a class="nav-link {{ request()->routeIs('siswa.pembayaran') ? 'active' : '' }}" href="{{ route('siswa.pembayaran') }}">
                <i class="fas fa-credit-card me-2"></i>Pembayaran
            </a>
            <hr class="text-muted">
            <a class="nav-link" href="{{ route('siswa.logout') }}">
                <i class="fas fa-sign-out-alt me-2"></i>Keluar
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="ms-auto">
                    <span class="text-muted">
                        <i class="fas fa-user-circle me-1"></i>
                        {{ session('siswa_nama', 'Siswa') }}
                    </span>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>