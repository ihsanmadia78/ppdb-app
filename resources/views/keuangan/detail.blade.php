@extends('layouts.sidebar')

@section('title', 'Detail Pembayaran - Keuangan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Detail Pembayaran</h1>
                    <p class="text-muted">{{ $pembayaran->pendaftar->no_pendaftaran }}</p>
                </div>
                <a href="{{ route('keuangan.pembayaran') }}" class="btn btn-secondary">
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
        <!-- Data Siswa -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user"></i> Data Siswa</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%"><strong>Nama Lengkap</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>NIK</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->nik ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>NISN</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->nisn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tempat, Tgl Lahir</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->tmp_lahir ?? '-' }}, {{ $pembayaran->pendaftar->dataSiswa->tgl_lahir ? \Carbon\Carbon::parse($pembayaran->pendaftar->dataSiswa->tgl_lahir)->format('d/m/Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>: {{ $pembayaran->pendaftar->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jurusan</strong></td>
                            <td>: {{ $pembayaran->pendaftar->jurusan->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Gelombang</strong></td>
                            <td>: {{ $pembayaran->pendaftar->gelombang->nama ?? '-' }}</td>
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
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kelurahan/Desa</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->kelurahan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kecamatan</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->kecamatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kabupaten/Kota</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->kabupaten ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Provinsi</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->provinsi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kode Pos</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->kode_pos ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Data Sekolah Asal -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-school"></i> Data Sekolah Asal</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%"><strong>Nama Sekolah</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->nama_sekolah_asal ?? '-' }}</td>
                        </tr>
                        @if($pembayaran->pendaftar->dataSiswa->npsn_sekolah)
                        <tr>
                            <td><strong>NPSN Sekolah</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->npsn_sekolah }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Kabupaten Sekolah</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->kabupaten_sekolah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nilai Rata-rata</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->nilai_rata_rata ? number_format($pembayaran->pendaftar->dataSiswa->nilai_rata_rata, 2) : '-' }}</td>
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
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->nama_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Pekerjaan</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->pekerjaan_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. HP</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->hp_ayah ?? '-' }}</td>
                        </tr>
                    </table>
                    
                    <h6 class="text-success mb-2"><i class="fas fa-female me-1"></i> Data Ibu</h6>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%"><strong>Nama Ibu</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->nama_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Pekerjaan</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->pekerjaan_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>No. HP</strong></td>
                            <td>: {{ $pembayaran->pendaftar->dataSiswa->hp_ibu ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Data Pembayaran -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-credit-card"></i> Data Pembayaran</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%"><strong>Nominal</strong></td>
                            <td>: <span class="fw-bold text-success">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Metode Pembayaran</strong></td>
                            <td>: {{ ucfirst($pembayaran->metode_pembayaran ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Bayar</strong></td>
                            <td>: {{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: 
                                @if($pembayaran->status == 'pending')
                                    <span class="badge bg-secondary">Pending</span>
                                @elseif($pembayaran->status == 'paid')
                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                @elseif($pembayaran->status == 'verified')
                                    <span class="badge bg-success">Terverifikasi</span>
                                @elseif($pembayaran->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @if($pembayaran->catatan)
                        <tr>
                            <td><strong>Catatan</strong></td>
                            <td>: {{ $pembayaran->catatan }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Diverifikasi Oleh</strong></td>
                            <td>: {{ $pembayaran->verifiedBy->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bukti Pembayaran -->
        @if($pembayaran->bukti_pembayaran)
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-file-image"></i> Bukti Pembayaran</h6>
                </div>
                <div class="card-body text-center">
                    @php
                        $extension = pathinfo($pembayaran->bukti_pembayaran, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                    @endphp
                    
                    @if($isImage)
                        <img src="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" class="img-fluid" style="max-height: 500px;" alt="Bukti Pembayaran">
                    @else
                        <div class="py-5">
                            <i class="fas fa-file fa-4x text-gray-300 mb-3"></i>
                            <h5>File Bukti Pembayaran</h5>
                            <p class="text-muted">{{ $pembayaran->bukti_pembayaran }}</p>
                        </div>
                    @endif
                    
                    <div class="mt-3">
                        <a href="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" target="_blank" class="btn btn-primary">
                            <i class="fas fa-external-link-alt"></i> Buka File
                        </a>
                        <a href="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" download class="btn btn-outline-secondary">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Aksi Verifikasi -->
        @if($pembayaran->status == 'paid')
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-check-circle"></i> Verifikasi Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('keuangan.verifikasi', $pembayaran->id) }}" method="POST" class="d-inline me-2">
                                @csrf
                                <input type="hidden" name="status" value="verified">
                                <button type="submit" class="btn btn-success" onclick="return confirm('Yakin ingin menerima pembayaran ini?')">
                                    <i class="fas fa-check"></i> Terima Pembayaran
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('keuangan.verifikasi', $pembayaran->id) }}" method="POST" class="d-inline" onsubmit="return tolakPembayaran(this)">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <input type="hidden" name="catatan" id="catatanTolak">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-times"></i> Tolak Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function tolakPembayaran(form) {
    const catatan = prompt('Masukkan alasan penolakan:');
    if (!catatan) {
        return false;
    }
    
    document.getElementById('catatanTolak').value = catatan;
    return confirm('Yakin ingin menolak pembayaran ini?');
}
</script>
@endsection
