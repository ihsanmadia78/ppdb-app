<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PPDB SMK BaktiNusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard-responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/purple-theme.css') }}" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: #37474f;
            color: white;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-track { background: #4a148c; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 3px; }
        .sidebar.collapsed { width: 70px; }
        
        /* Sidebar Header */
        .sidebar-header {
            padding: 1.5rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .sidebar-logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
            margin-right: 1rem;
            background: white;
            border-radius: 12px;
            padding: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }
        .sidebar-logo:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0,0,0,0.2);
        }
        .sidebar-title h5 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.3;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
            letter-spacing: 0.3px;
        }
        .sidebar.collapsed .sidebar-logo { margin-right: 0; }
        .sidebar.collapsed .sidebar-title { display: none; }
        
        /* Sidebar Menu */
        .sidebar-menu {
            list-style: none;
            padding: 0.5rem 0;
            margin: 0;
        }
        .sidebar-menu li { margin: 0.25rem 0; }
        .sidebar-menu li small {
            display: block;
            padding: 0.5rem 1rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.5);
            font-weight: 600;
        }
        .sidebar.collapsed .sidebar-menu li small { display: none; }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
            border-left: 3px solid transparent;
        }
        .sidebar-menu li a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: white;
        }
        .sidebar-menu li a.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-left-color: white;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        .sidebar-menu li a i {
            width: 24px;
            margin-right: 0.875rem;
            font-size: 1.1rem;
            text-align: center;
        }
        .sidebar.collapsed .sidebar-menu li a span { display: none; }
        .sidebar.collapsed .sidebar-menu li a { justify-content: center; padding: 0.875rem 0; }
        
        /* Main Content */
        .main-content {
            margin-left: 260px;
            transition: all 0.3s ease;
            min-height: 100vh;
            background: #f5f6fa;
        }
        .main-content.expanded { margin-left: 70px; }
        
        /* Top Navbar */
        .top-navbar {
            background: #37474f;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .toggle-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 0.6rem 0.9rem;
            font-size: 1.1rem;
            cursor: pointer;
            color: white;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: white;
            transform: translateY(-1px);
        }
        .top-navbar .d-flex {
            gap: 1rem;
        }
        .top-navbar .btn-outline-secondary {
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            padding: 0.5rem 0.75rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            backdrop-filter: blur(10px);
        }
        .top-navbar .btn-outline-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: white;
            color: white;
            transform: translateY(-1px);
        }
        .top-navbar span {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            font-size: 0.95rem;
        }
        .top-navbar span i {
            color: rgba(255, 255, 255, 0.9);
            margin-right: 0.5rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 260px;
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0,0,0,0.3);
            }
            .main-content { margin-left: 0; }
            .main-content.expanded { margin-left: 0; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="d-flex align-items-center w-100">
                <img src="{{ asset('img/smk.png') }}" alt="Logo SMK" class="sidebar-logo">
                <div class="sidebar-title">
                    <h5 class="mb-0">SMK BaktiNusantara 666</h5>
                </div>
            </div>
            <button class="btn btn-sm text-white d-md-none" onclick="toggleSidebar()"><i class="fas fa-times"></i></button>
        </div>
        <ul class="sidebar-menu">
            @if(Auth::user()->role == 'admin')
                <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li><a href="{{ route('admin.pendaftar') }}" class="{{ request()->routeIs('admin.pendaftar') || request()->routeIs('admin.show') ? 'active' : '' }}"><i class="fas fa-users"></i><span>Pendaftar</span></a></li>
                <li><a href="{{ route('admin.peta') }}" class="{{ request()->routeIs('admin.peta') ? 'active' : '' }}"><i class="fas fa-map-marked-alt"></i><span>Peta Sebaran</span></a></li>
                <li><a href="{{ route('admin.pembayaran') }}" class="{{ request()->routeIs('admin.pembayaran') ? 'active' : '' }}"><i class="fas fa-money-bill-wave"></i><span>Pembayaran</span></a></li>
                <li class="mt-3"><small>DATA MASTER</small></li>
                <li><a href="{{ route('admin.jurusan') }}" class="{{ request()->routeIs('admin.jurusan') ? 'active' : '' }}"><i class="fas fa-book"></i><span>Jurusan</span></a></li>
                <li><a href="{{ route('admin.gelombang') }}" class="{{ request()->routeIs('admin.gelombang') ? 'active' : '' }}"><i class="fas fa-calendar"></i><span>Gelombang</span></a></li>
                <li><a href="{{ route('admin.biaya') }}" class="{{ request()->routeIs('admin.biaya') ? 'active' : '' }}"><i class="fas fa-dollar-sign"></i><span>Biaya</span></a></li>
                <li><a href="{{ route('admin.wilayah') }}" class="{{ request()->routeIs('admin.wilayah') ? 'active' : '' }}"><i class="fas fa-map-marker-alt"></i><span>Wilayah</span></a></li>
                <li><a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}"><i class="fas fa-user-cog"></i><span>Users</span></a></li>
                <li><a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="fas fa-cog"></i><span>Settings</span></a></li>
            @elseif(Auth::user()->role == 'verifikator')
                <li><a href="{{ route('verifikator.dashboard') }}" class="{{ request()->routeIs('verifikator.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li><a href="{{ route('verifikator.pendaftar') }}" class="{{ request()->routeIs('verifikator.pendaftar') || request()->routeIs('verifikator.detail') ? 'active' : '' }}"><i class="fas fa-users"></i><span>Daftar Pendaftar</span></a></li>
                <li><a href="{{ route('verifikator.riwayat') }}" class="{{ request()->routeIs('verifikator.riwayat') ? 'active' : '' }}"><i class="fas fa-history"></i><span>Riwayat</span></a></li>
            @elseif(Auth::user()->role == 'keuangan')
                <li><a href="{{ route('keuangan.dashboard') }}" class="{{ request()->routeIs('keuangan.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
                <li><a href="{{ route('keuangan.pembayaran') }}" class="{{ request()->routeIs('keuangan.pembayaran') || request()->routeIs('keuangan.detail') ? 'active' : '' }}"><i class="fas fa-money-bill"></i><span>Pembayaran</span></a></li>
                <li><a href="{{ route('keuangan.pembayaran.manual') }}" class="{{ request()->routeIs('keuangan.pembayaran.manual') ? 'active' : '' }}"><i class="fas fa-plus-circle"></i><span>Input Manual</span></a></li>
                <li><a href="{{ route('keuangan.laporan') }}" class="{{ request()->routeIs('keuangan.laporan') ? 'active' : '' }}"><i class="fas fa-chart-line"></i><span>Laporan</span></a></li>
                <li><a href="{{ route('keuangan.histori') }}" class="{{ request()->routeIs('keuangan.histori') ? 'active' : '' }}"><i class="fas fa-history"></i><span>Histori</span></a></li>
            @elseif(Auth::user()->role == 'eksekutif')
                <li><a href="{{ route('eksekutif.dashboard') }}" class="{{ request()->routeIs('eksekutif.dashboard') ? 'active' : '' }}"><i class="fas fa-chart-pie"></i><span>Dashboard</span></a></li>
            @endif
            <li class="mt-4" style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem;"><a href="{{ route('logout') }}" style="color: #e74c3c;"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary position-relative" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationCount" style="display: none;">0</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" style="width: 350px; max-height: 400px; overflow-y: auto;">
                        <h6 class="dropdown-header">Notifikasi</h6>
                        <div id="notificationList">
                            <div class="dropdown-item text-center text-muted">Tidak ada notifikasi</div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item text-center" onclick="markAllAsRead()">Tandai Semua Dibaca</button>
                    </div>
                </div>
                <span style="color: white;"><i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}</span>
            </div>
        </div>

        <!-- Page Content -->
        <div>
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            if (window.innerWidth > 768) {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            } else {
                sidebar.classList.toggle('show');
            }
        }

        // Notification System
        function loadNotifications() {
            fetch('/notifications')
                .then(response => response.json())
                .then(data => updateNotificationUI(data.notifications, data.unread_count))
                .catch(error => console.error('Error:', error));
        }

        function updateNotificationUI(notifications, unreadCount) {
            const badge = document.getElementById('notificationCount');
            const list = document.getElementById('notificationList');
            
            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
            
            if (notifications.length === 0) {
                list.innerHTML = '<div class="dropdown-item text-center text-muted">Tidak ada notifikasi</div>';
            } else {
                list.innerHTML = notifications.map(notif => `
                    <div class="dropdown-item ${notif.read_at ? '' : 'bg-light'}" onclick="markAsRead(${notif.id})">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">${notif.title}</h6>
                                <p class="mb-1 small">${notif.message}</p>
                                <small class="text-muted">${formatDate(notif.created_at)}</small>
                            </div>
                            ${!notif.read_at ? '<span class="badge bg-primary">Baru</span>' : ''}
                        </div>
                    </div>
                `).join('');
            }
        }

        function markAsRead(notificationId) {
            fetch('/notifications/mark-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ notification_id: notificationId })
            }).then(() => loadNotifications());
        }

        function markAllAsRead() {
            fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(() => loadNotifications());
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diff = now - date;
            const minutes = Math.floor(diff / 60000);
            const hours = Math.floor(diff / 3600000);
            const days = Math.floor(diff / 86400000);
            
            if (minutes < 1) return 'Baru saja';
            if (minutes < 60) return `${minutes} menit lalu`;
            if (hours < 24) return `${hours} jam lalu`;
            if (days < 7) return `${days} hari lalu`;
            return date.toLocaleDateString('id-ID');
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadNotifications();
            setInterval(loadNotifications, 30000);
        });
    </script>
</body>
</html>
