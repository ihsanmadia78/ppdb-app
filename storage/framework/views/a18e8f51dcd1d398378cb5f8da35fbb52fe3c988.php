<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pendaftaran - PPDB SMK BaktiNusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #37474f;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #212529;
        }
        .check-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
            margin: 2rem 0;
        }
        .check-header {
            background: #37474f;
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .check-body {
            padding: 2rem;
        }
        .navbar {
            background: rgba(255,255,255,0.95) !important;
            backdrop-filter: blur(10px);
        }
        .navbar-brand {
            color: #495057 !important;
            font-weight: bold;
        }
        .status-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: -22px;
            top: 30px;
            width: 2px;
            height: calc(100% + 10px);
            background-color: #e3e6f0;
        }
        .timeline-marker {
            position: absolute;
            left: -30px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
        }
        .timeline-item.active .timeline-marker {
            width: 20px;
            height: 20px;
            font-size: 10px;
        }
        .btn-primary {
            background: #37474f;
            border: none;
        }
        .btn-primary:hover {
            background: #37474f;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <i class="fas fa-graduation-cap me-2"></i>PPDB SMK BaktiNusantara 666
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="<?php echo e(route('home')); ?>">Beranda</a>
                <a class="nav-link" href="<?php echo e(route('pendaftaran.create')); ?>">Daftar</a>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="check-container">
                    <div class="check-header">
                        <h2 class="mb-0"><i class="fas fa-search me-2"></i>Cek Status Pendaftaran</h2>
                        <p class="mb-0 mt-2">Masukkan nomor pendaftaran Anda</p>
                    </div>

                    <div class="check-body">
                        <?php if(session('error')): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i><?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('pendaftaran.cek.result')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-id-card me-1"></i>Nomor Pendaftaran</label>
                                <input type="text" name="no_pendaftaran" class="form-control form-control-lg" 
                                       placeholder="Contoh: PPDB20241201123456ABC" required>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Nomor pendaftaran diberikan setelah Anda menyelesaikan pendaftaran
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-search me-2"></i>Cek Status
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="text-muted mb-3">Belum mendaftar?</p>
                            <a href="<?php echo e(route('pendaftaran.create')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(isset($pendaftar)): ?>
        <div class="row justify-content-center mt-4">
            <div class="col-lg-8">
                <div class="status-card card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Pendaftaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>No. Pendaftaran:</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-info fs-6 me-2" id="noPendaftaran"><?php echo e($pendaftar->no_pendaftaran); ?></span>
                                                <button class="btn btn-sm btn-outline-primary" onclick="copyNoPendaftaran()" title="Salin Nomor Pendaftaran">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama Lengkap:</strong></td>
                                        <td><?php echo e($pendaftar->dataSiswa?->nama ?? '-'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>NISN:</strong></td>
                                        <td><?php echo e($pendaftar->dataSiswa?->nisn ?? '-'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jurusan Pilihan:</strong></td>
                                        <td><span class="badge bg-secondary"><?php echo e($pendaftar->jurusan?->nama ?? '-'); ?></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Gelombang:</strong></td>
                                        <td><?php echo e($pendaftar->gelombang?->nama ?? '-'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Daftar:</strong></td>
                                        <td><?php echo e($pendaftar->created_at->format('d F Y, H:i')); ?> WIB</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            <?php if($pendaftar->status == 'SUBMIT'): ?>
                                                <span class="badge bg-warning text-dark fs-6">
                                                    <i class="fas fa-clock me-1"></i>Menunggu Verifikasi
                                                </span>
                                            <?php elseif($pendaftar->status == 'DITERIMA'): ?>
                                                <span class="badge bg-success fs-6">
                                                    <i class="fas fa-check me-1"></i>Diterima
                                                </span>
                                            <?php elseif($pendaftar->status == 'DITOLAK'): ?>
                                                <span class="badge bg-danger fs-6">
                                                    <i class="fas fa-times me-1"></i>Ditolak
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Timeline Status -->
                        <div class="card mb-4">
                            <div class="card-header bg-dark text-white">
                                <h6 class="mb-0"><i class="fas fa-timeline me-2"></i>Timeline Status Pendaftaran</h6>
                            </div>
                            <div class="card-body">
                                <?php if($pendaftar->statusTimeline && $pendaftar->statusTimeline->count() > 0): ?>
                                    <div class="timeline">
                                        <?php $__currentLoopData = $pendaftar->statusTimeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="timeline-item <?php echo e($loop->last ? 'active' : 'completed'); ?>">
                                                <div class="timeline-marker bg-<?php echo e(App\Models\PendaftarStatus::getStatusColor($status->status)); ?>">
                                                    <i class="<?php echo e(App\Models\PendaftarStatus::getStatusIcon($status->status)); ?> text-white"></i>
                                                </div>
                                                <div class="timeline-content">
                                                    <h6 class="mb-1"><?php echo e(App\Models\PendaftarStatus::getStatusList()[$status->status] ?? $status->status); ?></h6>
                                                    <p class="text-muted mb-1"><?php echo e($status->keterangan); ?></p>
                                                    <small class="text-muted">
                                                        <?php echo e($status->created_at->format('d F Y, H:i')); ?> WIB
                                                        <?php if($status->updated_by): ?> • oleh <?php echo e($status->updated_by); ?><?php endif; ?>
                                                    </small>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">Belum ada riwayat status.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Status Alert -->
                        <?php
                            $currentStatus = $pendaftar->statusTimeline->last();
                        ?>
                        <?php if($currentStatus): ?>
                            <?php if($currentStatus->status == 'SUBMIT'): ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    <strong>Status: Pendaftaran Dikirim</strong><br>
                                    Pendaftaran Anda telah berhasil dikirim dan sedang menunggu proses verifikasi.
                                </div>
                            <?php elseif($currentStatus->status == 'VERIFIKASI_ADMIN'): ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-user-check me-2"></i>
                                    <strong>Status: Verifikasi Administrasi</strong><br>
                                    Berkas Anda sedang dalam proses verifikasi oleh tim administrasi.
                                </div>
                            <?php elseif($currentStatus->status == 'MENUNGGU_PEMBAYARAN'): ?>
                                <div class="alert alert-primary">
                                    <i class="fas fa-credit-card me-2"></i>
                                    <strong>Status: Menunggu Pembayaran</strong><br>
                                    Silakan lakukan pembayaran biaya pendaftaran sesuai instruksi yang diberikan.
                                </div>
                            <?php elseif($currentStatus->status == 'TERBAYAR'): ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Status: Pembayaran Diterima</strong><br>
                                    Pembayaran Anda telah diterima dan sedang diproses.
                                </div>
                            <?php elseif($currentStatus->status == 'VERIFIKASI_KEUANGAN'): ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-calculator me-2"></i>
                                    <strong>Status: Verifikasi Keuangan</strong><br>
                                    Pembayaran Anda sedang dalam proses verifikasi oleh tim keuangan.
                                </div>
                            <?php elseif($currentStatus->status == 'LULUS'): ?>
                                <div class="alert alert-success">
                                    <i class="fas fa-trophy me-2"></i>
                                    <strong>Selamat! Anda Diterima</strong><br>
                                    Selamat! Anda telah diterima di SMK BaktiNusantara 666. Silakan lakukan daftar ulang.
                                </div>
                            <?php elseif($currentStatus->status == 'TIDAK_LULUS'): ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-times-circle me-2"></i>
                                    <strong>Tidak Lulus</strong><br>
                                    Mohon maaf, Anda belum berhasil pada seleksi kali ini. Tetap semangat!
                                </div>
                            <?php elseif($currentStatus->status == 'CADANGAN'): ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-hourglass-half me-2"></i>
                                    <strong>Status: Cadangan</strong><br>
                                    Anda masuk dalam daftar cadangan. Kami akan menghubungi jika ada kesempatan.
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <div class="text-center mt-4">
                            <button class="btn btn-outline-secondary me-2" onclick="window.print()">
                                <i class="fas fa-print me-1"></i>Cetak
                            </button>
                            <?php if($pendaftar->status == 'SUBMIT'): ?>
                                <a href="<?php echo e(route('pendaftaran.edit', $pendaftar->id)); ?>" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-edit me-1"></i>Edit Data
                                </a>
                                <a href="<?php echo e(route('berkas.index', $pendaftar->id)); ?>" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-upload me-1"></i>Upload Berkas
                                </a>
                                <a href="<?php echo e(route('pembayaran.index', $pendaftar->id)); ?>" class="btn btn-outline-success">
                                    <i class="fas fa-credit-card me-1"></i>Pembayaran
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyNoPendaftaran() {
            <?php if(isset($pendaftar)): ?>
            const noPendaftaran = '<?php echo e($pendaftar->no_pendaftaran); ?>';
            
            // Copy to clipboard
            navigator.clipboard.writeText(noPendaftaran).then(function() {
                showCopySuccess();
            }).catch(function(err) {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = noPendaftaran;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showCopySuccess();
            });
            <?php endif; ?>
        }
        
        function showCopySuccess() {
            // Create temporary success message
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
            alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alert.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                <strong>Berhasil!</strong> Nomor pendaftaran telah disalin.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(alert);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 3000);
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\ppdb-app\resources\views/pendaftaran/cek-status.blade.php ENDPATH**/ ?>