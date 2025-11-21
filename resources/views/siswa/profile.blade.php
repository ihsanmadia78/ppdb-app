@extends('layouts.siswa')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">👤 Profil Saya</h1>
            <p class="text-muted mb-0">Data pribadi dan informasi pendaftaran</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">📝 Data Pribadi</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($siswa->dataSiswa)
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{ $siswa->dataSiswa->nama ?? 'Belum diisi' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NISN</label>
                            <input type="text" class="form-control" value="{{ $siswa->dataSiswa->nisn ?? 'Belum diisi' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" value="{{ $siswa->dataSiswa->tmp_lahir ?? 'Belum diisi' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="text" class="form-control" value="{{ $siswa->dataSiswa->tgl_lahir ? \Carbon\Carbon::parse($siswa->dataSiswa->tgl_lahir)->format('d F Y') : 'Belum diisi' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" value="{{ $siswa->dataSiswa->jk == 'L' ? 'Laki-laki' : ($siswa->dataSiswa->jk == 'P' ? 'Perempuan' : 'Belum diisi') }}" readonly>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" rows="3" readonly>{{ $siswa->dataSiswa->alamat ?? 'Belum diisi' }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" value="{{ $siswa->email ?? 'Belum diisi' }}" readonly>
                        </div>
                        @if($siswa->dataSiswa->asal_sekolah)
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Asal Sekolah</label>
                            <input type="text" class="form-control" value="{{ $siswa->dataSiswa->asal_sekolah }}" readonly>
                        </div>
                        @endif
                        @else
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                                <h5>Data Pribadi Belum Lengkap</h5>
                                <p>Data pribadi Anda belum diisi atau belum lengkap. Silakan lengkapi data pendaftaran Anda.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($siswa->dataSiswa)
            <!-- Data Orang Tua -->
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">👨‍👩‍👧‍👦 Data Orang Tua</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" class="form-control" value="{{ $siswa->dataSiswa->nama_ayah ?? 'Belum diisi' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" class="form-control" value="{{ $siswa->dataSiswa->nama_ibu ?? 'Belum diisi' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pekerjaan Orang Tua</label>
                            <input type="text" class="form-control" value="{{ $siswa->dataSiswa->pekerjaan_ortu ?? 'Belum diisi' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. HP Orang Tua</label>
                            <input type="text" class="form-control" value="{{ $siswa->dataSiswa->telp_ortu ?? 'Belum diisi' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">📋 Info Pendaftaran</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>No. Pendaftaran:</strong><br>
                        <div class="d-flex align-items-center mt-1">
                            <span class="badge bg-info me-2" id="noPendaftaranSiswa">{{ $siswa->no_pendaftaran }}</span>
                            <button class="btn btn-sm btn-outline-primary" onclick="copyNoPendaftaranSiswa()" title="Salin">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    <p><strong>Jurusan:</strong><br>
                        <span class="badge bg-secondary">{{ $siswa->jurusan->nama ?? 'Belum dipilih' }}</span>
                    </p>
                    <p><strong>Gelombang:</strong><br>{{ $siswa->gelombang->nama ?? 'Belum ditentukan' }}</p>
                    <p><strong>Status:</strong><br>
                        @php
                            $statusColor = \App\Models\PendaftarStatus::getStatusColor($siswa->status);
                        @endphp
                        <span class="badge bg-{{ $statusColor }}">{{ \App\Models\PendaftarStatus::getStatusList()[$siswa->status] ?? $siswa->status }}</span>
                    </p>
                    <p><strong>Tanggal Daftar:</strong><br>{{ $siswa->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">📄 Berkas</h6>
                </div>
                <div class="card-body">
                    @if($siswa->berkas->count() > 0)
                        @foreach($siswa->berkas as $berkas)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-sm">{{ $berkas->jenis_berkas }}</span>
                                @if($berkas->file_path)
                                    <a href="{{ asset('storage/' . $berkas->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">Belum ada berkas</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyNoPendaftaranSiswa() {
    const noPendaftaran = '{{ $siswa->no_pendaftaran }}';
    
    navigator.clipboard.writeText(noPendaftaran).then(function() {
        showCopySuccess();
    }).catch(function(err) {
        const textArea = document.createElement('textarea');
        textArea.value = noPendaftaran;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showCopySuccess();
    });
}

function showCopySuccess() {
    const alert = document.createElement('div');
    alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
    alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alert.innerHTML = `
        <i class="fas fa-check-circle me-2"></i>
        <strong>Berhasil!</strong> Nomor pendaftaran telah disalin.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alert);
    
    setTimeout(() => {
        if (alert.parentNode) {
            alert.parentNode.removeChild(alert);
        }
    }, 3000);
}
</script>
@endsection