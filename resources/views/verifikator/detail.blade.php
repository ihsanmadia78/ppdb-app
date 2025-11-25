@extends('layouts.sidebar')

@section('title', 'Detail Pendaftar - Verifikator')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Detail Pendaftar</h1>
                    <p class="text-muted">{{ $pendaftar->no_pendaftaran }}</p>
                </div>
                <a href="{{ route('verifikator.pendaftar') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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
                            <td>: {{ $pendaftar->dataSiswa->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>NIK</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->nik ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>NISN</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->nisn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tempat, Tgl Lahir</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->tmp_lahir ?? '-' }}, {{ $pendaftar->dataSiswa->tgl_lahir ? \Carbon\Carbon::parse($pendaftar->dataSiswa->tgl_lahir)->format('d/m/Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Agama</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->agama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>: {{ $pendaftar->email ?? '-' }}</td>
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
                            <td>: {{ $pendaftar->dataSiswa->nama_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Pekerjaan</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->pekerjaan_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. HP</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->hp_ayah ?? '-' }}</td>
                        </tr>
                    </table>
                    
                    <h6 class="text-success mb-2"><i class="fas fa-female me-1"></i> Data Ibu</h6>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%"><strong>Nama Ibu</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->nama_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Pekerjaan</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->pekerjaan_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. HP</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->hp_ibu ?? '-' }}</td>
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
                            <td>: {{ $pendaftar->dataSiswa->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kelurahan/Desa</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->kelurahan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kecamatan</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->kecamatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kabupaten/Kota</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->kabupaten ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Provinsi</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->provinsi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kode Pos</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->kode_pos ?? '-' }}</td>
                        </tr>
                        @if($pendaftar->dataSiswa->latitude && $pendaftar->dataSiswa->longitude)
                        <tr>
                            <td><strong>Koordinat</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->latitude }}, {{ $pendaftar->dataSiswa->longitude }}</td>
                        </tr>
                        @endif
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
                            <td>: {{ $pendaftar->dataSiswa->nama_sekolah_asal ?? '-' }}</td>
                        </tr>
                        @if($pendaftar->dataSiswa->npsn_sekolah)
                        <tr>
                            <td><strong>NPSN Sekolah</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->npsn_sekolah }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Kabupaten Sekolah</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->kabupaten_sekolah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nilai Rata-rata</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->nilai_rata_rata ? number_format($pendaftar->dataSiswa->nilai_rata_rata, 2) : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jurusan Pilihan</strong></td>
                            <td>: {{ $pendaftar->jurusan->nama ?? '-' }} ({{ $pendaftar->jurusan->kode ?? '-' }})</td>
                        </tr>
                        <tr>
                            <td><strong>Gelombang</strong></td>
                            <td>: {{ $pendaftar->gelombang->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Daftar</strong></td>
                            <td>: {{ $pendaftar->created_at->format('d/m/Y H:i') }}</td>
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
                        @if($pendaftar->status == 'SUBMIT')
                            <span class="badge bg-warning text-dark fs-6 mt-1">
                                <i class="fas fa-clock"></i> Belum Diverifikasi
                            </span>
                        @elseif($pendaftar->status == 'BERKAS_DITOLAK')
                            <span class="badge bg-info text-dark fs-6 mt-1">
                                <i class="fas fa-exclamation-triangle"></i> Perlu Perbaikan
                            </span>
                        @elseif($pendaftar->status == 'MENUNGGU_PEMBAYARAN')
                            <span class="badge bg-success fs-6 mt-1">
                                <i class="fas fa-check"></i> Lulus Administrasi
                            </span>
                        @elseif($pendaftar->status == 'TIDAK_LULUS')
                            <span class="badge bg-danger fs-6 mt-1">
                                <i class="fas fa-times"></i> Ditolak
                            </span>
                        @endif
                    </div>

                    @if($pendaftar->status == 'SUBMIT' || $pendaftar->status == 'BERKAS_DITOLAK')
                    <div class="border rounded p-3 bg-light">
                        <h6 class="text-primary mb-3"><i class="fas fa-clipboard-check"></i> Verifikasi Administrasi</h6>
                        <form method="POST" action="{{ route('verifikator.verifikasi', $pendaftar->id) }}" onsubmit="console.log('Form submitted')">
                            @csrf
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
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Berkas Upload -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-file-alt"></i> Dokumen Pendaftar ({{ $pendaftar->berkas->count() }} berkas)</h6>
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
                    @if($pendaftar->berkas->count() > 0)
                    
                    <!-- Grid View -->
                    <div id="gridView" class="row" style="display: none;">
                        @foreach($pendaftar->berkas as $berkas)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card border h-100">
                                <div class="card-body text-center">
                                    @php
                                        $extension = pathinfo($berkas->file_path, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                        $isPdf = strtolower($extension) == 'pdf';
                                    @endphp
                                    
                                    @if($isImage)
                                        <div class="mb-2 position-relative">
                                            <img src="{{ asset('storage/' . $berkas->file_path) }}" class="img-thumbnail" style="max-height: 120px; cursor: pointer;" onclick="previewImage('{{ asset('storage/' . $berkas->file_path) }}', '{{ $berkas->jenis_berkas }}')">
                                            <span class="position-absolute top-0 end-0 badge bg-info">IMG</span>
                                        </div>
                                    @elseif($isPdf)
                                        <div class="mb-2">
                                            <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                            <span class="badge bg-danger">PDF</span>
                                        </div>
                                    @else
                                        <div class="mb-2">
                                            <i class="fas fa-file fa-4x text-secondary"></i>
                                            <span class="badge bg-secondary">{{ strtoupper($extension) }}</span>
                                        </div>
                                    @endif
                                    
                                    <h6 class="card-title text-primary">{{ $berkas->jenis_berkas }}</h6>
                                    <p class="card-text small text-muted mb-1">{{ $berkas->nama_berkas }}</p>
                                    <p class="card-text small mb-2">
                                        <span class="badge bg-light text-dark">{{ number_format($berkas->ukuran_file / 1024, 0) }} KB</span>
                                        <span class="badge bg-info">{{ strtoupper($extension) }}</span>
                                    </p>
                                    
                                    <div class="btn-group w-100" role="group">
                                        @if($isImage)
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="previewImage('{{ asset('storage/' . $berkas->file_path) }}', '{{ $berkas->jenis_berkas }}')">
                                            <i class="fas fa-eye"></i> Preview
                                        </button>
                                        @elseif($isPdf)
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="previewPdf('{{ asset('storage/' . $berkas->file_path) }}', '{{ $berkas->jenis_berkas }}')">
                                            <i class="fas fa-eye"></i> Lihat PDF
                                        </button>
                                        @endif
                                        <a href="{{ asset('storage/' . $berkas->file_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-external-link-alt"></i> Buka
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
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
                                @foreach($pendaftar->berkas as $index => $berkas)
                                @php
                                    $extension = pathinfo($berkas->file_path, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                    $isPdf = strtolower($extension) == 'pdf';
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($isImage)
                                                <i class="fas fa-image text-info me-2"></i>
                                            @elseif($isPdf)
                                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                            @else
                                                <i class="fas fa-file text-secondary me-2"></i>
                                            @endif
                                            <strong>{{ $berkas->jenis_berkas }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $berkas->nama_berkas }}</td>
                                    <td><span class="badge bg-light text-dark">{{ number_format($berkas->ukuran_file / 1024, 0) }} KB</span></td>
                                    <td><span class="badge bg-info">{{ strtoupper($extension) }}</span></td>
                                    <td class="text-muted small">{{ $berkas->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($isImage)
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="previewImage('{{ asset('storage/' . $berkas->file_path) }}', '{{ $berkas->jenis_berkas }}')" title="Preview Gambar">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @elseif($isPdf)
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="previewPdf('{{ asset('storage/' . $berkas->file_path) }}', '{{ $berkas->jenis_berkas }}')" title="Lihat PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </button>
                                            @endif
                                            <a href="{{ asset('storage/' . $berkas->file_path) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Buka di Tab Baru">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                            <a href="{{ asset('storage/' . $berkas->file_path) }}" download class="btn btn-sm btn-outline-info" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-file-upload fa-4x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-600">Belum Ada Dokumen</h5>
                        <p class="text-muted">Siswa belum mengupload dokumen apapun.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Status -->
    @if($pendaftar->statusTimeline->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-history"></i> Riwayat Status</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($pendaftar->statusTimeline as $timeline)
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">{{ $timeline->status }}</h6>
                                <p class="timeline-text">{{ $timeline->keterangan }}</p>
                                <small class="text-muted">
                                    {{ $timeline->created_at->format('d/m/Y H:i') }}
                                    @if($timeline->createdBy)
                                        - oleh {{ $timeline->createdBy->name }}
                                    @endif
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
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
@endsection
