<?php $__env->startSection('title', 'Detail Pendaftar - Verifikator'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Detail Pendaftar</h1>
                    <p class="text-muted"><?php echo e($pendaftar->no_pendaftaran); ?></p>
                </div>
                <a href="<?php echo e(route('verifikator.pendaftar')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
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
    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Identitas Siswa -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user"></i> Identitas Siswa</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%"><strong>Nama Lengkap</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->nama ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>NIK</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->nik ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>NISN</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->nisn ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tempat, Tgl Lahir</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->tmp_lahir ?? '-'); ?>, <?php echo e($pendaftar->dataSiswa->tgl_lahir ? \Carbon\Carbon::parse($pendaftar->dataSiswa->tgl_lahir)->format('d/m/Y') : '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Agama</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->agama ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>: <?php echo e($pendaftar->email ?? '-'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-users"></i> Data Orang Tua</h6>
                </div>
                <div class="card-body">
                    <h6 class="text-primary mb-2"><i class="fas fa-male me-1"></i> Data Ayah</h6>
                    <table class="table table-borderless table-sm mb-3">
                        <tr>
                            <td width="40%"><strong>Nama Ayah</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->nama_ayah ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Pekerjaan</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->pekerjaan_ayah ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>No. HP</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->hp_ayah ?? '-'); ?></td>
                        </tr>
                    </table>
                    
                    <h6 class="text-success mb-2"><i class="fas fa-female me-1"></i> Data Ibu</h6>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%"><strong>Nama Ibu</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->nama_ibu ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Pekerjaan</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->pekerjaan_ibu ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>No. HP</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->hp_ibu ?? '-'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Data Alamat -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-map-marker-alt"></i> Data Alamat</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%"><strong>Alamat Lengkap</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->alamat ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Kelurahan/Desa</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->kelurahan ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Kecamatan</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->kecamatan ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Kabupaten/Kota</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->kabupaten ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Provinsi</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->provinsi ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Kode Pos</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->kode_pos ?? '-'); ?></td>
                        </tr>
                        <?php if($pendaftar->dataSiswa->latitude && $pendaftar->dataSiswa->longitude): ?>
                        <tr>
                            <td><strong>Koordinat</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->latitude); ?>, <?php echo e($pendaftar->dataSiswa->longitude); ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Data Sekolah Asal -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-school"></i> Data Sekolah & Pendaftaran</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%"><strong>Nama Sekolah</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->nama_sekolah_asal ?? '-'); ?></td>
                        </tr>
                        <?php if($pendaftar->dataSiswa->npsn_sekolah): ?>
                        <tr>
                            <td><strong>NPSN Sekolah</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->npsn_sekolah); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td><strong>Kabupaten Sekolah</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->kabupaten_sekolah ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Nilai Rata-rata</strong></td>
                            <td>: <?php echo e($pendaftar->dataSiswa->nilai_rata_rata ? number_format($pendaftar->dataSiswa->nilai_rata_rata, 2) : '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Jurusan Pilihan</strong></td>
                            <td>: <?php echo e($pendaftar->jurusan->nama ?? '-'); ?> (<?php echo e($pendaftar->jurusan->kode ?? '-'); ?>)</td>
                        </tr>
                        <tr>
                            <td><strong>Gelombang</strong></td>
                            <td>: <?php echo e($pendaftar->gelombang->nama ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Daftar</strong></td>
                            <td>: <?php echo e($pendaftar->created_at->format('d/m/Y H:i')); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Status & Verifikasi -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-clipboard-check"></i> Status & Verifikasi</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status Saat Ini:</strong><br>
                        <?php if($pendaftar->status == 'SUBMIT'): ?>
                            <span class="badge bg-warning text-dark fs-6 mt-1">
                                <i class="fas fa-clock"></i> Belum Diverifikasi
                            </span>
                        <?php elseif($pendaftar->status == 'BERKAS_DITOLAK'): ?>
                            <span class="badge bg-info text-dark fs-6 mt-1">
                                <i class="fas fa-exclamation-triangle"></i> Perlu Perbaikan
                            </span>
                        <?php elseif($pendaftar->status == 'MENUNGGU_PEMBAYARAN'): ?>
                            <span class="badge bg-success fs-6 mt-1">
                                <i class="fas fa-check"></i> Lulus Administrasi
                            </span>
                        <?php elseif($pendaftar->status == 'TIDAK_LULUS'): ?>
                            <span class="badge bg-danger fs-6 mt-1">
                                <i class="fas fa-times"></i> Ditolak
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if($pendaftar->status == 'SUBMIT' || $pendaftar->status == 'BERKAS_DITOLAK'): ?>
                    <div class="border rounded p-3 bg-light">
                        <h6 class="text-primary mb-3"><i class="fas fa-clipboard-check"></i> Verifikasi Administrasi</h6>
                        <form method="POST" action="<?php echo e(route('verifikator.verifikasi', $pendaftar->id)); ?>" onsubmit="console.log('Form submitted')">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="debug" value="1">
                            <div class="mb-3">
                                <label class="form-label"><strong>Hasil Verifikasi:</strong></label>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="MENUNGGU_PEMBAYARAN" id="lulus" required>
                                            <label class="form-check-label text-success" for="lulus">
                                                <i class="fas fa-check-circle"></i> <strong>Lulus Administrasi</strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="BERKAS_DITOLAK" id="perbaikan" required>
                                            <label class="form-check-label text-warning" for="perbaikan">
                                                <i class="fas fa-tools"></i> <strong>Perbaikan Berkas</strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="TIDAK_LULUS" id="ditolak" required>
                                            <label class="form-check-label text-danger" for="ditolak">
                                                <i class="fas fa-times-circle"></i> <strong>Ditolak Administrasi</strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3" id="catatanSection" style="display: none;">
                                <label class="form-label"><strong>Catatan untuk Siswa:</strong></label>
                                <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Foto KK buram, mohon upload ulang dengan kualitas yang lebih jelas."></textarea>
                                <small class="text-muted">Berikan penjelasan yang jelas agar siswa dapat memperbaiki berkas dengan tepat.</small>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg" onclick="console.log('Button clicked')">
                                    <i class="fas fa-save"></i> Simpan Hasil Verifikasi
                                </button>
                            </div>

                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Berkas Upload -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-file-alt"></i> Dokumen Pendaftar (<?php echo e($pendaftar->berkas->count()); ?> berkas)</h6>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleView('grid')" id="gridBtn">
                            <i class="fas fa-th"></i> Grid
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="toggleView('list')" id="listBtn">
                            <i class="fas fa-list"></i> List
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if($pendaftar->berkas->count() > 0): ?>
                    
                    <!-- Grid View -->
                    <div id="gridView" class="row" style="display: none;">
                        <?php $__currentLoopData = $pendaftar->berkas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berkas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card border h-100">
                                <div class="card-body text-center">
                                    <?php
                                        $extension = pathinfo($berkas->file_path, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                        $isPdf = strtolower($extension) == 'pdf';
                                    ?>
                                    
                                    <?php if($isImage): ?>
                                        <div class="mb-2 position-relative">
                                            <img src="<?php echo e(asset('storage/' . $berkas->file_path)); ?>" class="img-thumbnail" style="max-height: 120px; cursor: pointer;" onclick="previewImage('<?php echo e(asset('storage/' . $berkas->file_path)); ?>', '<?php echo e($berkas->jenis_berkas); ?>')">
                                            <span class="position-absolute top-0 end-0 badge bg-info">IMG</span>
                                        </div>
                                    <?php elseif($isPdf): ?>
                                        <div class="mb-2">
                                            <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                            <span class="badge bg-danger">PDF</span>
                                        </div>
                                    <?php else: ?>
                                        <div class="mb-2">
                                            <i class="fas fa-file fa-4x text-secondary"></i>
                                            <span class="badge bg-secondary"><?php echo e(strtoupper($extension)); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <h6 class="card-title text-primary"><?php echo e($berkas->jenis_berkas); ?></h6>
                                    <p class="card-text small text-muted mb-1"><?php echo e($berkas->nama_berkas); ?></p>
                                    <p class="card-text small mb-2">
                                        <span class="badge bg-light text-dark"><?php echo e(number_format($berkas->ukuran_file / 1024, 0)); ?> KB</span>
                                        <span class="badge bg-info"><?php echo e(strtoupper($extension)); ?></span>
                                    </p>
                                    
                                    <div class="btn-group w-100" role="group">
                                        <?php if($isImage): ?>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="previewImage('<?php echo e(asset('storage/' . $berkas->file_path)); ?>', '<?php echo e($berkas->jenis_berkas); ?>')">
                                            <i class="fas fa-eye"></i> Preview
                                        </button>
                                        <?php elseif($isPdf): ?>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="previewPdf('<?php echo e(asset('storage/' . $berkas->file_path)); ?>', '<?php echo e($berkas->jenis_berkas); ?>')">
                                            <i class="fas fa-eye"></i> Lihat PDF
                                        </button>
                                        <?php endif; ?>
                                        <a href="<?php echo e(asset('storage/' . $berkas->file_path)); ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-external-link-alt"></i> Buka
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <!-- List View -->
                    <div id="listView" class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Jenis Berkas</th>
                                    <th width="25%">Nama File</th>
                                    <th width="10%">Ukuran</th>
                                    <th width="10%">Format</th>
                                    <th width="15%">Tanggal Upload</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $pendaftar->berkas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $berkas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $extension = pathinfo($berkas->file_path, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                    $isPdf = strtolower($extension) == 'pdf';
                                ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($isImage): ?>
                                                <i class="fas fa-image text-info me-2"></i>
                                            <?php elseif($isPdf): ?>
                                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                            <?php else: ?>
                                                <i class="fas fa-file text-secondary me-2"></i>
                                            <?php endif; ?>
                                            <strong><?php echo e($berkas->jenis_berkas); ?></strong>
                                        </div>
                                    </td>
                                    <td class="text-muted"><?php echo e($berkas->nama_berkas); ?></td>
                                    <td><span class="badge bg-light text-dark"><?php echo e(number_format($berkas->ukuran_file / 1024, 0)); ?> KB</span></td>
                                    <td><span class="badge bg-info"><?php echo e(strtoupper($extension)); ?></span></td>
                                    <td class="text-muted small"><?php echo e($berkas->created_at->format('d/m/Y H:i')); ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <?php if($isImage): ?>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="previewImage('<?php echo e(asset('storage/' . $berkas->file_path)); ?>', '<?php echo e($berkas->jenis_berkas); ?>')" title="Preview Gambar">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <?php elseif($isPdf): ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="previewPdf('<?php echo e(asset('storage/' . $berkas->file_path)); ?>', '<?php echo e($berkas->jenis_berkas); ?>')" title="Lihat PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </button>
                                            <?php endif; ?>
                                            <a href="<?php echo e(asset('storage/' . $berkas->file_path)); ?>" target="_blank" class="btn btn-sm btn-outline-success" title="Buka di Tab Baru">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                            <a href="<?php echo e(asset('storage/' . $berkas->file_path)); ?>" download class="btn btn-sm btn-outline-info" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-file-upload fa-4x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-600">Belum Ada Dokumen</h5>
                        <p class="text-muted">Siswa belum mengupload dokumen apapun.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Status -->
    <?php if($pendaftar->statusTimeline->count() > 0): ?>
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-history"></i> Riwayat Status</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <?php $__currentLoopData = $pendaftar->statusTimeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timeline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title"><?php echo e($timeline->status); ?></h6>
                                <p class="timeline-text"><?php echo e($timeline->keterangan); ?></p>
                                <small class="text-muted">
                                    <?php echo e($timeline->created_at->format('d/m/Y H:i')); ?>

                                    <?php if($timeline->createdBy): ?>
                                        - oleh <?php echo e($timeline->createdBy->name); ?>

                                    <?php endif; ?>
                                </small>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal Preview Image -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewTitle">Preview Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" class="img-fluid" alt="Preview" style="max-height: 70vh;">
            </div>
            <div class="modal-footer">
                <a id="downloadLink" href="" download class="btn btn-success">
                    <i class="fas fa-download"></i> Download
                </a>
                <a id="openLink" href="" target="_blank" class="btn btn-primary">
                    <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview PDF -->
<div class="modal fade" id="pdfModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfTitle">Preview PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="pdfFrame" src="" width="100%" height="600px" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
                <a id="pdfDownloadLink" href="" download class="btn btn-success">
                    <i class="fas fa-download"></i> Download PDF
                </a>
                <a id="pdfOpenLink" href="" target="_blank" class="btn btn-primary">
                    <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #007bff;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px #007bff;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -30px;
    top: 17px;
    width: 2px;
    height: calc(100% + 10px);
    background-color: #dee2e6;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.timeline-title {
    margin-bottom: 5px;
    color: #495057;
    font-weight: 600;
}

.timeline-text {
    margin-bottom: 5px;
    color: #6c757d;
}

.fs-6 {
    font-size: 1rem !important;
}

.card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.btn-group .btn {
    border-radius: 0.25rem !important;
    margin-right: 2px;
}

.position-relative .badge {
    font-size: 0.6em;
}
</style>

<script>
function previewImage(src, title) {
    document.getElementById('previewImage').src = src;
    document.getElementById('previewTitle').textContent = 'Preview: ' + title;
    document.getElementById('downloadLink').href = src;
    document.getElementById('openLink').href = src;
    new bootstrap.Modal(document.getElementById('previewModal')).show();
}

function previewPdf(src, title) {
    document.getElementById('pdfFrame').src = src;
    document.getElementById('pdfTitle').textContent = 'Preview: ' + title;
    document.getElementById('pdfDownloadLink').href = src;
    document.getElementById('pdfOpenLink').href = src;
    new bootstrap.Modal(document.getElementById('pdfModal')).show();
}

function toggleView(viewType) {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const gridBtn = document.getElementById('gridBtn');
    const listBtn = document.getElementById('listBtn');
    
    if (viewType === 'grid') {
        gridView.style.display = 'flex';
        listView.style.display = 'none';
        gridBtn.classList.add('btn-primary');
        gridBtn.classList.remove('btn-outline-primary');
        listBtn.classList.add('btn-outline-primary');
        listBtn.classList.remove('btn-primary');
    } else {
        gridView.style.display = 'none';
        listView.style.display = 'block';
        listBtn.classList.add('btn-primary');
        listBtn.classList.remove('btn-outline-primary');
        gridBtn.classList.add('btn-outline-primary');
        gridBtn.classList.remove('btn-primary');
    }
}

// Set default view to list
document.addEventListener('DOMContentLoaded', function() {
    toggleView('list');
});

// Show/hide catatan section based on verification result
document.addEventListener('DOMContentLoaded', function() {
    const radioButtons = document.querySelectorAll('input[name="status"]');
    const catatanSection = document.getElementById('catatanSection');
    const catatanTextarea = document.querySelector('textarea[name="catatan"]');
    
    radioButtons.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.value === 'BERKAS_DITOLAK' || this.value === 'TIDAK_LULUS') {
                catatanSection.style.display = 'block';
                catatanTextarea.required = true;
                
                // Set placeholder based on selection
                if (this.value === 'BERKAS_DITOLAK') {
                    catatanTextarea.placeholder = 'Contoh: Foto KK buram, mohon upload ulang dengan kualitas yang lebih jelas.';
                } else {
                    catatanTextarea.placeholder = 'Contoh: Berkas tidak sesuai persyaratan, NISN tidak valid.';
                }
            } else {
                catatanSection.style.display = 'none';
                catatanTextarea.required = false;
                catatanTextarea.value = '';
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/verifikator/detail.blade.php ENDPATH**/ ?>