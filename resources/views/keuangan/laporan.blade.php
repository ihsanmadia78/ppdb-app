@extends('layouts.sidebar')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- HEADER SECTION -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">📈 Laporan Keuangan PPDB</h1>
            <p class="text-muted mb-0">Rekapitulasi lengkap pemasukan dan pembayaran - {{ date('d F Y') }}</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-secondary btn-sm" onclick="window.print()">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
            <button class="btn btn-outline-secondary btn-sm" onclick="exportExcel()">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
        </div>
    </div>

    <!-- SECTION 1: FILTER & KONTROL -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">🔍 Filter & Kontrol Laporan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('keuangan.laporan') }}" id="filterForm">
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-3">
                        <label class="form-label fw-bold">📅 Periode Tanggal</label>
                        <div class="input-group">
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from', date('Y-m-01')) }}">
                            <span class="input-group-text">s/d</span>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to', date('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <label class="form-label fw-bold">🎓 Filter Jurusan</label>
                        <select name="jurusan_id" class="form-select">
                            <option value="">Semua Jurusan</option>
                            @foreach(\App\Models\Jurusan::all() as $j)
                            <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>
                                {{ $j->kode }} - {{ $j->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <label class="form-label fw-bold">🌊 Filter Gelombang</label>
                        <select name="gelombang_id" class="form-select">
                            <option value="">Semua Gelombang</option>
                            @foreach(\App\Models\Gelombang::all() as $g)
                            <option value="{{ $g->id }}" {{ request('gelombang_id') == $g->id ? 'selected' : '' }}>
                                {{ $g->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-search"></i> Terapkan Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- SECTION 2: RINGKASAN KEUANGAN -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">💰 Ringkasan Keuangan Periode</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-success h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">💵 Total Pemasukan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPeriode ?? 0, 0, ',', '.') }}</div>
                                    <div class="text-xs text-muted">periode terpilih</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
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
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">✅ Sudah Bayar</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahSudahBayar ?? 0 }}</div>
                                    <div class="text-xs text-muted">dari {{ $totalPendaftar ?? 0 }} pendaftar</div>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahBelumBayar ?? 0 }}</div>
                                    <div class="text-xs text-muted">perlu follow up</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-info h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">📊 Total Transaksi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTransaksi ?? 0 }}</div>
                                    <div class="text-xs text-muted">terverifikasi</div>
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

    <!-- SECTION 3: ANALISIS GRAFIK -->
    <div class="row mb-4">
        <!-- Pemasukan per Jurusan -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">🎓 Pemasukan per Jurusan</h6>
                </div>
                <div class="card-body">
                    <canvas id="pemasukanJurusanChart" height="200"></canvas>
                    <div class="mt-3">
                        @if(isset($pemasukanPerJurusan) && count($pemasukanPerJurusan) > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Jurusan</th>
                                            <th>Pembayar</th>
                                            <th>Pemasukan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pemasukanPerJurusan as $jurusan)
                                        <tr>
                                            <td><strong>{{ $jurusan->kode }}</strong></td>
                                            <td><span class="badge bg-info">{{ $jurusan->jumlah ?? 0 }}</span></td>
                                            <td><span class="badge bg-success">Rp {{ number_format($jurusan->total, 0, ',', '.') }}</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Pemasukan per Gelombang -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">🌊 Pemasukan per Gelombang</h6>
                </div>
                <div class="card-body">
                    <canvas id="pemasukanGelombangChart" height="200"></canvas>
                    <div class="mt-3">
                        @if(isset($pemasukanPerGelombang) && count($pemasukanPerGelombang) > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Gelombang</th>
                                            <th>Pembayar</th>
                                            <th>Pemasukan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pemasukanPerGelombang as $gelombang)
                                        <tr>
                                            <td><strong>{{ $gelombang->nama }}</strong></td>
                                            <td><span class="badge bg-info">{{ $gelombang->jumlah ?? 0 }}</span></td>
                                            <td><span class="badge bg-success">Rp {{ number_format($gelombang->total, 0, ',', '.') }}</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 4: DAFTAR SISWA SUDAH BAYAR -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">✅ Daftar Siswa yang Sudah Bayar</h6>
            <span class="badge bg-success fs-6">{{ isset($siswasSudahBayar) ? $siswasSudahBayar->count() : 0 }} siswa</span>
        </div>
        <div class="card-body">
            @if(isset($siswasSudahBayar) && $siswasSudahBayar->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">No. Pendaftaran</th>
                            <th width="20%">Nama</th>
                            <th width="10%">Jurusan</th>
                            <th width="12%">Gelombang</th>
                            <th width="15%">Nominal</th>
                            <th width="15%">Tanggal Bayar</th>
                            <th width="8%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswasSudahBayar as $siswa)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><span class="badge bg-info">{{ $siswa->pendaftar->no_pendaftaran }}</span></td>
                            <td class="fw-bold">{{ $siswa->pendaftar->dataSiswa->nama ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $siswa->pendaftar->jurusan->kode ?? '-' }}</span></td>
                            <td><span class="badge bg-dark text-white">{{ $siswa->pendaftar->gelombang->nama ?? '-' }}</span></td>
                            <td class="fw-bold text-success">Rp {{ number_format($siswa->nominal, 0, ',', '.') }}</td>
                            <td>{{ $siswa->verified_at ? $siswa->verified_at->format('d/m/Y H:i') : '-' }}</td>
                            <td><span class="badge bg-success">✅ Lunas</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-success">
                        <tr>
                            <th colspan="5" class="text-end">Total Pemasukan:</th>
                            <th class="fw-bold">Rp {{ number_format($siswasSudahBayar->sum('nominal'), 0, ',', '.') }}</th>
                            <th colspan="2">{{ $siswasSudahBayar->count() }} transaksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-money-bill-wave fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-600">Belum Ada Pembayaran</h5>
                <p class="text-muted">Belum ada siswa yang melakukan pembayaran pada periode ini.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- SECTION 5: DAFTAR SISWA BELUM BAYAR -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">⏰ Daftar Siswa yang Belum Bayar</h6>
            <span class="badge bg-warning text-dark fs-6">{{ isset($siswasBelumBayar) ? $siswasBelumBayar->count() : 0 }} siswa</span>
        </div>
        <div class="card-body">
            @if(isset($siswasBelumBayar) && $siswasBelumBayar->count() > 0)
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Perhatian:</strong> Berikut adalah daftar siswa yang belum melakukan pembayaran. Lakukan follow up untuk memastikan pembayaran segera diselesaikan.
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">No. Pendaftaran</th>
                            <th width="20%">Nama</th>
                            <th width="10%">Jurusan</th>
                            <th width="12%">Gelombang</th>
                            <th width="18%">Email</th>
                            <th width="12%">Telepon</th>
                            <th width="8%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswasBelumBayar as $siswa)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><span class="badge bg-info">{{ $siswa->no_pendaftaran }}</span></td>
                            <td class="fw-bold">{{ $siswa->dataSiswa->nama ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $siswa->jurusan->kode ?? '-' }}</span></td>
                            <td><span class="badge bg-dark text-white">{{ $siswa->gelombang->nama ?? '-' }}</span></td>
                            <td>{{ $siswa->email ?? '-' }}</td>
                            <td>{{ $siswa->dataSiswa->telp_ortu ?? '-' }}</td>
                            <td><span class="badge bg-warning text-dark">⏰ Belum</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-warning">
                        <tr>
                            <th colspan="7" class="text-end">Total Siswa Belum Bayar:</th>
                            <th>{{ $siswasBelumBayar->count() }} siswa</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h5 class="text-success">Semua Siswa Sudah Bayar!</h5>
                <p class="text-muted">Tidak ada siswa yang belum melakukan pembayaran pada periode ini.</p>
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
.text-gray-800 { color: #212529 !important; }
.text-gray-700 { color: #495057 !important; }
.text-gray-600 { color: #6c757d !important; }
.text-gray-300 { color: #adb5bd !important; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Data untuk charts
const pemasukanJurusan = @json($pemasukanPerJurusan ?? []);
const pemasukanGelombang = @json($pemasukanPerGelombang ?? []);

// Chart Pemasukan per Jurusan
if (pemasukanJurusan.length > 0) {
    new Chart(document.getElementById('pemasukanJurusanChart'), {
        type: 'bar',
        data: {
            labels: pemasukanJurusan.map(j => j.kode),
            datasets: [{
                label: 'Pemasukan (Rp)',
                data: pemasukanJurusan.map(j => j.total),
                backgroundColor: '#6c757d',
                borderColor: '#495057',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
} else {
    document.getElementById('pemasukanJurusanChart').parentElement.innerHTML = `
        <div class="text-center py-4">
            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada data pemasukan per jurusan</p>
        </div>
    `;
}

// Chart Pemasukan per Gelombang
if (pemasukanGelombang.length > 0) {
    new Chart(document.getElementById('pemasukanGelombangChart'), {
        type: 'doughnut',
        data: {
            labels: pemasukanGelombang.map(g => g.nama),
            datasets: [{
                data: pemasukanGelombang.map(g => g.total),
                backgroundColor: ['#6c757d', '#495057', '#adb5bd', '#ced4da', '#dee2e6']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': Rp ' + context.parsed.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
} else {
    document.getElementById('pemasukanGelombangChart').parentElement.innerHTML = `
        <div class="text-center py-4">
            <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada data pemasukan per gelombang</p>
        </div>
    `;
}

function exportExcel() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'excel');
    window.location.href = '{{ route("keuangan.laporan") }}?' + params.toString();
}
</script>
@endsection
