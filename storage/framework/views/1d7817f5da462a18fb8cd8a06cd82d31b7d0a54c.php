<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <h3 class="mb-1"><i class="fas fa-credit-card me-2 text-primary"></i>Pembayaran Pendaftaran</h3>
                <p class="text-muted mb-0">Upload bukti pembayaran untuk melanjutkan proses pendaftaran</p>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i><?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column: Info & Status -->
        <div class="col-lg-4 mb-4">
            <!-- Informasi Pendaftar -->
            <div class="card h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Pendaftar</h6>
                </div>
                <div class="card-body">
                    <div class="info-item mb-3">
                        <label class="text-muted small">No. Pendaftaran</label>
                        <p class="fw-bold mb-0"><?php echo e($pendaftar->no_pendaftaran); ?></p>
                    </div>
                    <div class="info-item mb-3">
                        <label class="text-muted small">Nama Lengkap</label>
                        <p class="fw-bold mb-0"><?php echo e($pendaftar->dataSiswa->nama ?? 'Belum diisi'); ?></p>
                    </div>
                    <div class="info-item mb-3">
                        <label class="text-muted small">Jurusan Pilihan</label>
                        <p class="fw-bold mb-0"><?php echo e($pendaftar->jurusan->nama); ?></p>
                    </div>
                    <div class="info-item mb-4">
                        <label class="text-muted small">Gelombang</label>
                        <p class="fw-bold mb-0"><?php echo e($pendaftar->gelombang->nama); ?></p>
                    </div>
                    
                    <div class="payment-amount text-center p-3 bg-primary bg-opacity-10 rounded">
                        <label class="text-muted small d-block">Total Biaya Pendaftaran</label>
                        <h4 class="text-primary mb-0">Rp <?php echo e(number_format($pendaftar->gelombang->biaya_daftar ?? 150000, 0, ',', '.')); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Payment Methods & Upload -->
        <div class="col-lg-8">
            <!-- Payment Methods -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-credit-card me-2"></i>Pilih Metode Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        <!-- Transfer Bank -->
                        <div class="col-md-4">
                            <div class="payment-option h-100">
                                <div class="card border-primary h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-university fa-2x text-primary mb-3"></i>
                                        <h6 class="fw-bold">Transfer Bank</h6>
                                        <div class="bank-details mt-3">
                                            <div class="bg-light p-3 rounded">
                                                <p class="mb-1 fw-bold">Bank BCA</p>
                                                <p class="mb-1">No. Rekening</p>
                                                <h6 class="text-primary">1234567890</h6>
                                                <p class="mb-0 small">A.n: SMK BaktiNusantara 666</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- QRIS -->
                        <div class="col-md-4">
                            <div class="payment-option h-100">
                                <div class="card border-success h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-qrcode fa-2x text-success mb-3"></i>
                                        <h6 class="fw-bold">QRIS</h6>
                                        <div class="qr-details mt-3">
                                            <div class="bg-light p-3 rounded">
                                                <div class="qr-code-container position-relative" onclick="openQRModal()">
                                                    <?php echo QrCode::size(100)->generate('SMK_BAKTINUSANTARA_666_PPDB_' . $pendaftar->no_pendaftaran . '_' . ($pendaftar->gelombang->biaya_daftar ?? 150000)); ?>

                                                    <div class="qr-overlay">
                                                        <i class="fas fa-search-plus"></i>
                                                    </div>
                                                </div>
                                                <p class="mb-0 small mt-2 text-primary"><i class="fas fa-click me-1"></i>Klik untuk memperbesar</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Virtual Account -->
                        <div class="col-md-4">
                            <div class="payment-option h-100">
                                <div class="card border-warning h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-mobile-alt fa-2x text-warning mb-3"></i>
                                        <h6 class="fw-bold">Virtual Account</h6>
                                        <div class="va-details mt-3">
                                            <div class="bg-light p-3 rounded">
                                                <p class="mb-1 fw-bold">BNI Virtual Account</p>
                                                <p class="mb-1">VA Number</p>
                                                <h6 class="text-warning">8808<?php echo e(str_pad($pendaftar->id, 6, '0', STR_PAD_LEFT)); ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Pembayaran -->
            <?php if($pendaftar->pembayaran): ?>
                <?php
                    $status = $pendaftar->pembayaran->status;
                    $statusConfig = [
                        'pending' => ['color' => 'warning', 'icon' => 'clock', 'text' => 'Menunggu Pembayaran'],
                        'paid' => ['color' => 'info', 'icon' => 'upload', 'text' => 'Menunggu Verifikasi'],
                        'verified' => ['color' => 'success', 'icon' => 'check-circle', 'text' => 'Pembayaran Terverifikasi'],
                        'rejected' => ['color' => 'danger', 'icon' => 'times-circle', 'text' => 'Pembayaran Ditolak']
                    ];
                    $config = $statusConfig[$status] ?? ['color' => 'secondary', 'icon' => 'question', 'text' => 'Status Tidak Diketahui'];
                ?>
                
                <div class="card mb-4 border-<?php echo e($config['color']); ?>">
                    <div class="card-header bg-<?php echo e($config['color']); ?> bg-opacity-10">
                        <h6 class="mb-0 text-<?php echo e($config['color']); ?>"><i class="fas fa-<?php echo e($config['icon']); ?> me-2"></i>Status Pembayaran Anda</h6>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                <div class="status-badge">
                                    <i class="fas fa-<?php echo e($config['icon']); ?> fa-3x text-<?php echo e($config['color']); ?>"></i>
                                    <p class="mt-2 mb-0">
                                        <span class="badge bg-<?php echo e($config['color']); ?> px-3 py-2">
                                            <?php echo e($config['text']); ?>

                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="info-item mb-2">
                                            <label class="text-muted small">Nominal Pembayaran</label>
                                            <p class="fw-bold text-<?php echo e($config['color']); ?> mb-0">Rp <?php echo e(number_format($pendaftar->pembayaran->nominal, 0, ',', '.')); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="info-item mb-2">
                                            <label class="text-muted small">Metode Pembayaran</label>
                                            <p class="fw-bold mb-0"><?php echo e(strtoupper($pendaftar->pembayaran->metode_pembayaran)); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="info-item mb-2">
                                            <label class="text-muted small">Tanggal Upload</label>
                                            <p class="fw-bold mb-0"><?php echo e($pendaftar->pembayaran->tanggal_bayar->format('d M Y, H:i')); ?></p>
                                        </div>
                                    </div>
                                    <?php if($pendaftar->pembayaran->verified_at): ?>
                                        <div class="col-sm-6">
                                            <div class="info-item mb-2">
                                                <label class="text-muted small">Tanggal Verifikasi</label>
                                                <p class="fw-bold mb-0"><?php echo e($pendaftar->pembayaran->verified_at->format('d M Y, H:i')); ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-sm-6">
                                        <?php if($pendaftar->pembayaran->bukti_bayar): ?>
                                            <div class="info-item">
                                                <label class="text-muted small">Bukti Pembayaran</label>
                                                <div class="d-flex gap-2">
                                                    <a href="<?php echo e(Storage::url($pendaftar->pembayaran->bukti_bayar)); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye me-1"></i>Lihat Bukti
                                                    </a>
                                                    <?php if($status == 'verified'): ?>
                                                        <a href="<?php echo e(route('siswa.cetak-bukti-pembayaran')); ?>" class="btn btn-outline-success btn-sm">
                                                            <i class="fas fa-print me-1"></i>Cetak PDF
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <?php if($pendaftar->pembayaran->catatan_verifikasi): ?>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="alert alert-<?php echo e($status == 'rejected' ? 'danger' : 'info'); ?> mb-0">
                                                <h6 class="alert-heading mb-2">
                                                    <i class="fas fa-<?php echo e($status == 'rejected' ? 'exclamation-triangle' : 'info-circle'); ?> me-2"></i>
                                                    Catatan dari Tim Keuangan:
                                                </h6>
                                                <p class="mb-0"><?php echo e($pendaftar->pembayaran->catatan_verifikasi); ?></p>
                                                <?php if($pendaftar->pembayaran->verifiedBy): ?>
                                                    <hr class="my-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-user me-1"></i>Diverifikasi oleh: <?php echo e($pendaftar->pembayaran->verifiedBy->name); ?>

                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Upload Form -->
            <?php if(!$pendaftar->pembayaran || $pendaftar->pembayaran->status == 'rejected'): ?>
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-upload me-2"></i>
                            <?php echo e($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'rejected' ? 'Upload Ulang Bukti Pembayaran' : 'Upload Bukti Pembayaran'); ?>

                        </h6>
                    </div>
                    <div class="card-body">
                        <?php if($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'rejected'): ?>
                            <div class="alert alert-warning mb-3">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Pembayaran sebelumnya ditolak.</strong> Silakan upload bukti pembayaran yang baru sesuai catatan dari tim keuangan.
                            </div>
                        <?php endif; ?>
                        
                        <form action="<?php echo e(route('siswa.upload-pembayaran')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="metode_pembayaran" class="form-label fw-bold">Metode Pembayaran <span class="text-danger">*</span></label>
                                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                                        <option value="">-- Pilih Metode Pembayaran --</option>
                                        <option value="transfer">Transfer Bank BCA</option>
                                        <option value="va">Virtual Account BNI</option>
                                        <option value="qris">QRIS</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="bukti_bayar" class="form-label fw-bold">File Bukti Pembayaran <span class="text-danger">*</span></label>
                                    <input type="file" name="bukti_bayar" id="bukti_bayar" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>Format: JPG, PNG, PDF | Maksimal: 2MB
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-grid d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary btn-lg px-4">
                                            <i class="fas fa-upload me-2"></i>
                                            <?php echo e($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'rejected' ? 'Upload Ulang' : 'Upload Bukti Pembayaran'); ?>

                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="card mb-4 border-info">
                    <div class="card-header bg-info bg-opacity-10">
                        <h6 class="mb-0 text-info"><i class="fas fa-info-circle me-2"></i>Informasi Upload</h6>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h6 class="text-success">Bukti pembayaran sudah diupload</h6>
                        <p class="text-muted mb-0">
                            <?php if($pendaftar->pembayaran->status == 'paid'): ?>
                                Tim keuangan sedang memverifikasi pembayaran Anda. Mohon tunggu 1-2 hari kerja.
                            <?php elseif($pendaftar->pembayaran->status == 'verified'): ?>
                                Pembayaran Anda telah terverifikasi. Silakan lanjutkan ke tahap berikutnya.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Informasi & Bantuan -->
    <div class="row">
        <div class="col-12">
            <div class="card border-info">
                <div class="card-header bg-info bg-opacity-10">
                    <h6 class="mb-0 text-info"><i class="fas fa-lightbulb me-2"></i>Petunjuk & Informasi Penting</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-list-check me-2"></i>Petunjuk Pembayaran</h6>
                            <div class="checklist">
                                <div class="check-item mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Upload bukti pembayaran yang jelas dan terbaca</span>
                                </div>
                                <div class="check-item mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Pastikan nominal sesuai dengan biaya pendaftaran</span>
                                </div>
                                <div class="check-item mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Cantumkan nomor pendaftaran pada keterangan transfer</span>
                                </div>
                                <div class="check-item mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>File format: JPG, PNG, atau PDF (maksimal 2MB)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="text-info mb-3"><i class="fas fa-clock me-2"></i>Proses Verifikasi</h6>
                            <div class="process-info">
                                <div class="process-item mb-2">
                                    <i class="fas fa-arrow-right text-primary me-2"></i>
                                    <span>Data otomatis masuk ke sistem keuangan</span>
                                </div>
                                <div class="process-item mb-2">
                                    <i class="fas fa-arrow-right text-primary me-2"></i>
                                    <span>Tim keuangan akan memverifikasi dalam 1-2 hari kerja</span>
                                </div>
                                <div class="process-item mb-2">
                                    <i class="fas fa-arrow-right text-primary me-2"></i>
                                    <span>Status akan diupdate di timeline secara otomatis</span>
                                </div>
                                <div class="process-item mb-2">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    <span>Jika ditolak, Anda dapat upload ulang bukti pembayaran</span>
                                </div>
                                <div class="process-item mb-2">
                                    <i class="fas fa-phone text-success me-2"></i>
                                    <span>Hubungi <strong>(022) 123-4567</strong> jika ada kendala</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrModalLabel">
                    <i class="fas fa-qrcode me-2"></i>QR Code Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="qr-large mb-3">
                    <?php echo QrCode::size(250)->generate('SMK_BAKTINUSANTARA_666_PPDB_' . $pendaftar->no_pendaftaran . '_' . ($pendaftar->gelombang->biaya_daftar ?? 150000)); ?>

                </div>
                <div class="qr-info">
                    <h6 class="text-primary">Informasi Pembayaran</h6>
                    <p class="mb-1"><strong>No. Pendaftaran:</strong> <?php echo e($pendaftar->no_pendaftaran); ?></p>
                    <p class="mb-1"><strong>Nama:</strong> <?php echo e($pendaftar->dataSiswa->nama ?? 'Belum diisi'); ?></p>
                    <p class="mb-1"><strong>Jurusan:</strong> <?php echo e($pendaftar->jurusan->nama); ?></p>
                    <p class="mb-3"><strong>Total Bayar:</strong> <span class="text-success fw-bold">Rp <?php echo e(number_format($pendaftar->gelombang->biaya_daftar ?? 150000, 0, ',', '.')); ?></span></p>
                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            Scan QR Code ini menggunakan aplikasi mobile banking atau e-wallet yang mendukung QRIS
                        </small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="downloadQR()">
                    <i class="fas fa-download me-1"></i>Download QR
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    padding: 1rem 0;
    border-bottom: 2px solid #e9ecef;
}

