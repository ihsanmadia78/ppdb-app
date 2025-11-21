@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.pendaftar') }}">Pendaftar</a></li>
            <li class="breadcrumb-item active">Detail Pendaftar</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">📋 Detail Pendaftar</h1>
            <p class="text-muted mb-0">Informasi lengkap pendaftar PPDB</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pendaftar') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button class="btn btn-success btn-sm">
                <i class="fas fa-check"></i> Terima
            </button>
            <button class="btn btn-danger btn-sm">
                <i class="fas fa-times"></i> Tolak
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Informasi Utama -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pendaftar</h6>
                    <div class="dropdown no-arrow">
                        @php $st = $pendaftar->status; @endphp
                        @if($st == 'SUBMIT')
                            <span class="badge bg-warning text-dark fs-6">
                                <i class="fas fa-clock"></i> Menunggu Verifikasi
                            </span>
                        @elseif($st == 'DITERIMA' || $st == 'LULUS')
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check"></i> Diterima
                            </span>
                        @elseif($st == 'DITOLAK' || $st == 'TIDAK_LULUS')
                            <span class="badge bg-danger fs-6">
                                <i class="fas fa-times"></i> Ditolak
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">No. Pendaftaran</label>
                            <div class="fw-bold fs-5 text-primary">{{ $pendaftar->no_pendaftaran }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Tanggal Pendaftaran</label>
                            <div class="fw-bold">{{ $pendaftar->created_at->format('d F Y, H:i') }} WIB</div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Data Pribadi</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Nama Lengkap</label>
                            <div class="fw-bold">{{ $pendaftar->dataSiswa?->nama ?? '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">NISN</label>
                            <div class="fw-bold">{{ $pendaftar->dataSiswa?->nisn ?? '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Jenis Kelamin</label>
                            <div class="fw-bold">
                                @if($pendaftar->dataSiswa?->jk == 'L')
                                    <i class="fas fa-mars text-primary"></i> Laki-laki
                                @elseif($pendaftar->dataSiswa?->jk == 'P')
                                    <i class="fas fa-venus text-danger"></i> Perempuan
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Tempat, Tanggal Lahir</label>
                            <div class="fw-bold">
                                {{ $pendaftar->dataSiswa?->tmp_lahir ?? '-' }}, 
                                {{ $pendaftar->dataSiswa?->tgl_lahir ? \Carbon\Carbon::parse($pendaftar->dataSiswa->tgl_lahir)->format('d F Y') : '-' }}
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted">Alamat</label>
                            <div class="fw-bold">{{ $pendaftar->dataSiswa?->alamat ?? '-' }}</div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-primary mb-3"><i class="fas fa-graduation-cap me-2"></i>Pilihan Jurusan</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Jurusan Pilihan</label>
                            <div class="fw-bold">
                                <span class="badge bg-secondary fs-6">{{ $pendaftar->jurusan?->nama ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Gelombang</label>
                            <div class="fw-bold">{{ $pendaftar->gelombang?->nama ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Berkas Pendukung -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">📎 Berkas Pendukung</h6>
                </div>
                <div class="card-body">
                    @if($pendaftar->berkas && $pendaftar->berkas->count() > 0)
                        <div class="row">
                            @foreach($pendaftar->berkas as $berkas)
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-pdf fa-2x text-danger me-3"></i>
                                            <div>
                                                <div class="fw-bold">{{ $berkas->nama_berkas }}</div>
                                                <small class="text-muted">
                                                    {{ number_format($berkas->ukuran_file / 1024, 2) }} KB • 
                                                    {{ $berkas->created_at->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ Storage::url($berkas->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                            <a href="{{ Storage::url($berkas->file_path) }}" download class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                            <h6 class="text-gray-600">Belum Ada Berkas</h6>
                            <p class="text-muted">Pendaftar belum mengupload berkas pendukung.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Pendaftaran</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <h6 class="mb-2">Persetujuan</h6>
                        <div class="d-flex justify-content-center gap-2">
                            @isset($verifikatorAccepted)
                                @if($verifikatorAccepted)
                                    <span class="badge bg-success">Verifikator: Diterima</span>
                                @elseif($verifikatorRejected)
                                    <span class="badge bg-danger">Verifikator: Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">Verifikator: Menunggu</span>
                                @endif
                            @endisset

                            @isset($keuanganAccepted)
                                @if($keuanganAccepted)
                                    <span class="badge bg-success">Keuangan: Diterima</span>
                                @elseif($keuanganRejected)
                                    <span class="badge bg-danger">Keuangan: Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">Keuangan: Menunggu</span>
                                @endif
                            @endisset
                        </div>
                    </div>
                    @php $st = $pendaftar->status; @endphp
                    @if($st == 'SUBMIT')
                        <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                        <h5 class="text-warning">Menunggu Verifikasi</h5>
                        <p class="text-muted">Pendaftaran sedang dalam proses verifikasi oleh admin.</p>
                        @if($st == 'SUBMIT' || $st == 'VERIFIKASI_ADMIN')
                            <div class="d-grid gap-2">
                                <form action="{{ route('admin.pendaftar.terima', $pendaftar->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menerima pendaftar ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-check"></i> Terima Pendaftar
                                    </button>
                                </form>
                                <form action="{{ route('admin.pendaftar.tolak', $pendaftar->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak pendaftar ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-times"></i> Tolak Pendaftar
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="text-center">
                                <span class="badge bg-{{ App\Models\PendaftarStatus::getStatusColor($pendaftar->status) }} fs-6">
                                    {{ App\Models\PendaftarStatus::getStatusList()[$pendaftar->status] ?? $pendaftar->status }}
                                </span>
                                <p class="text-muted mt-2">Status sudah final</p>
                            </div>
                        @endif
                    @elseif($st == 'DITERIMA' || $st == 'LULUS')
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5 class="text-success">Diterima</h5>
                        <p class="text-muted">Pendaftar telah diterima dan dapat melanjutkan ke tahap berikutnya.</p>
                    @elseif($st == 'DITOLAK' || $st == 'TIDAK_LULUS')
                        <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                        <h5 class="text-danger">Ditolak</h5>
                        <p class="text-muted">Pendaftaran ditolak. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                    @endif
                </div>
            </div>

            <!-- Timeline Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Timeline Status</h6>
                </div>
                <div class="card-body">
                    @if($pendaftar->statusTimeline && $pendaftar->statusTimeline->count() > 0)
                        <div class="timeline">
                            @foreach($pendaftar->statusTimeline as $status)
                                <div class="timeline-item {{ $loop->last ? 'active' : 'completed' }}">
                                    <div class="timeline-marker bg-{{ App\Models\PendaftarStatus::getStatusColor($status->status) }}">
                                        <i class="{{ App\Models\PendaftarStatus::getStatusIcon($status->status) }} text-white" style="font-size: 8px;"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">{{ App\Models\PendaftarStatus::getStatusList()[$status->status] ?? $status->status }}</h6>
                                        <p class="text-muted mb-1">{{ $status->keterangan }}</p>
                                        <small class="text-muted">
                                            {{ $status->created_at->format('d F Y, H:i') }} WIB
                                            @if($status->updated_by) • oleh {{ $status->updated_by }}@endif
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Belum ada riwayat status.</p>
                    @endif
                </div>
            </div>

            <!-- Update Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.status.update', $pendaftar->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Baru</label>
                                <select name="status" class="form-select" required>
                                    <option value="">-- Pilih Status --</option>
                                    @foreach(App\Models\PendaftarStatus::getStatusList() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Keterangan (Opsional)</label>
                                <input type="text" name="keterangan" class="form-control" placeholder="Keterangan tambahan">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-print"></i> Cetak Data
                        </button>
                        <button class="btn btn-outline-info btn-sm">
                            <i class="fas fa-envelope"></i> Kirim Email
                        </button>
                        <button class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit Data
                        </button>
                    </div>
                </div>
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

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -22px;
    top: 20px;
    width: 2px;
    height: calc(100% + 10px);
    background-color: #e3e6f0;
}

.timeline-marker {
    position: absolute;
    left: -26px;
    top: 4px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e3e6f0;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-600 {
    color: #858796 !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}
</style>
@endsection