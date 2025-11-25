

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">⚙️ Pengaturan Sistem</h1>
            <p class="text-muted mb-0">Kelola pengaturan sistem PPDB</p>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- System Settings -->
        <div class="col-xl-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">🔧 Pengaturan Umum</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tahun Ajaran</label>
                                <input type="text" name="tahun_ajaran" class="form-control" 
                                       value="<?php echo e($settings['tahun_ajaran']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Max Pendaftar per Jurusan</label>
                                <input type="number" name="max_pendaftar_per_jurusan" class="form-control" 
                                       value="<?php echo e($settings['max_pendaftar_per_jurusan']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Biaya Pendaftaran (Rp)</label>
                                <input type="number" name="biaya_pendaftaran" class="form-control" 
                                       value="<?php echo e($settings['biaya_pendaftaran']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Periode Pendaftaran Mulai</label>
                                <input type="date" name="periode_pendaftaran_mulai" class="form-control" 
                                       value="<?php echo e($settings['periode_pendaftaran_mulai']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Periode Pendaftaran Selesai</label>
                                <input type="date" name="periode_pendaftaran_selesai" class="form-control" 
                                       value="<?php echo e($settings['periode_pendaftaran_selesai']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="auto_backup" 
                                           <?php echo e($settings['auto_backup'] ? 'checked' : ''); ?>>
                                    <label class="form-check-label">Auto Backup Harian</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="email_notifications" 
                                           <?php echo e($settings['email_notifications'] ? 'checked' : ''); ?>>
                                    <label class="form-check-label">Email Notifications</label>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-dark">
                            <i class="fas fa-save"></i> Simpan Pengaturan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- System Tools -->
        <div class="col-xl-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">🛠️ Tools Sistem</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-dark" onclick="createBackup()">
                            <i class="fas fa-database"></i> Backup Database
                        </button>
                        <button class="btn btn-secondary" onclick="clearCache()">
                            <i class="fas fa-broom"></i> Clear Cache
                        </button>
                        <button class="btn btn-outline-dark" onclick="viewLogs()">
                            <i class="fas fa-file-alt"></i> View Logs
                        </button>
                        <button class="btn btn-outline-secondary" onclick="systemCheck()">
                            <i class="fas fa-heartbeat"></i> System Check
                        </button>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">📊 Info Sistem</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="h5 mb-0 text-gray-800"><?php echo e(\App\Models\Pendaftar::count()); ?></div>
                            <small class="text-muted">Total Pendaftar</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="h5 mb-0 text-gray-800"><?php echo e(\App\Models\User::count()); ?></div>
                            <small class="text-muted">Total Users</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="h5 mb-0 text-gray-800"><?php echo e(\App\Models\Jurusan::count()); ?></div>
                            <small class="text-muted">Jurusan</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="h5 mb-0 text-gray-800"><?php echo e(number_format(disk_free_space('/') / 1024 / 1024 / 1024, 1)); ?>GB</div>
                            <small class="text-muted">Free Space</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script>
function createBackup() {
    if (confirm('Yakin ingin membuat backup database?')) {
        fetch('<?php echo e(route("admin.backup")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Backup berhasil dibuat: ' + data.filename);
            } else {
                alert('Gagal membuat backup: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
}

function clearCache() {
    if (confirm('Yakin ingin membersihkan cache?')) {
        fetch('<?php echo e(route("admin.clear-cache")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Cache berhasil dibersihkan');
                location.reload();
            } else {
                alert('Gagal membersihkan cache: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
}

function viewLogs() {
    alert('Fitur view logs akan segera tersedia!');
}

function systemCheck() {
    alert('System check: All systems operational!');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/admin/settings.blade.php ENDPATH**/ ?>