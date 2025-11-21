@extends('siswa.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-id-card me-2"></i>Biodata Lengkap Calon Siswa</h4>
                </div>
                <div class="card-body">
                    @if($pendaftar)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-header">
                                        <h5>Data Pendaftaran</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>No. Pendaftaran</strong></td>
                                                <td>: {{ $pendaftar->no_pendaftaran }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email</strong></td>
                                                <td>: {{ $pendaftar->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jurusan Pilihan</strong></td>
                                                <td>: {{ $pendaftar->jurusan->nama ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Gelombang</strong></td>
                                                <td>: {{ $pendaftar->gelombang->nama ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status</strong></td>
                                                <td>: <span class="badge bg-{{ $pendaftar->status == 'LULUS' ? 'success' : ($pendaftar->status == 'TIDAK_LULUS' ? 'danger' : 'warning') }}">
                                                    {{ $pendaftar->status }}
                                                </span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                @if($pendaftar->dataSiswa)
                                <div class="card border-info">
                                    <div class="card-header">
                                        <h5>Data Pribadi</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Nama Lengkap</strong></td>
                                                <td>: {{ $pendaftar->dataSiswa->nama ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>NISN</strong></td>
                                                <td>: {{ $pendaftar->dataSiswa->nisn ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tempat, Tgl Lahir</strong></td>
                                                <td>: {{ $pendaftar->dataSiswa->tmp_lahir ?? '-' }}, {{ $pendaftar->dataSiswa->tgl_lahir ? \Carbon\Carbon::parse($pendaftar->dataSiswa->tgl_lahir)->format('d/m/Y') : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jenis Kelamin</strong></td>
                                                <td>: {{ $pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : ($pendaftar->dataSiswa->jk == 'P' ? 'Perempuan' : '-') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>NIK</strong></td>
                                                <td>: {{ $pendaftar->dataSiswa->nik ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($pendaftar->dataSiswa)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card border-success">
                                    <div class="card-header">
                                        <h5>Alamat & Kontak</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td><strong>Alamat</strong></td>
                                                        <td>: {{ $pendaftar->dataSiswa->alamat ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Asal Sekolah</strong></td>
                                                        <td>: {{ $pendaftar->dataSiswa->nama_sekolah_asal ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td><strong>Nama Ayah</strong></td>
                                                        <td>: {{ $pendaftar->dataSiswa->nama_ayah ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Nama Ibu</strong></td>
                                                        <td>: {{ $pendaftar->dataSiswa->nama_ibu ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <a href="{{ route('siswa.cetak-kartu') }}" class="btn btn-success btn-lg" target="_blank">
                                    <i class="fas fa-print me-2"></i>Cetak Kartu Peserta
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <h5>Data Pendaftaran Tidak Ditemukan</h5>
                            <p>Silakan hubungi admin untuk informasi lebih lanjut.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection