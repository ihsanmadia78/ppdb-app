<?php $__env->startSection('title', 'Manajemen Jurusan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">📚 Manajemen Jurusan</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus me-1"></i>Tambah Jurusan
        </button>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Jurusan</th>
                            <th>Kuota</th>
                            <th>Diterima</th>
                            <th>Sisa Kuota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $jurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $diterima = $j->pendaftar->where('status', 'LULUS')->count();
                            $sisaKuota = ($j->kuota ?? 30) - $diterima;
                        ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td><span class="badge bg-primary"><?php echo e($j->kode); ?></span></td>
                            <td><?php echo e($j->nama); ?></td>
                            <td>
                                <span class="badge bg-info"><?php echo e($j->kuota ?? 30); ?></span>
                            </td>
                            <td>
                                <span class="badge bg-success"><?php echo e($diterima); ?></span>
                            </td>
                            <td>
                                <?php if($sisaKuota > 0): ?>
                                    <span class="badge bg-warning text-dark"><?php echo e($sisaKuota); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger">PENUH</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editJurusan(<?php echo e($j->id); ?>, '<?php echo e($j->nama); ?>', '<?php echo e($j->kode); ?>', <?php echo e($j->kuota ?? 30); ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <?php if($j->pendaftar_count == 0): ?>
                                <form method="POST" action="<?php echo e(route('admin.jurusan.destroy', $j->id)); ?>" class="d-inline" onsubmit="return confirm('Yakin hapus jurusan ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data jurusan</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo e(route('admin.jurusan.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Jurusan</label>
                        <input type="text" name="kode" class="form-control" required maxlength="10">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Jurusan</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kuota Siswa</label>
                        <input type="number" name="kuota" class="form-control" value="30" min="1" max="100" required>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="editForm">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Jurusan</label>
                        <input type="text" name="kode" id="editKode" class="form-control" required maxlength="10">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Jurusan</label>
                        <input type="text" name="nama" id="editNama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kuota Siswa</label>
                        <input type="number" name="kuota" id="editKuota" class="form-control" min="1" max="100" required>
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

<script>
function editJurusan(id, nama, kode, kuota) {
    document.getElementById('editForm').action = `<?php echo e(url('/admin/jurusan')); ?>/${id}`;
    document.getElementById('editNama').value = nama;
    document.getElementById('editKode').value = kode;
    document.getElementById('editKuota').value = kuota;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/admin/jurusan.blade.php ENDPATH**/ ?>