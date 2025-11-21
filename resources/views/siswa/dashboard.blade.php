@extends('siswa.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Dashboard Siswa - {{ Auth::user()->name }}</h4>
                </div>
                <div class="card-body">
                    @if($pendaftar)
                        @if($pendaftar->status == 'BERKAS_DITOLAK')
                        <div class="alert alert-danger">
                            <h5><i class="fas fa-exclamation-triangle"></i> Berkas Ditolak</h5>
                            <p>Berkas Anda ditolak oleh verifikator. Silakan perbaiki dan upload ulang berkas yang diperlukan.</p>
                            <a href="{{ route('siswa.perbaikan-berkas') }}" class="btn btn-warning">
                                <i class="fas fa-upload"></i> Perbaikan Berkas
                            </a>
                        </div>
                        @endif
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <h5 class="card-title">Status Pendaftaran</h5>
                                        <p class="card-text">
                                            <span class="badge badge-{{ $pendaftar->status == 'LULUS' ? 'success' : ($pendaftar->status == 'TIDAK_LULUS' ? 'danger' : 'warning') }}">
                                                {{ $pendaftar->status }}
                                            </span>
                                        </p>
                                        <p><strong>No. Pendaftaran:</strong> {{ $pendaftar->no_pendaftaran }}</p>
                                        <p><strong>Jurusan:</strong> {{ $pendaftar->jurusan->nama ?? '-' }}</p>
                                        <p><strong>Gelombang:</strong> {{ $pendaftar->gelombang->nama ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-info">
                                    <div class="card-body">
                                        <h5 class="card-title">Status Pembayaran</h5>
                                        @if($pendaftar->pembayaran)
                                            <p class="card-text">
                                                <span class="badge badge-{{ $pendaftar->pembayaran->status == 'verified' ? 'success' : 'warning' }}">
                                                    {{ $pendaftar->pembayaran->status == 'verified' ? 'Terverifikasi' : 'Menunggu Verifikasi' }}
                                                </span>
                                            </p>
                                            <p><strong>Nominal:</strong> Rp {{ number_format($pendaftar->pembayaran->nominal, 0, ',', '.') }}</p>
                                            <p><strong>Metode:</strong> {{ strtoupper($pendaftar->pembayaran->metode_pembayaran) }}</p>
                                        @else
                                            <p class="text-danger">Belum ada pembayaran</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Menu Portal Siswa</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <a href="{{ route('siswa.profil') }}" class="btn btn-primary btn-block">
                                                    <i class="fas fa-user-circle"></i> Profil
                                                </a>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <a href="{{ route('siswa.biodata') }}" class="btn btn-info btn-block">
                                                    <i class="fas fa-id-card"></i> Biodata
                                                </a>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <a href="{{ route('siswa.pembayaran') }}" class="btn btn-success btn-block">
                                                    <i class="fas fa-credit-card"></i> Pembayaran
                                                </a>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <a href="{{ route('siswa.cetak-kartu') }}" class="btn btn-warning btn-block" target="_blank">
                                                    <i class="fas fa-print"></i> Cetak Kartu
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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