@extends('layouts.sidebar')

@section('title', 'Pendaftar Cadangan - Admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">⏳ Pendaftar Cadangan</h1>
            <p class="text-muted mb-0">Daftar siswa yang masuk dalam daftar cadangan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
            <a href="{{ route('admin.export', ['status' => 'CADANGAN']) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-download"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Stats Card -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-user-clock fa-2x"></i>
                        </div>
                        <div>
                            <div class="h4 mb-0">{{ $pendaftar->count() }}</div>
                            <div class="small">Total Cadangan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-graduation-cap fa-2x"></i>
                        </div>
                        <div>
                            <div class="h4 mb-0">{{ $pendaftar->groupBy('jurusan_id')->count() }}</div>
                            <div class="small">Jurusan Terdampak</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">📋 Data Pendaftar Cadangan ({{ $pendaftar->count() }} siswa)</h6>
        </div>
        <div class="card-body">
            @if($pendaftar->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="table-warning">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">No. Pendaftaran</th>
                            <th width="20%">Nama Lengkap</th>
                            <th width="15%">Jurusan</th>
                            <th width="10%">Gelombang</th>
                            <th width="15%">Tanggal Cadangan</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftar as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge bg-info">{{ $p->no_pendaftaran }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-warning rounded-circle d-flex align-items-center justify-content-center me-2">
                                        <i class="fas fa-user text-dark"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $p->dataSiswa->nama ?? '-' }}</div>
                                        <small class="text-muted">NISN: {{ $p->dataSiswa->nisn ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-secondary">{{ $p->jurusan->nama ?? '-' }}</span></td>
                            <td><span class="badge bg-dark">{{ $p->gelombang->nama ?? '-' }}</span></td>
                            <td>
                                @if($p->updated_at)
                                    <small>
                                        {{ $p->updated_at->format('d/m/Y') }}<br>
                                        <span class="text-muted">{{ $p->updated_at->format('H:i') }}</span>
                                    </small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-clock"></i> CADANGAN
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.show', $p->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.export', ['id' => $p->id]) }}" class="btn btn-sm btn-outline-success" title="Export Data">
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
                <i class="fas fa-user-clock fa-4x text-gray-300 mb-3"></i>
                <h5 class="text-gray-600">Belum Ada Pendaftar Cadangan</h5>
                <p class="text-muted">Data akan muncul setelah admin menentukan status akhir pendaftar.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 2rem;
    height: 2rem;
    font-size: 0.875rem;
}
.text-gray-800 { color: #212529 !important; }
.text-gray-600 { color: #6c757d !important; }
.text-gray-300 { color: #adb5bd !important; }
</style>
@endsection
