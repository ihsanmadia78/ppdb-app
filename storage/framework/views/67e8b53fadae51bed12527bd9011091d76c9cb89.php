

<?php $__env->startSection('title', 'Daftar Pendaftar - Verifikator'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Daftar Pendaftar</h1>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">🔍 Filter & Pencarian Pendaftar</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('verifikator.pendaftar')); ?>">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><i class="fas fa-flag me-1"></i>Status Administrasi</label>
                        <select name="status" class="form-select">
                            <option value="">🔍 Semua Status</option>
                            <option value="SUBMIT" <?php echo e(request('status') == 'SUBMIT' ? 'selected' : ''); ?>>⏳ Belum Diverifikasi</option>
                            <option value="VERIFIKASI_ADMIN" <?php echo e(request('status') == 'VERIFIKASI_ADMIN' ? 'selected' : ''); ?>>🔄 Perlu Perbaikan</option>
                            <option value="MENUNGGU_PEMBAYARAN" <?php echo e(request('status') == 'MENUNGGU_PEMBAYARAN' ? 'selected' : ''); ?>>✅ Lulus Administrasi</option>
                            <option value="TIDAK_LULUS" <?php echo e(request('status') == 'TIDAK_LULUS' ? 'selected' : ''); ?>>❌ Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label"><i class="fas fa-graduation-cap me-1"></i>Jurusan</label>
                        <select name="jurusan_id" class="form-select">
                            <option value="">🎓 Semua</option>
                            <?php $__currentLoopData = $jurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($j->id); ?>" <?php echo e(request('jurusan_id') == $j->id ? 'selected' : ''); ?>>
                                <?php echo e($j->kode); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label"><i class="fas fa-wave-square me-1"></i>Gelombang</label>
                        <select name="gelombang_id" class="form-select">
                            <option value="">🌊 Semua</option>
                            <?php $__currentLoopData = $gelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($gel->id); ?>" <?php echo e(request('gelombang_id') == $gel->id ? 'selected' : ''); ?>>
                                <?php echo e($gel->nama); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><i class="fas fa-search me-1"></i>Pencarian</label>
                        <input type="text" name="search" class="form-control" placeholder="🔍 Nama atau No. Pendaftaran" value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pendaftar (<?php echo e($pendaftar->count()); ?> data)</h6>
        </div>
        <div class="card-body">
            <?php if($pendaftar->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="12%">No. Pendaftaran</th>
                            <th width="18%">Nama Siswa</th>
                            <th width="10%">Jurusan</th>
                            <th width="10%">Gelombang</th>
                            <th width="15%">Status Administrasi</th>
                            <th width="10%">Status Berkas</th>
                            <th width="12%">Tanggal Daftar</th>
                            <th width="13%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pendaftar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <span class="badge bg-info text-dark"><?php echo e($p->no_pendaftaran); ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-gray-600 rounded-circle d-flex align-items-center justify-content-center me-2">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold"><?php echo e($p->dataSiswa->nama ?? '-'); ?></div>
                                        <small class="text-muted">NISN: <?php echo e($p->dataSiswa->nisn ?? '-'); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary"><?php echo e($p->jurusan->kode ?? '-'); ?></span>
                            </td>
                            <td>
                                <span class="badge bg-dark text-white"><?php echo e($p->gelombang->nama ?? '-'); ?></span>
                            </td>
                            <td>
                                <?php if($p->status == 'SUBMIT'): ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock"></i> Belum Diverifikasi
                                    </span>
                                <?php elseif($p->status == 'VERIFIKASI_ADMIN'): ?>
                                    <span class="badge bg-info text-dark">
                                        <i class="fas fa-exclamation-triangle"></i> Perlu Perbaikan
                                    </span>
                                <?php elseif($p->status == 'MENUNGGU_PEMBAYARAN'): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Lulus Administrasi
                                    </span>
                                <?php elseif($p->status == 'TIDAK_LULUS'): ?>
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times"></i> Ditolak
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?php echo e($p->status); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                    $jumlahBerkas = $p->berkas->count();
                                    $berkasLengkap = $jumlahBerkas >= 4; // Minimal 4 berkas
                                ?>
                                <?php if($berkasLengkap): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Lengkap (<?php echo e($jumlahBerkas); ?>)
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-exclamation"></i> Kurang (<?php echo e($jumlahBerkas); ?>)
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small>
                                    <?php echo e($p->created_at->format('d/m/Y')); ?><br>
                                    <span class="text-muted"><?php echo e($p->created_at->format('H:i')); ?></span>
                                </small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('verifikator.detail', $p->id)); ?>" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if($p->status == 'SUBMIT' || $p->status == 'VERIFIKASI_ADMIN'): ?>
                                        <a href="<?php echo e(route('verifikator.detail', $p->id)); ?>" class="btn btn-sm btn-outline-success" title="Verifikasi">
                                            <i class="fas fa-clipboard-check"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-600">Tidak Ada Data Pendaftar</h5>
                <p class="text-muted">Belum ada pendaftar yang perlu diverifikasi atau sesuai dengan filter yang dipilih.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 2rem;
    height: 2rem;
    font-size: 0.875rem;
}
.text-gray-800 { color: #212529 !important; }
.text-gray-600 { color: #6c757d !important; }
.text-gray-300 { color: #adb5bd !important; }
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
.btn-group .btn {
    margin-right: 2px;
}
.badge {
    font-size: 0.75em;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/verifikator/pendaftar.blade.php ENDPATH**/ ?>