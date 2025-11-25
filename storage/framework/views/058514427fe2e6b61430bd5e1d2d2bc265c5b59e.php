

<?php $__env->startSection('title', 'Riwayat Verifikasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Riwayat Verifikasi</h1>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Log Aktivitas Verifikasi</h6>
        </div>
        <div class="card-body">
            <?php if($riwayat->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama Pendaftar</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Verifikator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($r->created_at->format('d/m/Y H:i')); ?></td>
                            <td><?php echo e($r->pendaftar->no_pendaftaran ?? '-'); ?></td>
                            <td><?php echo e($r->pendaftar->dataSiswa->nama ?? '-'); ?></td>
                            <td>
                                <?php if($r->status == 'SUBMIT'): ?>
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                <?php elseif($r->status == 'VERIFIKASI_ADMIN'): ?>
                                    <span class="badge bg-info">Sedang Diverifikasi</span>
                                <?php elseif($r->status == 'MENUNGGU_PEMBAYARAN'): ?>
                                    <span class="badge bg-primary">Lulus Verifikasi</span>
                                <?php elseif($r->status == 'LULUS'): ?>
                                    <span class="badge bg-success">Lulus</span>
                                <?php elseif($r->status == 'TIDAK_LULUS'): ?>
                                    <span class="badge bg-danger">Tidak Lulus</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?php echo e($r->status); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($r->keterangan); ?></td>
                            <td><?php echo e($r->createdBy->name ?? 'System'); ?></td>
                            <td>
                                <form method="POST" action="<?php echo e(route('verifikator.riwayat.delete', $r->id)); ?>" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus riwayat ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="text-muted text-center">Belum ada riwayat verifikasi</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/verifikator/riwayat.blade.php ENDPATH**/ ?>