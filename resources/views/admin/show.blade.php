@extends('layouts.sidebar')

@section('title', 'Detail Pendaftar - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Detail Pendaftar</h1>
                    <p class="text-muted">{{ $pendaftar->no_pendaftaran }}</p>
                </div>
                <a href="{{ route('admin.pendaftar') }}" class="btn btn-secondary">
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

    <div class="row">
        <!-- Data Pribadi -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user"></i> Data Pribadi</h6>
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
                        <tr>
                            <td><strong>Nama Sekolah</strong></td>
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
                        @if($pendaftar->dataSiswa->lat && $pendaftar->dataSiswa->lng)
                        <tr>
                            <td><strong>Koordinat</strong></td>
                            <td>: {{ $pendaftar->dataSiswa->lat }}, {{ $pendaftar->dataSiswa->lng }}</td>
                        </tr>
                        @endif
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

        <!-- Data Pendaftaran -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-graduation-cap"></i> Data Pendaftaran</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%"><strong>No. Pendaftaran</strong></td>
                            <td>: {{ $pendaftar->no_pendaftaran }}</td>
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
                            <td><strong>Biaya Pendaftaran</strong></td>
                            <td>: Rp {{ number_format($pendaftar->gelombang->biaya_daftar ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: 
                                @if($pendaftar->status == 'SUBMIT')
                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                @elseif($pendaftar->status == 'LULUS')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($pendaftar->status == 'TIDAK_LULUS')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">{{ $pendaftar->status }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Daftar</strong></td>
                            <td>: {{ $pendaftar->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

            <!-- Persetujuan (Verifikator & Keuangan) -->
            <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-check-square"></i> Persetujuan</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2 align-items-center">
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
                </div>
            </div>

            <!-- Peta Lokasi -->
        @if($pendaftar->dataSiswa->lat && $pendaftar->dataSiswa->lng)
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-map-marked-alt"></i> Lokasi Pendaftar</h6>
                </div>
                <div class="card-body">
                    <div id="map" style="height: 400px; border-radius: 8px;"></div>
                </div>
            </div>
        </div>
        @endif

        <!-- Berkas Upload -->
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-file-alt"></i> Dokumen Pendaftar ({{ $pendaftar->berkas->count() }} berkas)</h6>
                </div>
                <div class="card-body">
                    @if($pendaftar->berkas->count() > 0)
                    <div class="row">
                        @foreach($pendaftar->berkas as $berkas)
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card border h-100">
                                <div class="card-body text-center">
                                    @php
                                        $extension = pathinfo($berkas->file_path, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                        $isPdf = strtolower($extension) == 'pdf';
                                    @endphp
                                    
                                    @if($isImage)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $berkas->file_path) }}" class="img-thumbnail" style="max-height: 120px;">
                                        </div>
                                    @elseif($isPdf)
                                        <div class="mb-2">
                                            <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                        </div>
                                    @else
                                        <div class="mb-2">
                                            <i class="fas fa-file fa-4x text-secondary"></i>
                                        </div>
                                    @endif
                                    
                                    <h6 class="card-title text-primary">{{ $berkas->jenis_berkas }}</h6>
                                    <p class="card-text small text-muted">{{ $berkas->nama_berkas }}</p>
                                    <p class="card-text small">
                                        <span class="badge bg-light text-dark">{{ number_format($berkas->ukuran_file / 1024, 0) }} KB</span>
                                    </p>
                                    
                                    <a href="{{ asset('storage/' . $berkas->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt"></i> Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
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

        <!-- Aksi Admin -->
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-cogs"></i> Aksi Admin</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Status pendaftar: <strong>{{ $pendaftar->status }}</strong>
                            </div>
                            
                            <!-- Tombol Status Akhir (Hanya untuk Admin) -->
                            @if(auth()->user()->role == 'admin' && in_array($pendaftar->status, ['SIAP_SELEKSI']))
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#statusAkhirModal">
                                <i class="fas fa-gavel"></i> Tentukan Status Akhir
                            </button>
                            @elseif(auth()->user()->role == 'admin' && in_array($pendaftar->status, ['LULUS', 'TIDAK_LULUS', 'CADANGAN']))
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#statusAkhirModal">
                                <i class="fas fa-edit"></i> Ubah Status Akhir
                            </button>
                            @endif
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.export', ['id' => $pendaftar->id]) }}" class="btn btn-outline-success">
                                <i class="fas fa-file-excel"></i> Export Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Status Akhir -->
<div class="modal fade" id="statusAkhirModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tentukan Status Akhir Pendaftar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.pendaftar.status-akhir', $pendaftar->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status Akhir</label>
                        <select name="status" class="form-select" required>
                            <option value="">Pilih Status</option>
                            <option value="LULUS">✅ LULUS / DITERIMA</option>
                            <option value="TIDAK_LULUS">❌ TIDAK LULUS / DITOLAK</option>
                            <option value="CADANGAN">⏳ CADANGAN</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan tambahan..."></textarea>
                    </div>
                    
                    <div class="alert alert-info">
                        <h6>📋 Alur Verifikasi PPDB:</h6>
                        <ol class="mb-2">
                            <li><strong>Verifikator:</strong> Cek berkas → MENUNGGU_PEMBAYARAN</li>
                            <li><strong>Keuangan:</strong> Verifikasi pembayaran → SIAP_SELEKSI</li>
                            <li><strong>Admin:</strong> Tentukan status akhir → LULUS/TIDAK_LULUS/CADANGAN</li>
                        </ol>
                        <hr>
                        <h6>🎯 Kriteria Status Akhir:</h6>
                        <ul class="mb-0">
                            <li><strong>LULUS:</strong> Semua tahap OK, kuota tersedia</li>
                            <li><strong>TIDAK LULUS:</strong> Ada masalah di tahap manapun</li>
                            <li><strong>CADANGAN:</strong> Kuota penuh tapi masih ada peluang</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($pendaftar->dataSiswa->lat && $pendaftar->dataSiswa->lng)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script>
    // Initialize map
    const lat = {{ $pendaftar->dataSiswa->lat }};
    const lng = {{ $pendaftar->dataSiswa->lng }};
    
    const map = L.map('map').setView([lat, lng], 15);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Add marker
    const marker = L.marker([lat, lng]).addTo(map);
    marker.bindPopup(`
        <b>{{ $pendaftar->dataSiswa->nama }}</b><br>
        {{ $pendaftar->no_pendaftaran }}<br>
        <small>{{ $pendaftar->dataSiswa->alamat }}</small>
    `).openPopup();
</script>
@endif
@endsection
