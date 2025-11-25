

<?php $__env->startSection('title', 'Kelola Gelombang'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Kelola Gelombang</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    <i class="fas fa-plus"></i> Tambah Gelombang
                </button>
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Gelombang</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Gelombang</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Kuota</th>
                            <th>Biaya Daftar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $gelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($g->nama); ?></td>
                            <td><?php echo e($g->tgl_mulai ? \Carbon\Carbon::parse($g->tgl_mulai)->format('d/m/Y') : ($g->tanggal_mulai ? \Carbon\Carbon::parse($g->tanggal_mulai)->format('d/m/Y') : '-')); ?></td>
                            <td><?php echo e($g->tgl_selesai ? \Carbon\Carbon::parse($g->tgl_selesai)->format('d/m/Y') : ($g->tanggal_selesai ? \Carbon\Carbon::parse($g->tanggal_selesai)->format('d/m/Y') : '-')); ?></td>
                            <td><?php echo e($g->kuota); ?></td>
                            <td><strong>Rp <?php echo e(number_format($g->biaya_daftar ?? 0, 0, ',', '.')); ?></strong></td>
                            <td>
                                <?php if($g->status == 'aktif'): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Non-aktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo e($g->id); ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="POST" action="<?php echo e(route('admin.gelombang.delete', $g->id)); ?>" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Gelombang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo e(route('admin.gelombang.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Gelombang</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kuota</label>
                        <input type="number" name="kuota" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya Daftar (Rp)</label>
                        <input type="number" name="biaya_daftar" class="form-control" placeholder="Contoh: 5000000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non-aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php $__currentLoopData = $gelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="editModal<?php echo e($g->id); ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Gelombang: <?php echo e($g->nama); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo e(route('admin.gelombang.update', $g->id)); ?>" id="editForm<?php echo e($g->id); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Gelombang</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo e($g->nama); ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" value="<?php echo e($g->tgl_mulai ?? $g->tanggal_mulai); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" value="<?php echo e($g->tgl_selesai ?? $g->tanggal_selesai); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kuota</label>
                        <input type="number" name="kuota" class="form-control" value="<?php echo e($g->kuota); ?>" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya Daftar (Rp)</label>
                        <input type="number" name="biaya_daftar" class="form-control" value="<?php echo e($g->biaya_daftar ?? 0); ?>" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="aktif" <?php echo e($g->status == 'aktif' ? 'selected' : ''); ?>>Aktif</option>
                            <option value="nonaktif" <?php echo e($g->status == 'nonaktif' ? 'selected' : ''); ?>>Non-aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add form submission handler for better debugging
    <?php $__currentLoopData = $gelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    document.getElementById('editForm<?php echo e($g->id); ?>').addEventListener('submit', function(e) {
        console.log('Form <?php echo e($g->id); ?> submitted with data:', new FormData(this));
    });
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/admin/gelombang.blade.php ENDPATH**/ ?>