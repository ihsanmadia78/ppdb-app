@extends('layouts.app')

@section('title', 'Daftar Pendaftar - Verifikator')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Daftar Pendaftar</h1>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">🔍 Filter & Pencarian Pendaftar</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('verifikator.pendaftar') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><i class="fas fa-flag me-1"></i>Status Administrasi</label>
                        <select name="status" class="form-select">
                            <option value="">🔍 Semua Status</option>
                            <option value="SUBMIT" {{ request('status') == 'SUBMIT' ? 'selected' : '' }}>⏳ Belum Diverifikasi</option>
                            <option value="VERIFIKASI_ADMIN" {{ request('status') == 'VERIFIKASI_ADMIN' ? 'selected' : '' }}>🔄 Perlu Perbaikan</option>
                            <option value="MENUNGGU_PEMBAYARAN" {{ request('status') == 'MENUNGGU_PEMBAYARAN' ? 'selected' : '' }}>✅ Lulus Administrasi</option>
                            <option value="TIDAK_LULUS" {{ request('status') == 'TIDAK_LULUS' ? 'selected' : '' }}>❌ Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label"><i class="fas fa-graduation-cap me-1"></i>Jurusan</label>
                        <select name="jurusan_id" class="form-select">
                            <option value="">🎓 Semua</option>
                            @foreach($jurusan as $j)
                            <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>
                                {{ $j->kode }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label"><i class="fas fa-wave-square me-1"></i>Gelombang</label>
                        <select name="gelombang_id" class="form-select">
                            <option value="">🌊 Semua</option>
                            @foreach($gelombang as $gel)
                            <option value="{{ $gel->id }}" {{ request('gelombang_id') == $gel->id ? 'selected' : '' }}>
                                {{ $gel->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><i class="fas fa-search me-1"></i>Pencarian</label>
                        <input type="text" name="search" class="form-control" placeholder="🔍 Nama atau No. Pendaftaran" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pendaftar ({{ $pendaftar->count() }} data)</h6>
        </div>
        <div class="card-body">
            @if($pendaftar->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="12%">No. Pendaftaran</th>
                            <th width="18%">Nama Siswa</th>
                            <th width="10%">Jurusan</th>
                            <th width="10%">Gelombang</th>
                            <th width="15%">Status Administrasi</th>
                            <th width="10%">Status Berkas</th>
                            <th width="12%">Tanggal Daftar</th>
                            <th width="13%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftar as $p)
                        <tr>
                            <td>
                                <span class="badge bg-info text-dark">{{ $p->no_pendaftaran }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-gray-600 rounded-circle d-flex align-items-center justify-content-center me-2">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $p->dataSiswa->nama ?? '-' }}</div>
                                        <small class="text-muted">NISN: {{ $p->dataSiswa->nisn ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $p->jurusan->kode ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-dark text-white">{{ $p->gelombang->nama ?? '-' }}</span>
                            </td>
                            <td>
                                @if($p->status == 'SUBMIT')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock"></i> Belum Diverifikasi
                                    </span>
                                @elseif($p->status == 'VERIFIKASI_ADMIN')
                                    <span class="badge bg-info text-dark">
                                        <i class="fas fa-exclamation-triangle"></i> Perlu Perbaikan
                                    </span>
                                @elseif($p->status == 'MENUNGGU_PEMBAYARAN')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Lulus Administrasi
                                    </span>
                                @elseif($p->status == 'TIDAK_LULUS')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times"></i> Ditolak
                                    </span>
                                @else
                                    <span class="badge bg-secondary">{{ $p->status }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $jumlahBerkas = $p->berkas->count();
                                    $berkasLengkap = $jumlahBerkas >= 4; // Minimal 4 berkas
                                @endphp
                                @if($berkasLengkap)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Lengkap ({{ $jumlahBerkas }})
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-exclamation"></i> Kurang ({{ $jumlahBerkas }})
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small>
                                    {{ $p->created_at->format('d/m/Y') }}<br>
                                    <span class="text-muted">{{ $p->created_at->format('H:i') }}</span>
                                </small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('verifikator.detail', $p->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($p->status == 'SUBMIT' || $p->status == 'VERIFIKASI_ADMIN')
                                        <a href="{{ route('verifikator.detail', $p->id) }}" class="btn btn-sm btn-outline-success" title="Verifikasi">
                                            <i class="fas fa-clipboard-check"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-600">Tidak Ada Data Pendaftar</h5>
                <p class="text-muted">Belum ada pendaftar yang perlu diverifikasi atau sesuai dengan filter yang dipilih.</p>
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
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
.btn-group .btn {
    margin-right: 2px;
}
.badge {
    font-size: 0.75em;
}
</style>
@endsection