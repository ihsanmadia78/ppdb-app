@extends('layouts.app')

@section('title', 'Dashboard Keuangan')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- HEADER SECTION -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">💰 Dashboard Keuangan</h1>
            <p class="text-muted mb-0">Kelola dan pantau keuangan PPDB SMK BaktiNusantara 666 - {{ date('d F Y') }}</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-secondary btn-sm" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
            <a href="{{ route('keuangan.laporan') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-chart-bar"></i> Laporan Detail
            </a>
        </div>
    </div>

    <!-- SECTION 1: RINGKASAN KEUANGAN -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">📊 Ringkasan Keuangan PPDB</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-success h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">✅ Sudah Bayar</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPendaftarSudahBayar ?? 0) }}</div>
                                    <div class="text-xs text-muted">siswa telah membayar</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-warning h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">⏳ Belum Bayar</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPendaftarBelumBayar ?? 0) }}</div>
                                    <div class="text-xs text-muted">siswa belum membayar</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-danger h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">🔍 Menunggu Verifikasi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($menungguVerifikasi ?? 0) }}</div>
                                    <div class="text-xs text-muted">perlu diverifikasi</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">💰 Total Pemasukan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalUangMasukKeseluruhan ?? 0, 0, ',', '.') }}</div>
                                    <div class="text-xs text-muted">keseluruhan PPDB</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: AKSI CEPAT -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">⚡ Aksi Cepat Keuangan</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('keuangan.pembayaran', ['status' => 'paid']) }}" class="btn btn-warning w-100 py-3 text-decoration-none">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                            <span class="fw-bold">Verifikasi Pembayaran</span>
                            <small class="text-dark opacity-75">{{ $menungguVerifikasi ?? 0 }} menunggu</small>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('keuangan.pembayaran') }}" class="btn btn-secondary w-100 py-3 text-decoration-none">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-list fa-2x mb-2"></i>
                            <span class="fw-bold">Semua Pembayaran</span>
                            <small class="text-white-50">Daftar lengkap</small>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('keuangan.laporan') }}" class="btn btn-outline-secondary w-100 py-3 text-decoration-none">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <span class="fw-bold">Laporan Keuangan</span>
                            <small class="text-muted">Detail & analisis</small>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('keuangan.pembayaran.manual') }}" class="btn btn-success w-100 py-3 text-decoration-none">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-plus fa-2x mb-2"></i>
                            <span class="fw-bold">Input Manual</span>
                            <small class="text-white-50">Pembayaran tunai</small>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row g-3 mt-2">
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('keuangan.histori') }}" class="btn btn-info w-100 py-3 text-decoration-none">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-history fa-2x mb-2"></i>
                            <span class="fw-bold">Histori Pembayaran</span>
                            <small class="text-white-50">Semua transaksi</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 3: PEMBAYARAN TERBARU -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">🕰️ Pembayaran Terbaru (Menunggu Verifikasi)</h6>
            <a href="{{ route('keuangan.pembayaran', ['status' => 'paid']) }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-eye me-1"></i>Lihat Semua
            </a>
        </div>
        <div class="card-body">
            @if(isset($terbaru) && $terbaru->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Nominal</th>
                            <th>Metode</th>
                            <th>Tanggal Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($terbaru ?? [] as $p)
                        <tr>
                            <td><span class="badge bg-info">{{ $p->pendaftar->no_pendaftaran ?? '-' }}</span></td>
                            <td>{{ $p->pendaftar->dataSiswa->nama ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $p->pendaftar->jurusan->nama ?? '-' }}</span></td>
                            <td class="fw-bold text-success">Rp {{ number_format($p->nominal ?? 0, 0, ',', '.') }}</td>
                            <td><span class="badge bg-dark">{{ strtoupper($p->metode_pembayaran ?? '-') }}</span></td>
                            <td>{{ $p->tanggal_bayar ? $p->tanggal_bayar->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <a href="{{ route('keuangan.detail', $p->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-check-circle fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-600">Tidak Ada Pembayaran Menunggu</h5>
                <p class="text-muted">Semua pembayaran telah diverifikasi dengan baik.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.border-left-primary { border-left: 0.25rem solid #6c757d !important; }
.border-left-success { border-left: 0.25rem solid #495057 !important; }
.border-left-info { border-left: 0.25rem solid #adb5bd !important; }
.border-left-warning { border-left: 0.25rem solid #343a40 !important; }
.border-left-danger { border-left: 0.25rem solid #dc3545 !important; }
.text-gray-800 { color: #212529 !important; }
.text-gray-700 { color: #495057 !important; }
.text-gray-600 { color: #6c757d !important; }
.text-gray-300 { color: #adb5bd !important; }
</style>

<script>
function exportData() {
    window.location.href = '{{ route("keuangan.laporan") }}?export=excel';
}
</script>
@endsection