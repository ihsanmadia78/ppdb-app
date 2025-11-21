<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB SMK BaktiNusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }
        .bg-gray-100 { background-color: #f8f9fa !important; }
        .bg-gray-200 { background-color: #e9ecef !important; }
        .bg-gray-300 { background-color: #dee2e6 !important; }
        .bg-gray-400 { background-color: #ced4da !important; }
        .bg-gray-500 { background-color: #adb5bd !important; }
        .bg-gray-600 { background-color: #6c757d !important; }
        .bg-gray-700 { background-color: #495057 !important; }
        .bg-gray-800 { background-color: #343a40 !important; }
        .bg-gray-900 { background-color: #212529 !important; }
        .text-gray-600 { color: #6c757d !important; }
        .text-gray-700 { color: #495057 !important; }
        .text-gray-800 { color: #212529 !important; }
        .text-gray-900 { color: #212529 !important; }
        .border-gray { border-color: #dee2e6 !important; }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
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
        .table th {
            background-color: #e9ecef;
            color: #212529;
            border-color: #dee2e6;
        }
        .form-control:focus {
            border-color: #6c757d;
            box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-gray-800 shadow">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('img/smk.png') }}" alt="Logo SMK" height="40" class="me-2">
                PPDB SMK BaktiNusantara 666
            </a>
            
            @auth
            <div class="navbar-nav ms-auto">
                <!-- Notification Bell -->
                <div class="nav-item dropdown me-3">
                    <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" id="navNotificationBtn">
                        <i class="fas fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="navNotificationCount" style="display: none;">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" style="width: 350px; max-height: 400px; overflow-y: auto;">
                        <h6 class="dropdown-header">Notifikasi</h6>
                        <div id="navNotificationList">
                            <div class="dropdown-item text-center text-muted">Tidak ada notifikasi</div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item text-center" onclick="markAllAsRead()">Tandai Semua Dibaca</button>
                    </div>
                </div>

                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        @if(Auth::user()->role == 'eksekutif')
                            <li><a class="dropdown-item" href="{{ route('eksekutif.dashboard') }}"><i class="fas fa-chart-line me-2"></i>Dashboard Eksekutif</a></li>
                        @elseif(Auth::user()->role == 'verifikator')
                            <li><a class="dropdown-item" href="{{ route('verifikator.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('verifikator.pendaftar') }}"><i class="fas fa-users me-2"></i>Daftar Pendaftar</a></li>
                            <li><a class="dropdown-item" href="{{ route('verifikator.riwayat') }}"><i class="fas fa-history me-2"></i>Riwayat Verifikasi</a></li>
                        @elseif(Auth::user()->role == 'keuangan')
                            <li><a class="dropdown-item" href="{{ route('keuangan.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('keuangan.pembayaran') }}"><i class="fas fa-money-bill me-2"></i>Daftar Pembayaran</a></li>
                            <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}"><i class="fas fa-chart-bar me-2"></i>Laporan Keuangan</a></li>
                        @elseif(Auth::user()->role == 'siswa')
                            <li><a class="dropdown-item" href="{{ route('siswa.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('siswa.pembayaran') }}"><i class="fas fa-credit-card me-2"></i>Pembayaran</a></li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.pendaftar') }}"><i class="fas fa-users me-2"></i>Pendaftar</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header">Data Master</h6></li>
                            <li><a class="dropdown-item" href="{{ route('admin.jurusan') }}"><i class="fas fa-graduation-cap me-2"></i>Jurusan</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.gelombang') }}"><i class="fas fa-calendar-alt me-2"></i>Gelombang</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.biaya') }}"><i class="fas fa-money-bill-wave me-2"></i>Biaya</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.wilayah') }}"><i class="fas fa-map-marker-alt me-2"></i>Wilayah</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users') }}"><i class="fas fa-user-cog me-2"></i>Users</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Notification System
    function loadNotifications() {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                updateNotificationUI(data.notifications, data.unread_count);
            })
            .catch(error => console.error('Error loading notifications:', error));
    }

    function updateNotificationUI(notifications, unreadCount) {
        const countBadges = document.querySelectorAll('#navNotificationCount, #notificationCount');
        const lists = document.querySelectorAll('#navNotificationList, #notificationList');
        
        // Update count badges
        countBadges.forEach(badge => {
            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
        });
        
        // Update notification lists
        lists.forEach(list => {
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
        });
    }

    function markAsRead(notificationId) {
        fetch('/notifications/mark-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ notification_id: notificationId })
        })
        .then(() => loadNotifications())
        .catch(error => console.error('Error marking notification as read:', error));
    }

    function markAllAsRead() {
        fetch('/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(() => loadNotifications())
        .catch(error => console.error('Error marking all notifications as read:', error));
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

    // Load notifications on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadNotifications();
        // Refresh notifications every 30 seconds
        setInterval(loadNotifications, 30000);
    });
    </script>

</body>
</html>
