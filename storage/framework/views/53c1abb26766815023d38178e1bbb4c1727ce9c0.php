<?php $__env->startSection('title', 'Histori Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">📋 Histori Pembayaran</h1>
            <p class="text-muted mb-0">Catatan semua transaksi pembayaran yang telah diverifikasi</p>
        </div>
        <a href="<?php echo e(route('keuangan.dashboard')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">💰 Riwayat Transaksi</h6>
                </div>
                <div class="col-auto">
                    <form method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control form-control-sm me-2" 
                               placeholder="Cari nama/no pendaftaran..." value="<?php echo e(request('search')); ?>">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <?php if(session('success')): ?>
                <div class="alert alert-success mx-3 mt-3"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger mx-3 mt-3"><?php echo e(session('error')); ?></div>
            <?php endif; ?>
            
            <?php if($histori->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama Siswa</th>
                            <th>Jurusan</th>
                            <th>Nominal</th>
                            <th>Tanggal Bayar</th>
                            <th>Metode Bayar</th>
                            <th>User Verifikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $histori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <span class="badge bg-info"><?php echo e($h->pendaftar->no_pendaftaran ?? '-'); ?></span>
                            </td>
                            <td class="fw-bold"><?php echo e($h->pendaftar->dataSiswa->nama ?? '-'); ?></td>
                            <td>
                                <span class="badge bg-secondary"><?php echo e($h->pendaftar->jurusan->nama ?? '-'); ?></span>
                            </td>
                            <td class="fw-bold text-success">Rp <?php echo e(number_format($h->nominal ?? 0, 0, ',', '.')); ?></td>
                            <td><?php echo e($h->tanggal_bayar ? $h->tanggal_bayar->format('d/m/Y H:i') : '-'); ?></td>
                            <td>
                                <span class="badge bg-dark"><?php echo e(strtoupper($h->metode_pembayaran ?? '-')); ?></span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?php echo e($h->verifiedBy->name ?? 'System'); ?><br>
                                    <span class="text-xs"><?php echo e($h->verified_at ? $h->verified_at->format('d/m/Y H:i') : '-'); ?></span>
                                </small>
                            </td>
                            <td>
                                <form method="POST" action="<?php echo e(route('keuangan.histori.delete', $h->id)); ?>" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus histori pembayaran ini?')">
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
            
            <div class="card-footer">
                <?php echo e($histori->links()); ?>

            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-receipt fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-600">Belum Ada Histori Pembayaran</h5>
                <p class="text-muted">Histori akan muncul setelah ada pembayaran yang diverifikasi.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.text-gray-800 { color: #212529 !important; }
.text-gray-600 { color: #6c757d !important; }
.text-gray-300 { color: #adb5bd !important; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/keuangan/histori.blade.php ENDPATH**/ ?>