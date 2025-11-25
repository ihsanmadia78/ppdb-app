

<?php $__env->startSection('title', 'Input Manual Pembayaran - Keuangan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">💰 Input Manual Pembayaran</h1>
            <p class="text-muted mb-0">Tambah pembayaran tunai atau offline</p>
        </div>
        <a href="<?php echo e(route('keuangan.pembayaran')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">📝 Form Input Pembayaran Manual</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('keuangan.pembayaran.manual.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-search me-1"></i>Cari Pendaftar *</label>
                        <input type="text" id="searchPendaftar" class="form-control" placeholder="Ketik nama atau nomor pendaftaran..." autocomplete="off">
                        <div id="searchResults" class="list-group mt-2" style="display: none; position: absolute; z-index: 1000; width: calc(50% - 15px);"></div>
                        <input type="hidden" name="pendaftar_id" id="pendaftar_id" required>
                        <div id="selectedPendaftar" class="mt-2"></div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-money-bill me-1"></i>Nominal Pembayaran *</label>
                        <input type="number" name="nominal" class="form-control" value="<?php echo e(old('nominal')); ?>" placeholder="Contoh: 150000" required>
                        <small class="text-muted">Masukkan nominal dalam rupiah</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-calendar me-1"></i>Tanggal Pembayaran *</label>
                        <input type="datetime-local" name="tanggal_bayar" class="form-control" value="<?php echo e(old('tanggal_bayar', now()->format('Y-m-d\TH:i'))); ?>" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-credit-card me-1"></i>Metode Pembayaran *</label>
                        <select name="metode_pembayaran" class="form-select" required>
                            <option value="">Pilih Metode Pembayaran</option>
                            <option value="tunai" <?php echo e(old('metode_pembayaran') == 'tunai' ? 'selected' : ''); ?>>💵 Tunai</option>
                            <option value="transfer" <?php echo e(old('metode_pembayaran') == 'transfer' ? 'selected' : ''); ?>>🏦 Transfer Bank</option>
                            <option value="qris" <?php echo e(old('metode_pembayaran') == 'qris' ? 'selected' : ''); ?>>📱 QRIS</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-sticky-note me-1"></i>Catatan</label>
                    <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan tambahan (opsional)"><?php echo e(old('catatan')); ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label"><i class="fas fa-file-upload me-1"></i>Upload Bukti (Opsional)</label>
                    <input type="file" name="bukti_pembayaran" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">Format: PDF, JPG, PNG (Max: 5MB)</small>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Informasi:</strong> Pembayaran manual akan langsung berstatus "Terverifikasi" dan tidak perlu verifikasi ulang.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i>Simpan Pembayaran
                    </button>
                    <a href="<?php echo e(route('keuangan.pembayaran')); ?>" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('searchPendaftar').addEventListener('input', function() {
    const query = this.value;
    const resultsDiv = document.getElementById('searchResults');
    
    if (query.length < 2) {
        resultsDiv.style.display = 'none';
        return;
    }
    
    fetch(`/keuangan/search-pendaftar?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            resultsDiv.innerHTML = '';
            
            if (data.length > 0) {
                data.forEach(pendaftar => {
                    const item = document.createElement('a');
                    item.className = 'list-group-item list-group-item-action';
                    item.href = '#';
                    item.innerHTML = `
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>${pendaftar.nama}</strong><br>
                                <small class="text-muted">${pendaftar.no_pendaftaran} - ${pendaftar.jurusan}</small>
                            </div>
                            <span class="badge bg-secondary">${pendaftar.status}</span>
                        </div>
                    `;
                    
                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        selectPendaftar(pendaftar);
                    });
                    
                    resultsDiv.appendChild(item);
                });
                resultsDiv.style.display = 'block';
            } else {
                resultsDiv.innerHTML = '<div class="list-group-item text-muted">Tidak ada pendaftar ditemukan</div>';
                resultsDiv.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            resultsDiv.style.display = 'none';
        });
});

function selectPendaftar(pendaftar) {
    document.getElementById('pendaftar_id').value = pendaftar.id;
    document.getElementById('searchPendaftar').value = pendaftar.nama;
    document.getElementById('searchResults').style.display = 'none';
    
    document.getElementById('selectedPendaftar').innerHTML = `
        <div class="alert alert-success">
            <strong>Pendaftar Dipilih:</strong><br>
            ${pendaftar.nama} (${pendaftar.no_pendaftaran})<br>
            <small>Jurusan: ${pendaftar.jurusan}</small>
        </div>
    `;
}

// Hide search results when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('#searchPendaftar') && !e.target.closest('#searchResults')) {
        document.getElementById('searchResults').style.display = 'none';
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/keuangan/manual-payment.blade.php ENDPATH**/ ?>