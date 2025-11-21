<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-user-circle me-2"></i>Profil Calon Siswa</h4>
                </div>
                <div class="card-body">
                    <?php if($pendaftar): ?>
                        <div class="row">
                            <!-- Foto Profil -->
                            <div class="col-md-3 text-center">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div class="profile-photo mb-3">
                                            <i class="fas fa-user-circle fa-5x text-primary"></i>
                                        </div>
                                        <h6 class="text-dark fw-bold"><?php echo e($pendaftar->dataSiswa->nama ?? 'Belum diisi'); ?></h6>
                                        <p class="text-muted mb-0"><?php echo e($pendaftar->no_pendaftaran); ?></p>
                                        <span class="badge bg-<?php echo e($pendaftar->status == 'LULUS' ? 'success' : ($pendaftar->status == 'TIDAK_LULUS' ? 'danger' : 'warning')); ?>">
                                            <?php echo e($pendaftar->status); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Profil -->
                            <div class="col-md-9">
                                <div class="card border-info">
                                    <div class="card-header">
                                        <h5><i class="fas fa-info-circle me-2"></i>Informasi Profil</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text-dark fw-bold">Data Pendaftaran</h6>
                                                <table class="table table-sm table-borderless">
                                                    <tr>
                                                        <td width="40%"><strong>No. Pendaftaran</strong></td>
                                                        <td>: <?php echo e($pendaftar->no_pendaftaran); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email</strong></td>
                                                        <td>: <?php echo e($pendaftar->email); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Jurusan Pilihan</strong></td>
                                                        <td>: <?php echo e($pendaftar->jurusan->nama ?? '-'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Gelombang</strong></td>
                                                        <td>: <?php echo e($pendaftar->gelombang->nama ?? '-'); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <?php if($pendaftar->dataSiswa): ?>
                                                <h6 class="text-dark fw-bold">Data Pribadi</h6>
                                                <table class="table table-sm table-borderless">
                                                    <tr>
                                                        <td width="40%"><strong>Nama Lengkap</strong></td>
                                                        <td>: <?php echo e($pendaftar->dataSiswa->nama ?? '-'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>NISN</strong></td>
                                                        <td>: <?php echo e($pendaftar->dataSiswa->nisn ?? '-'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Jenis Kelamin</strong></td>
                                                        <td>: <?php echo e($pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : ($pendaftar->dataSiswa->jk == 'P' ? 'Perempuan' : '-')); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Tempat, Tgl Lahir</strong></td>
                                                        <td>: <?php echo e($pendaftar->dataSiswa->tmp_lahir ?? '-'); ?>, <?php echo e($pendaftar->dataSiswa->tgl_lahir ? \Carbon\Carbon::parse($pendaftar->dataSiswa->tgl_lahir)->format('d/m/Y') : '-'); ?></td>
                                                    </tr>
                                                </table>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline Status Pendaftaran -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><i class="fas fa-timeline me-2"></i>Timeline Status Pendaftaran</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="timeline">
                                            <!-- Step 1: Pendaftaran -->
                                            <div class="timeline-item <?php echo e(in_array($pendaftar->status, ['SUBMIT', 'MENUNGGU_PEMBAYARAN', 'VERIFIKASI_PEMBAYARAN', 'SIAP_SELEKSI', 'LULUS', 'TIDAK_LULUS', 'CADANGAN']) ? 'completed' : 'pending'); ?>">
                                                <div class="timeline-marker">
                                                    <i class="fas fa-user-plus"></i>
                                                </div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Pendaftaran Berhasil</h6>
                                                    <p class="timeline-description">Data pendaftaran telah disubmit dan tersimpan dalam sistem</p>
                                                    <small class="timeline-date"><?php echo e($pendaftar->created_at->format('d M Y, H:i')); ?></small>
                                                </div>
                                            </div>

                                            <!-- Step 2: Pembayaran -->
                                            <?php
                                                $paymentStatus = 'pending';
                                                if($pendaftar->pembayaran) {
                                                    if($pendaftar->pembayaran->status == 'verified') {
                                                        $paymentStatus = 'completed';
                                                    } elseif(in_array($pendaftar->pembayaran->status, ['paid', 'rejected'])) {
                                                        $paymentStatus = 'current';
                                                    }
                                                } elseif($pendaftar->status == 'MENUNGGU_PEMBAYARAN') {
                                                    $paymentStatus = 'current';
                                                }
                                            ?>
                                            <div class="timeline-item <?php echo e($paymentStatus); ?>">
                                                <div class="timeline-marker">
                                                    <i class="fas fa-credit-card"></i>
                                                </div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Pembayaran</h6>
                                                    <?php if($pendaftar->pembayaran): ?>
                                                        <?php
                                                            $statusText = [
                                                                'pending' => 'Menunggu Pembayaran',
                                                                'paid' => 'Menunggu Verifikasi',
                                                                'verified' => 'Pembayaran Terverifikasi',
                                                                'rejected' => 'Pembayaran Ditolak'
                                                            ];
                                                        ?>
                                                        <p class="timeline-description">
                                                            <?php echo e($statusText[$pendaftar->pembayaran->status] ?? 'Status Tidak Diketahui'); ?>

                                                            <?php if($pendaftar->pembayaran->status == 'rejected'): ?>
                                                                <br><small class="text-danger">Silakan upload ulang bukti pembayaran</small>
                                                            <?php endif; ?>
                                                        </p>
                                                        <small class="timeline-date"><?php echo e($pendaftar->pembayaran->created_at->format('d M Y, H:i')); ?></small>
                                                    <?php else: ?>
                                                        <p class="timeline-description">Silakan upload bukti pembayaran</p>
                                                        <small class="timeline-date text-muted">Belum ada pembayaran</small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <!-- Step 3: Verifikasi -->
                                            <?php
                                                $verificationStatus = 'pending';
                                                if($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'verified') {
                                                    $verificationStatus = 'completed';
                                                } elseif($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'paid' || $pendaftar->status == 'VERIFIKASI_PEMBAYARAN') {
                                                    $verificationStatus = 'current';
                                                }
                                            ?>
                                            <div class="timeline-item <?php echo e($verificationStatus); ?>">
                                                <div class="timeline-marker">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Verifikasi Pembayaran</h6>
                                                    <?php if($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'verified'): ?>
                                                        <p class="timeline-description">Pembayaran telah diverifikasi oleh tim keuangan</p>
                                                        <small class="timeline-date"><?php echo e($pendaftar->pembayaran->verified_at ? $pendaftar->pembayaran->verified_at->format('d M Y, H:i') : 'Terverifikasi'); ?></small>
                                                    <?php elseif($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'paid'): ?>
                                                        <p class="timeline-description">Sedang dalam proses verifikasi pembayaran</p>
                                                        <small class="timeline-date text-warning">Dalam proses...</small>
                                                    <?php elseif($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'rejected'): ?>
                                                        <p class="timeline-description text-danger">Pembayaran ditolak oleh tim keuangan</p>
                                                        <small class="timeline-date text-danger">Ditolak</small>
                                                    <?php else: ?>
                                                        <p class="timeline-description">Menunggu verifikasi pembayaran</p>
                                                        <small class="timeline-date text-muted">Belum diverifikasi</small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <!-- Step 4: Seleksi -->
                                            <div class="timeline-item <?php echo e(in_array($pendaftar->status, ['LULUS', 'TIDAK_LULUS', 'CADANGAN']) ? 'completed' : 'pending'); ?>">
                                                <div class="timeline-marker">
                                                    <i class="fas fa-clipboard-check"></i>
                                                </div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Proses Seleksi</h6>
                                                    <?php if(in_array($pendaftar->status, ['LULUS', 'TIDAK_LULUS', 'CADANGAN'])): ?>
                                                        <p class="timeline-description">Proses seleksi telah selesai</p>
                                                        <small class="timeline-date">Selesai</small>
                                                    <?php else: ?>
                                                        <p class="timeline-description">Menunggu proses seleksi dan penilaian</p>
                                                        <small class="timeline-date text-muted">Belum dimulai</small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <!-- Step 5: Pengumuman -->
                                            <div class="timeline-item <?php echo e(in_array($pendaftar->status, ['LULUS', 'TIDAK_LULUS', 'CADANGAN']) ? 'completed' : 'pending'); ?>">
                                                <div class="timeline-marker">
                                                    <i class="fas fa-graduation-cap"></i>
                                                </div>
                                                <div class="timeline-content">
                                                    <h6 class="timeline-title">Pengumuman Hasil</h6>
                                                    <?php if($pendaftar->status == 'LULUS'): ?>
                                                        <p class="timeline-description text-success"><strong>Selamat! Anda DITERIMA</strong></p>
                                                        <small class="timeline-date"><?php echo e($pendaftar->updated_at->format('d M Y, H:i')); ?></small>
                                                    <?php elseif($pendaftar->status == 'TIDAK_LULUS'): ?>
                                                        <p class="timeline-description text-danger">Mohon maaf, Anda belum berhasil kali ini</p>
                                                        <small class="timeline-date"><?php echo e($pendaftar->updated_at->format('d M Y, H:i')); ?></small>
                                                    <?php elseif($pendaftar->status == 'CADANGAN'): ?>
                                                        <p class="timeline-description text-warning">Anda masuk dalam daftar cadangan</p>
                                                        <small class="timeline-date"><?php echo e($pendaftar->updated_at->format('d M Y, H:i')); ?></small>
                                                    <?php else: ?>
                                                        <p class="timeline-description">Menunggu pengumuman hasil seleksi</p>
                                                        <small class="timeline-date text-muted">Belum diumumkan</small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card border-primary">
                                    <div class="card-header">
                                        <h5><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <a href="<?php echo e(route('siswa.biodata')); ?>" class="btn btn-info btn-block">
                                                    <i class="fas fa-id-card me-2"></i>Lihat Biodata
                                                </a>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <a href="<?php echo e(route('siswa.pembayaran')); ?>" class="btn btn-success btn-block">
                                                    <i class="fas fa-credit-card me-2"></i>Pembayaran
                                                </a>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <a href="<?php echo e(route('siswa.cetak-kartu')); ?>" class="btn btn-warning btn-block" target="_blank">
                                                    <i class="fas fa-print me-2"></i>Cetak Kartu
                                                </a>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <a href="<?php echo e(route('siswa.profil')); ?>" class="btn btn-secondary btn-block">
                                                    <i class="fas fa-user-circle me-2"></i>Profil
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <h5>Data Pendaftaran Tidak Ditemukan</h5>
                            <p>Silakan hubungi admin untuk informasi lebih lanjut.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-photo {
    border: 3px solid #6c757d;
    border-radius: 50%;
    padding: 10px;
    display: inline-block;
}

/* Timeline Styles */
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e0e0e0;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    padding-left: 80px;
}

.timeline-marker {
    position: absolute;
    left: 15px;
    top: 5px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    z-index: 1;
}

.timeline-item.completed .timeline-marker {
    background-color: #28a745;
    color: white;
    border: 3px solid #ffffff;
    box-shadow: 0 0 0 3px #28a745;
}

.timeline-item.current .timeline-marker {
    background-color: #ffc107;
    color: #333;
    border: 3px solid #ffffff;
    box-shadow: 0 0 0 3px #ffc107;
    animation: pulse 2s infinite;
}

.timeline-item.pending .timeline-marker {
    background-color: #e0e0e0;
    color: #666;
    border: 3px solid #ffffff;
}

.timeline-content {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-title {
    margin: 0 0 8px 0;
    font-weight: 600;
    color: #333;
}

.timeline-description {
    margin: 0 0 8px 0;
    color: #666;
    font-size: 14px;
}

.timeline-date {
    font-size: 12px;
    color: #999;
}

.timeline-item.completed .timeline-content {
    border-left: 4px solid #28a745;
}

.timeline-item.current .timeline-content {
    border-left: 4px solid #ffc107;
    background: #fffbf0;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 3px #ffc107;
    }
    50% {
        box-shadow: 0 0 0 6px rgba(255, 193, 7, 0.5);
    }
    100% {
        box-shadow: 0 0 0 3px #ffc107;
    }
}

@media (max-width: 768px) {
    .timeline-item {
        padding-left: 60px;
    }
    
    .timeline::before {
        left: 20px;
    }
    
    .timeline-marker {
        left: 5px;
        width: 25px;
        height: 25px;
        font-size: 12px;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('siswa.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/siswa/profil.blade.php ENDPATH**/ ?>