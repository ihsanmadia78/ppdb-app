

<?php $__env->startSection('title', 'Dashboard Verifikator'); ?>

<?php $__env->startSection('content'); ?>
<div class="dashboard-container">
    <!-- Modern Header -->
    <div class="dashboard-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="header-content">
                        <h1 class="dashboard-title">
                            <span class="title-icon">✅</span>
                            Dashboard Verifikator
                        </h1>
                        <p class="dashboard-subtitle">
                            Kelola verifikasi berkas pendaftar PPDB SMK BaktiNusantara 666
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
                <div class="col-xl-3 col-lg-6 col-md-6">
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
                                    <span>Semua pendaftar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-warning">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number"><?php echo e($menunggu); ?></div>
                                <div class="stat-label">Menunggu Verifikasi</div>
                                <div class="stat-trend">
                                    <i class="fas fa-hourglass-half"></i>
                                    <span>Perlu diproses</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-info">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number"><?php echo e($diverifikasi); ?></div>
                                <div class="stat-label">Sedang Diverifikasi</div>
                                <div class="stat-trend">
                                    <i class="fas fa-spinner"></i>
                                    <span>Dalam proses</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="stat-card stat-card-success">
                        <div class="stat-card-body">
                            <div class="stat-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number"><?php echo e($lulus); ?></div>
                                <div class="stat-label">Lulus Verifikasi</div>
                                <div class="stat-trend">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Berkas disetujui</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Menu Buttons -->
    <div class="row g-3 mb-4">
        <div class="col-lg-4 col-md-6">
            <a href="<?php echo e(route('verifikator.pendaftar', ['status' => 'SUBMIT'])); ?>" class="menu-card menu-card-warning text-decoration-none">
                <div class="menu-icon"><i class="fas fa-clock"></i></div>
                <div class="menu-title">Menunggu Verifikasi</div>
                <div class="menu-subtitle"><?php echo e($menunggu); ?> pendaftar</div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a href="<?php echo e(route('verifikator.pendaftar')); ?>" class="menu-card menu-card-secondary text-decoration-none">
                <div class="menu-icon"><i class="fas fa-list"></i></div>
                <div class="menu-title">Semua Pendaftar</div>
                <div class="menu-subtitle">Daftar lengkap</div>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a href="<?php echo e(route('verifikator.riwayat')); ?>" class="menu-card menu-card-info text-decoration-none">
                <div class="menu-icon"><i class="fas fa-history"></i></div>
                <div class="menu-title">Riwayat Verifikasi</div>
                <div class="menu-subtitle">Histori proses</div>
            </a>
        </div>
    </div>

    <!-- Recent Submissions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3" style="background: #37474f; color: white;">
                    <h6 class="m-0 font-weight-bold">Pendaftar Terbaru (Menunggu Verifikasi)</h6>
                </div>
                <div class="card-body">
                    <?php if($terbaru->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No. Pendaftaran</th>
                                    <th>Nama</th>
                                    <th>Jurusan</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $terbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($p->no_pendaftaran); ?></td>
                                    <td><?php echo e($p->dataSiswa->nama ?? '-'); ?></td>
                                    <td><?php echo e($p->jurusan->nama ?? '-'); ?></td>
                                    <td><?php echo e($p->created_at->format('d/m/Y H:i')); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('verifikator.detail', $p->id)); ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <p class="text-muted text-center">Tidak ada pendaftar baru yang menunggu verifikasi</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

        </div>
    </div>
</div>

<style>
/* Dashboard Header */
.dashboard-header {
    background: #37474f;
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.dashboard-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: white;
}
.title-icon { font-size: 1.5rem; margin-right: 0.5rem; }
.dashboard-subtitle {
    color: rgba(255,255,255,0.9);
    margin-bottom: 0.5rem;
}
.breadcrumb-custom { font-size: 0.875rem; color: rgba(255,255,255,0.8); }
.header-actions { color: white; }
.date-display, .user-info { font-size: 0.9rem; color: rgba(255,255,255,0.9); }

/* Stats Cards */
.stats-section { margin-top: -1rem; }
.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: none;
}
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.stat-card-body { display: flex; align-items: center; gap: 1rem; }
.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}
.stat-card-primary .stat-icon { background: #37474f; color: white; }
.stat-card-success .stat-icon { background: #28a745; color: white; }
.stat-card-info .stat-icon { background: #17a2b8; color: white; }
.stat-card-warning .stat-icon { background: #ffc107; color: white; }
.stat-content { flex: 1; }
.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1;
    margin-bottom: 0.25rem;
}
.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 600;
    margin-bottom: 0.25rem;
}
.stat-trend {
    font-size: 0.75rem;
    color: #95a5a6;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Menu Cards */
.menu-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    display: block;
    color: inherit;
}
.menu-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.menu-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto 1rem;
}
.menu-card-warning .menu-icon { background: #ffc107; color: white; }
.menu-card-secondary .menu-icon { background: #6c757d; color: white; }
.menu-card-info .menu-icon { background: #17a2b8; color: white; }
.menu-card-success .menu-icon { background: #28a745; color: white; }
.menu-title {
    font-weight: 600;
    font-size: 1rem;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}
.menu-subtitle {
    font-size: 0.875rem;
    color: #6c757d;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-header { padding: 1.5rem 0; }
    .dashboard-title { font-size: 1.5rem; }
    .stat-number { font-size: 1.5rem; }
    .stat-icon { width: 50px; height: 50px; font-size: 1.25rem; }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/verifikator/dashboard.blade.php ENDPATH**/ ?>