.info-item label {
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.25rem;
    display: block;
}

.payment-option .card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.payment-option .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.status-badge {
    padding: 1rem;
}

.check-item, .process-item {
    display: flex;
    align-items: flex-start;
    font-size: 0.9rem;
}

.check-item i, .process-item i {
    margin-top: 0.1rem;
    flex-shrink: 0;
}

.qr-code-container {
    transition: all 0.3s ease;
    display: inline-block;
    position: relative;
    cursor: pointer;
    border-radius: 8px;
    overflow: hidden;
}

.qr-code-container:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.qr-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    color: white;
    font-size: 1.5rem;
}

.qr-code-container:hover .qr-overlay {
    opacity: 1;
}

.modal-body .qr-large {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    display: inline-block;
}

@media (max-width: 768px) {
    .col-lg-4 {
        margin-bottom: 1.5rem;
    }
    
    .payment-option {
        margin-bottom: 1rem;
    }
    
    .modal-body .qr-large {
        padding: 15px;
    }
}
</style>

<script>
function openQRModal() {
    var qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
    qrModal.show();
}

function downloadQR() {
    // Create canvas from QR code
    const qrSvg = document.querySelector('#qrModal .qr-large svg');
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    
    // Set canvas size
    canvas.width = 250;
    canvas.height = 250;
    
    // Convert SVG to image
    const data = new XMLSerializer().serializeToString(qrSvg);
    const img = new Image();
    const svgBlob = new Blob([data], {type: 'image/svg+xml;charset=utf-8'});
    const url = URL.createObjectURL(svgBlob);
    
    img.onload = function() {
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, 250, 250);
        
        // Download
        const link = document.createElement('a');
        link.download = 'qr-code-pembayaran-<?php echo e($pendaftar->no_pendaftaran); ?>.png';
        link.href = canvas.toDataURL();
        link.click();
        
        URL.revokeObjectURL(url);
    };
    
    img.src = url;
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('siswa.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/siswa/pembayaran.blade.php ENDPATH**/ ?>