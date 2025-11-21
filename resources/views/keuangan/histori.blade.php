@extends('layouts.app')

@section('title', 'Histori Pembayaran')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">📋 Histori Pembayaran</h1>
            <p class="text-muted mb-0">Catatan semua transaksi pembayaran yang telah diverifikasi</p>
        </div>
        <a href="{{ route('keuangan.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">💰 Riwayat Transaksi</h6>
                </div>
                <div class="col-auto">
                    <form method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control form-control-sm me-2" 
                               placeholder="Cari nama/no pendaftaran..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mx-3 mt-3">{{ session('error') }}</div>
            @endif
            
            @if($histori->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama Siswa</th>
                            <th>Jurusan</th>
                            <th>Nominal</th>
                            <th>Tanggal Bayar</th>
                            <th>Metode Bayar</th>
                            <th>User Verifikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histori as $h)
                        <tr>
                            <td>
                                <span class="badge bg-info">{{ $h->pendaftar->no_pendaftaran ?? '-' }}</span>
                            </td>
                            <td class="fw-bold">{{ $h->pendaftar->dataSiswa->nama ?? '-' }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $h->pendaftar->jurusan->nama ?? '-' }}</span>
                            </td>
                            <td class="fw-bold text-success">Rp {{ number_format($h->nominal ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $h->tanggal_bayar ? $h->tanggal_bayar->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <span class="badge bg-dark">{{ strtoupper($h->metode_pembayaran ?? '-') }}</span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $h->verifiedBy->name ?? 'System' }}<br>
                                    <span class="text-xs">{{ $h->verified_at ? $h->verified_at->format('d/m/Y H:i') : '-' }}</span>
                                </small>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('keuangan.histori.delete', $h->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus histori pembayaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer">
                {{ $histori->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-receipt fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-600">Belum Ada Histori Pembayaran</h5>
                <p class="text-muted">Histori akan muncul setelah ada pembayaran yang diverifikasi.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.text-gray-800 { color: #212529 !important; }
.text-gray-600 { color: #6c757d !important; }
.text-gray-300 { color: #adb5bd !important; }
</style>
@endsection