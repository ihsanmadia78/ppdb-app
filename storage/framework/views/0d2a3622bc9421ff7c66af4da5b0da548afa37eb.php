<?php $__env->startSection('title', 'Dashboard Verifikator'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard Verifikator</h1>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pendaftar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($total); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Verifikasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($menunggu); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sedang Diverifikasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($diverifikasi); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-search fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Lulus Verifikasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($lulus); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="<?php echo e(route('verifikator.pendaftar', ['status' => 'SUBMIT'])); ?>" class="btn btn-warning btn-block">
                                <i class="fas fa-clock me-1"></i> Menunggu Verifikasi
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="<?php echo e(route('verifikator.pendaftar')); ?>" class="btn btn-primary btn-block">
                                <i class="fas fa-list me-1"></i> Semua Pendaftar
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="<?php echo e(route('verifikator.riwayat')); ?>" class="btn btn-info btn-block">
                                <i class="fas fa-history me-1"></i> Riwayat Verifikasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Submissions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pendaftar Terbaru (Menunggu Verifikasi)</h6>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/verifikator/dashboard.blade.php ENDPATH**/ ?>