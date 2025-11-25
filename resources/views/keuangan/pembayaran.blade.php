@extends('layouts.sidebar')

@section('title', 'Daftar Pembayaran - Keuangan')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">💳 Daftar Pembayaran</h1>
            <p class="text-muted mb-0">Kelola dan verifikasi pembayaran pendaftar PPDB</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-secondary btn-sm" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak
            </button>
            <a href="{{ route('keuangan.pembayaran.manual') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Input Manual
            </a>
            <button class="btn btn-outline-secondary btn-sm" onclick="exportData()">
                <i class="fas fa-download"></i> Export
            </button>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-gray-800">🔍 Filter Pembayaran</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('keuangan.pembayaran') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><i class="fas fa-flag me-1"></i>Status Pembayaran</label>
                        <select name="status" class="form-select">
                            <option value="">🔍 Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>💰 Menunggu Verifikasi</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>✅ Terverifikasi</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><i class="fas fa-credit-card me-1"></i>Metode Pembayaran</label>
                        <select name="metode" class="form-select">
                            <option value="">💳 Semua Metode</option>
                            <option value="transfer" {{ request('metode') == 'transfer' ? 'selected' : '' }}>🏦 Transfer Bank</option>
                            <option value="va" {{ request('metode') == 'va' ? 'selected' : '' }}>💳 Virtual Account</option>
                            <option value="qris" {{ request('metode') == 'qris' ? 'selected' : '' }}>📱 QRIS</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-search me-1"></i>Pencarian</label>
                        <input type="text" name="search" class="form-control" placeholder="🔍 Cari nama atau nomor pendaftaran..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Data Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-gray-800">📋 Data Pembayaran ({{ $pembayaran->count() }} data)</h6>
        </div>
        <div class="card-body">
            @if($pembayaran->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th width="12%">No. Pendaftaran</th>
                            <th width="15%">Nama Pendaftar</th>
                            <th width="12%">Jurusan</th>
                            <th width="10%">Gelombang</th>
                            <th width="10%">Nominal Biaya</th>
                            <th width="8%">Metode</th>
                            <th width="10%">Tanggal Bayar</th>
                            <th width="12%">Status Verifikasi</th>
                            <th width="11%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembayaran as $p)
                        <tr>
                            <td><span class="badge bg-info">{{ $p->pendaftar->no_pendaftaran }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-gray-600 rounded-circle d-flex align-items-center justify-content-center me-2">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $p->pendaftar->dataSiswa->nama ?? '-' }}</div>
                                        <small class="text-muted">NISN: {{ $p->pendaftar->dataSiswa->nisn ?? '-' }}</small><br>
                                        <small class="text-info">{{ $p->pendaftar->dataSiswa->nama_sekolah_asal ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-secondary">{{ $p->pendaftar->jurusan->kode ?? '-' }}</span></td>
                            <td><span class="badge bg-dark text-white">{{ $p->pendaftar->gelombang->nama ?? '-' }}</span></td>
                            <td class="fw-bold text-success">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    @if($p->metode_pembayaran == 'transfer')
                                        <span class="badge bg-primary mb-1">🏦 Transfer</span>
                                    @elseif($p->metode_pembayaran == 'va')
                                        <span class="badge bg-info mb-1">💳 VA</span>
                                    @elseif($p->metode_pembayaran == 'qris')
                                        <span class="badge bg-warning text-dark mb-1">📱 QRIS</span>
                                    @else
                                        <span class="badge bg-secondary mb-1">{{ strtoupper($p->metode_pembayaran ?? '-') }}</span>
                                    @endif
                                    
                                    @if($p->bukti_bayar)
                                        <a href="{{ asset('storage/' . $p->bukti_bayar) }}" target="_blank" class="btn btn-xs btn-outline-success" style="font-size: 10px; padding: 2px 6px;">
                                            <i class="fas fa-eye"></i> Lihat Bukti
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($p->tanggal_bayar)
                                    <small>
                                        {{ $p->tanggal_bayar->format('d/m/Y') }}<br>
                                        <span class="text-muted">{{ $p->tanggal_bayar->format('H:i') }}</span>
                                    </small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($p->status == 'pending')
                                    <span class="badge bg-secondary">⏳ Pending</span>
                                @elseif($p->status == 'paid')
                                    <span class="badge bg-warning text-dark">⏰ Menunggu Verifikasi</span>
                                @elseif($p->status == 'verified')
                                    <span class="badge bg-success">✅ Terverifikasi</span>
                                @elseif($p->status == 'rejected')
                                    <span class="badge bg-danger">❌ Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('keuangan.detail', $p->id) }}" class="btn btn-sm btn-outline-secondary" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($p->bukti_bayar)
                                        <a href="{{ asset('storage/' . $p->bukti_bayar) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Lihat Bukti">
                                            <i class="fas fa-file-image"></i>
                                        </a>
                                    @endif
                                    @if($p->status == 'paid')
                                        <!-- Form Terima -->
                                        <form method="POST" action="{{ route('keuangan.verifikasi', $p->id) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menerima pembayaran ini?')">
                                            @csrf
                                            <input type="hidden" name="status" value="verified">
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Terima Pembayaran">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        
                                        <!-- Form Tolak -->
                                        <form method="POST" action="{{ route('keuangan.verifikasi', $p->id) }}" style="display: inline;" onsubmit="return tolakPembayaranForm(this, {{ $p->id }})">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <input type="hidden" name="catatan" id="catatan_{{ $p->id }}">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Tolak Pembayaran">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
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
                <i class="fas fa-credit-card fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-600">Belum Ada Data Pembayaran</h5>
                <p class="text-muted">Data pembayaran akan muncul setelah ada pendaftar yang melakukan pembayaran.</p>
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

<script>
function tolakPembayaranForm(form, id) {
    const catatan = prompt('Masukkan alasan penolakan:');
    if (!catatan || catatan.trim() === '') {
        alert('Alasan penolakan harus diisi!');
        return false;
    }
    
    if (!confirm('Yakin ingin menolak pembayaran ini?')) {
        return false;
    }
    
    // Set catatan value
    document.getElementById('catatan_' + id).value = catatan;
    return true;
}

function exportData() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'excel');
    window.location.href = '{{ route("keuangan.pembayaran") }}?' + params.toString();
}
</script>
@endsection
