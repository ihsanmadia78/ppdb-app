<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-upload me-2"></i>Perbaikan Berkas</h4>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>
                    
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>

                    <?php if($pendaftar->status != 'BERKAS_DITOLAK'): ?>
                        <div class="alert alert-info">
                            Status Anda saat ini: <strong><?php echo e($pendaftar->status); ?></strong>. 
                            Perbaikan berkas hanya untuk status BERKAS_DITOLAK.
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <h5><i class="fas fa-info-circle"></i> Informasi</h5>
                            <p>Silakan upload ulang berkas yang ditolak. Pastikan berkas sudah sesuai dengan ketentuan:</p>
                            <ul>
                                <li>Format: PDF, JPG, atau PNG</li>
                                <li>Ukuran maksimal: 5MB per file</li>
                                <li>Berkas harus jelas dan terbaca</li>
                            </ul>
                        </div>

                        <form method="POST" action="<?php echo e(route('siswa.perbaikan-berkas.store')); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ijazah/SKHUN</label>
                                    <input type="file" name="ijazah" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kartu Keluarga</label>
                                    <input type="file" name="kk" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Akta Kelahiran</label>
                                    <input type="file" name="akta" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pas Foto</label>
                                    <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="<?php echo e(route('siswa.dashboard')); ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perbaikan
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('siswa.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/siswa/perbaikan-berkas.blade.php ENDPATH**/ ?>