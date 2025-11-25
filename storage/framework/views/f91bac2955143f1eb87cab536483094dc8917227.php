

<?php $__env->startSection('content'); ?>
<div class="dashboard-container">
    <!-- Modern Header -->
    <div class="dashboard-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="header-content">
                        <h1 class="dashboard-title">
                            <span class="title-icon">📊</span>
                            Dashboard Admin
                        </h1>
                        <p class="dashboard-subtitle">
                            Selamat datang di sistem PPDB SMK BaktiNusantara 666
                        </p>
                        <div class="breadcrumb-custom">
                            <span class="breadcrumb-item active">
                                <i class="fas fa-home me-1"></i>Dashboard
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="header-actions">
                        <div class="notification-bell mb-2">
                            <button class="btn btn-outline-secondary position-relative" id="notificationBtn" data-bs-toggle="dropdown">
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
                        <div class="date-display">
                            <i class="fas fa-calendar-alt me-2"></i>
                            <span><?php echo e(date('d F Y')); ?></span>
                        </div>
                        <div class="user-info mt-2">
                            <i class="fas fa-user-circle me-2"></i>
                            <span><?php echo e(auth()->user()->name); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="container-fluid">

        <!-- Modern Stats Cards -->
        <div class="stats-section mb-3">
            <div class="row g-3">
                <div class="col-xl-20 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-primary">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number"><?php echo e($total); ?></div>
                                <div class="stat-label">Total Pendaftar</div>
                                <div class="stat-trend">
                                    <i class="fas fa-chart-line"></i>
                                    <span>Semua yang mendaftar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-20 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-success">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fas fa-file-check"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number"><?php echo e($berkasApproved); ?></div>
                                <div class="stat-label">Sudah Verifikasi Administrasi</div>
                                <div class="stat-trend">
                                    <i class="fas fa-check"></i>
                                    <span>Berkas disetujui</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-20 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-info">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fas fa-money-check-alt"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number"><?php echo e($jumlahSudahBayar); ?></div>
                                <div class="stat-label">Sudah Bayar</div>
                                <div class="stat-trend">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Pembayaran verified</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-20 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-warning">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number"><?php echo e($berkasPending); ?></div>
                                <div class="stat-label">Belum Verifikasi</div>
                                <div class="stat-trend">
                                    <i class="fas fa-hourglass-half"></i>
                                    <span>Menunggu proses</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-20 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-secondary">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fas fa-percentage"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number"><?php echo e($total > 0 ? round(($diterima/$total)*100, 1) : 0); ?>%</div>
                                <div class="stat-label">Persentase Kuota Terpenuhi</div>
                                <div class="stat-trend">
                                    <i class="fas fa-chart-pie"></i>
                                    <span>Siswa diterima</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="row mb-4">
        <!-- Chart Tren Pendaftar Harian -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">📈 Tren Pendaftar Harian</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 250px; position: relative;">
                        <canvas id="chartTrenHarian"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Pendaftar Per Jurusan -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">🎓 Pendaftar Per Jurusan</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 250px; position: relative;">
                        <canvas id="chartJurusan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Status Pendaftaran -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">📊 Status Pendaftaran</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 250px; position: relative;">
                        <canvas id="chartStatus"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Menu Utama -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">⚡ Menu Utama Admin</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="<?php echo e(route('admin.pendaftar')); ?>" class="btn btn-primary w-100 py-3 menu-btn">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-users fa-2x mb-2"></i>
                                    <span class="fw-bold">Pendaftar</span>
                                    <small class="text-white-50 d-none d-md-block">Data siswa</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="<?php echo e(route('admin.jurusan')); ?>" class="btn btn-success w-100 py-3 menu-btn">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                                    <span class="fw-bold">Jurusan</span>
                                    <small class="text-white-50 d-none d-md-block">Program</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-warning w-100 py-3 menu-btn">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-user-cog fa-2x mb-2"></i>
                                    <span class="fw-bold text-dark">User</span>
                                    <small class="text-dark opacity-75 d-none d-md-block">Pengguna</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="<?php echo e(route('admin.gelombang')); ?>" class="btn btn-info w-100 py-3 menu-btn">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                                    <span class="fw-bold">Gelombang</span>
                                    <small class="text-white-50 d-none d-md-block">Periode</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="<?php echo e(route('admin.peta')); ?>" class="btn btn-dark w-100 py-3 menu-btn">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-map-marked-alt fa-2x mb-2"></i>
                                    <span class="fw-bold">Peta</span>
                                    <small class="text-white-50 d-none d-md-block">Lokasi</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="dropdown w-100">
                                <button class="btn btn-secondary dropdown-toggle w-100 py-3 menu-btn" type="button" data-bs-toggle="dropdown">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-download fa-2x mb-2"></i>
                                        <span class="fw-bold">Export</span>
                                        <small class="text-white-50 d-none d-md-block">Data</small>
                                    </div>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.export')); ?>"><i class="fas fa-file-excel me-2"></i>Semua Data</a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.export', ['status' => 'LULUS'])); ?>"><i class="fas fa-check me-2"></i>Diterima</a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.export', ['status' => 'TIDAK_LULUS'])); ?>"><i class="fas fa-times me-2"></i>Ditolak</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Komposisi Asal Sekolah & Wilayah -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">🏢 Asal Sekolah</h6>
                </div>
                <div class="card-body">
                    <?php if($asalSekolah->count() > 0): ?>
                        <?php $__currentLoopData = $asalSekolah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sekolah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="fw-bold"><?php echo e($sekolah->sekolah); ?></div>
                                <small class="text-muted"><?php echo e($sekolah->jumlah); ?> siswa</small>
                            </div>
                            <div class="progress" style="width: 100px; height: 8px;">
                                <div class="progress-bar bg-primary" style="width: <?php echo e(($sekolah->jumlah / $total) * 100); ?>%"></div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p class="text-muted text-center">Belum ada data asal sekolah</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">🗺️ Wilayah Domisili</h6>
                </div>
                <div class="card-body">
                    <?php if($wilayahDomisili->count() > 0): ?>
                        <?php $__currentLoopData = $wilayahDomisili; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wilayah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="fw-bold"><?php echo e(trim($wilayah->wilayah)); ?></div>
                                <small class="text-muted"><?php echo e($wilayah->jumlah); ?> siswa</small>
                            </div>
                            <div class="progress" style="width: 100px; height: 8px;">
                                <div class="progress-bar bg-success" style="width: <?php echo e(($wilayah->jumlah / $total) * 100); ?>%"></div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p class="text-muted text-center">Belum ada data wilayah domisili</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">🕒 Aktivitas Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $terbaru->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <div class="fw-bold small text-truncate"><?php echo e($p->dataSiswa?->nama ?? 'Unknown'); ?></div>
                                    <small class="text-muted"><?php echo e($p->created_at->diffForHumans()); ?></small>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Registrations Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
            <h6 class="m-0 font-weight-bold text-gray-800 mb-2 mb-sm-0">🧾 Pendaftar Terbaru</h6>
            <a href="<?php echo e(route('admin.pendaftar')); ?>" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-eye me-1"></i><span class="d-none d-sm-inline">Lihat Semua</span><span class="d-sm-none">Semua</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $terbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><span class="badge bg-info text-dark"><?php echo e($p->no_pendaftaran); ?></span></td>
                                <td><?php echo e($p->dataSiswa?->nama ?? '-'); ?></td>
                                <td><span class="badge bg-secondary"><?php echo e($p->jurusan?->nama ?? '-'); ?></span></td>
                                <td>
                                    <?php if(in_array($p->status, ['SUBMIT', 'VERIFIKASI_ADMIN', 'MENUNGGU_PEMBAYARAN', 'TERBAYAR', 'VERIFIKASI_KEUANGAN'])): ?>
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock"></i> <?php echo e($p->status); ?>

                                        </span>
                                    <?php elseif($p->status == 'LULUS'): ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> Diterima
                                        </span>
                                    <?php elseif($p->status == 'TIDAK_LULUS'): ?>
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times"></i> Ditolak
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <?php echo e($p->status); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($p->created_at->format('d/m/Y H:i')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.show', $p->id)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>

<style>
/* Modern Dashboard Styling */
.dashboard-container {
    background: #f0f2f5;
    min-height: 100vh;
    margin: 0;
    padding: 0;
}

.dashboard-header {
    background: #37474f;
    color: white;
    padding: 1.5rem 0;
    margin: 0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.dashboard-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.title-icon {
    margin-right: 0.75rem;
    font-size: 1.5rem;
}

.dashboard-subtitle {
    font-size: 0.95rem;
    opacity: 0.9;
    margin-bottom: 0.75rem;
}

.breadcrumb-custom {
    background: rgba(255,255,255,0.15);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    display: inline-block;
    backdrop-filter: blur(10px);
}

.header-actions {
    text-align: right;
}

.date-display, .user-info {
    background: rgba(255,255,255,0.15);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    display: inline-block;
    font-size: 0.9rem;
    backdrop-filter: blur(10px);
    color: white;
}

.dashboard-content {
    padding: 1.5rem;
}

/* Modern Stats Cards */
.stats-section {
    margin-top: 0;
    position: relative;
    z-index: 10;
}

.stat-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border: none;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.stat-card-body {
    padding: 1.25rem;
    display: flex;
    align-items: center;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.3rem;
    color: white;
    flex-shrink: 0;
}

.stat-card-primary .stat-icon {
    background: #37474f;
}

.stat-card-success .stat-icon {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.stat-card-warning .stat-icon {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.stat-card-danger .stat-icon {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.stat-card-info .stat-icon {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
}

.stat-card-secondary .stat-icon {
    background: #37474f;
}

.stat-card-dark .stat-icon {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 1.75rem;
    font-weight: 700;
    color: #212529;
    line-height: 1;
    margin-bottom: 0.35rem;
}

.stat-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.35rem;
    line-height: 1.2;
}

.stat-trend {
    font-size: 0.75rem;
    color: #6c757d;
    display: flex;
    align-items: center;
}

.stat-trend i {
    margin-right: 0.25rem;
}

/* Card Improvements */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}

.card-header {
    background: #ffffff;
    border-bottom: 1px solid #dee2e6;
    border-radius: 12px 12px 0 0 !important;
    padding: 0.875rem 1rem;
}

.card-header h6 {
    font-weight: 600;
    color: #212529;
    margin: 0;
    font-size: 0.95rem;
}

/* Menu Buttons */
.menu-btn {
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    background: white;
    color: #374151;
}

.menu-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    background: #37474f;
    color: white;
}

.btn-primary.menu-btn {
    background: #37474f;
    color: white;
}

.btn-success.menu-btn {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.btn-warning.menu-btn {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.btn-info.menu-btn {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    color: white;
}

.btn-dark.menu-btn {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: white;
}

.btn-secondary.menu-btn {
    background: #37474f;
    color: white;
}

/* Custom 5 column grid for XL screens */
.col-xl-20 {
    flex: 0 0 auto;
    width: 20%;
}

@media (max-width: 1199px) {
    .col-xl-20 {
        width: 50%;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-title {
        font-size: 2rem;
    }
    
    .title-icon {
        font-size: 1.5rem;
    }
    
    .stat-card-body {
        padding: 1.5rem 1rem;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
        margin-right: 1rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .stat-label {
        font-size: 0.9rem;
    }
    
    .stat-trend {
        font-size: 0.75rem;
    }
    
    .header-actions {
        text-align: center;
        margin-top: 1rem;
    }
}

@media (max-width: 576px) {
    .dashboard-header {
        padding: 1.5rem 0;
    }
    
    .stats-section {
        margin-top: -2rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .menu-btn {
        padding: 1rem !important;
    }
    
    .menu-btn i {
        font-size: 1.5rem !important;
        margin-bottom: 0.5rem !important;
    }
    
    .menu-btn span {
        font-size: 0.875rem;
    }
    
    .menu-btn small {
        display: none;
    }
    
    .col-xl-20 {
        width: 100%;
    }
}

/* Additional Utility Classes */
.avatar-sm {
    width: 2.5rem;
    height: 2.5rem;
    font-size: 0.875rem;
}

.min-width-0 {
    min-width: 0;
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.text-gray-800 {
    color: #212529 !important;
}

.text-gray-300 {
    color: #6c757d !important;
}

/* Table Improvements */
.table {
    border-radius: 10px;
    overflow: hidden;
}

.table thead th {
    border: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table tbody td {
    border-color: #f1f5f9;
    vertical-align: middle;
}

/* Badge Improvements */
.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
    border-radius: 8px;
}

/* Progress Bar */
.progress {
    border-radius: 10px;
    background-color: #f1f5f9;
}

.progress-bar {
    border-radius: 10px;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk Chart.js
    const labels = <?php echo json_encode($labels, 15, 512) ?>;
    const data = <?php echo json_encode($data, 15, 512) ?>;
    const statistikHarian = <?php echo json_encode($statistikHarian, 15, 512) ?>;

    const colors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
    ];

    // Chart 1: Tren Pendaftar Harian (7 hari terakhir)
    new Chart(document.getElementById('chartTrenHarian'), {
        type: 'line',
        data: {
            labels: statistikHarian.map(item => item.tanggal),
            datasets: [{
                label: 'Pendaftar',
                data: statistikHarian.map(item => item.jumlah),
                backgroundColor: 'rgba(108, 117, 125, 0.1)',
                borderColor: '#6c757d',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#6c757d',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Chart 2: Pendaftar Per Jurusan
    new Chart(document.getElementById('chartJurusan'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendaftar',
                data: data,
                backgroundColor: colors,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Chart 3: Status Pendaftaran
    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: ['Diterima', 'Menunggu', 'Ditolak', 'Cadangan'],
            datasets: [{
                data: [
                    <?php echo e($diterima); ?>,
                    <?php echo e($menunggu); ?>,
                    <?php echo e($ditolak); ?>,
                    <?php echo e($cadangan); ?>

                ],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d'],
                borderWidth: 2,
                borderColor: '#f8f9fa'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 10,
                        font: { size: 10 }
                    }
                }
            }
        }
    });
});

function showExportModal() {
    const modal = `
        <div class="modal fade" id="exportModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Custom Export</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="exportForm" action="<?php echo e(route('admin.export')); ?>" method="GET">
                            <div class="mb-3">
                                <label class="form-label">Jurusan</label>
                                <select name="jurusan_id" class="form-select">
                                    <option value="">Semua Jurusan</option>
                                    <?php $__currentLoopData = \App\Models\Jurusan::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($j->id); ?>"><?php echo e($j->nama); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="SUBMIT">Menunggu</option>
                                    <option value="LULUS">Diterima</option>
                                    <option value="TIDAK_LULUS">Ditolak</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Dari Tanggal</label>
                                    <input type="date" name="date_from" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sampai Tanggal</label>
                                    <input type="date" name="date_to" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-dark" onclick="document.getElementById('exportForm').submit()">Export</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modal);
    new bootstrap.Modal(document.getElementById('exportModal')).show();
    
    document.getElementById('exportModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>