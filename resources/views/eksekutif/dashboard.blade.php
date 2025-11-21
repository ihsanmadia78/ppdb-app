@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- HEADER SECTION -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">📊 Dashboard Eksekutif</h1>
            <p class="text-muted mb-0">PPDB SMK BaktiNusantara 666 - {{ date('d F Y') }}</p>
        </div>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-print"></i> Cetak Laporan
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="printSummary()">Laporan Ringkasan</a></li>
                    <li><a class="dropdown-item" href="#" onclick="printDetailed()">Laporan Detail</a></li>
                    <li><a class="dropdown-item" href="#" onclick="printAnalytics()">Laporan Analitik</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-download"></i> Export Data
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.export') }}">Export Excel</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.reports', ['type' => 'summary']) }}">Export JSON Summary</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.reports', ['type' => 'analytics']) }}">Export Analytics</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- SECTION 1: KPI INDICATORS -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">🎯 Key Performance Indicators (KPI)</h6>
            <span class="badge bg-{{ $kpiData['status_kpi'] == 'excellent' ? 'secondary' : ($kpiData['status_kpi'] == 'good' ? 'dark' : 'light text-dark') }} fs-6">
                {{ $kpiData['status_kpi'] == 'excellent' ? 'Excellent' : ($kpiData['status_kpi'] == 'good' ? 'Good' : 'Needs Improvement') }}
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">Target Pendaftar</span>
                        <span class="badge bg-primary">{{ number_format($kpiData['target_pendaftar']) }}</span>
                    </div>
                    <div class="progress mb-2" style="height: 25px;">
                        <div class="progress-bar bg-{{ $kpiData['persentase_realisasi'] >= 100 ? 'secondary' : ($kpiData['persentase_realisasi'] >= 80 ? 'dark' : 'light') }}" 
                             style="width: {{ min($kpiData['persentase_realisasi'], 100) }}%">
                            {{ $kpiData['realisasi_pendaftar'] }} / {{ $kpiData['target_pendaftar'] }} ({{ $kpiData['persentase_realisasi'] }}%)
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">Target Verifikasi</span>
                        <span class="badge bg-info">{{ $kpiData['target_verifikasi'] }}%</span>
                    </div>
                    <div class="progress mb-2" style="height: 25px;">
                        <div class="progress-bar bg-{{ $kpiData['realisasi_verifikasi'] >= $kpiData['target_verifikasi'] ? 'secondary' : 'dark' }}" 
                             style="width: {{ $kpiData['realisasi_verifikasi'] }}%">
                            {{ $kpiData['realisasi_verifikasi'] }}% Terverifikasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: RINGKASAN STATISTIK -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">📈 Ringkasan Statistik PPDB</h6>
        </div>
        <div class="card-body">
            <!-- Baris 1: Data Utama -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">📅 Pendaftar Hari Ini</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($pendaftarHariIni) }}</div>
                                    <div class="text-xs text-muted">{{ date('d F Y') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-success h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">👥 Total Pendaftar</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPendaftar) }}</div>
                                    <div class="text-xs text-muted">dari {{ number_format($totalKuota) }} kuota ({{ $persentaseKuota }}%)</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">✅ Lulus Verifikasi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($lulusVerifikasiAdmin) }}</div>
                                    <div class="text-xs text-muted">{{ $totalPendaftar > 0 ? round(($lulusVerifikasiAdmin / $totalPendaftar) * 100, 1) : 0 }}% dari total</div>
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
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">💰 Sudah Bayar</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($sudahBayar) }}</div>
                                    <div class="text-xs text-muted">{{ $totalPendaftar > 0 ? round(($sudahBayar / $totalPendaftar) * 100, 1) : 0 }}% dari total</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Baris 2: Status Kelulusan -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-success h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">🎉 Diterima</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($diterima) }}</div>
                                    <div class="text-xs text-muted">{{ $totalPendaftar > 0 ? round(($diterima / $totalPendaftar) * 100, 1) : 0 }}% dari total</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-trophy fa-2x text-gray-300"></i>
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
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">⏳ Cadangan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($cadangan) }}</div>
                                    <div class="text-xs text-muted">{{ $totalPendaftar > 0 ? round(($cadangan / $totalPendaftar) * 100, 1) : 0 }}% dari total</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
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
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">❌ Tidak Lulus</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($tidakLulus) }}</div>
                                    <div class="text-xs text-muted">{{ $totalPendaftar > 0 ? round(($tidakLulus / $totalPendaftar) * 100, 1) : 0 }}% dari total</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
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
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">🪑 Sisa Kuota</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalKuota - $totalPendaftar) }}</div>
                                    <div class="text-xs text-muted">tempat tersedia</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chair fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 3: ANALISIS KUOTA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">🎯 Analisis Kuota vs Pendaftar</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-8 col-lg-7 mb-4">
                    <canvas id="kuotaChart" height="120"></canvas>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Jurusan</th>
                                    <th>Kuota</th>
                                    <th>Pendaftar</th>
                                    <th>Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jurusanStats as $jurusan)
                                <tr>
                                    <td>
                                        <strong>{{ $jurusan['kode'] }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($jurusan['nama'], 15) }}</small>
                                    </td>
                                    <td><span class="badge bg-secondary">{{ $jurusan['kuota'] }}</span></td>
                                    <td><span class="badge bg-info">{{ $jurusan['pendaftar'] }}</span></td>
                                    <td>
                                        <span class="badge bg-{{ $jurusan['sisa'] > 0 ? 'success' : 'danger' }}">
                                            {{ $jurusan['sisa'] }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th>Total</th>
                                    <th><span class="badge bg-dark">{{ $totalKuota }}</span></th>
                                    <th><span class="badge bg-primary">{{ $totalPendaftar }}</span></th>
                                    <th><span class="badge bg-warning text-dark">{{ $totalKuota - $totalPendaftar }}</span></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 4: TREN & ANALISIS -->
    <div class="row mb-4">
        <!-- Tren Pendaftaran -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">📈 Tren Pendaftaran Harian</h6>
                        <div class="d-flex gap-2">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="periodFilter" id="mingguan" value="mingguan" checked>
                                <label class="btn btn-outline-secondary btn-sm" for="mingguan">📅 Mingguan</label>
                                
                                <input type="radio" class="btn-check" name="periodFilter" id="bulanan" value="bulanan">
                                <label class="btn btn-outline-secondary btn-sm" for="bulanan">🗓️ Bulanan</label>
                                
                                <input type="radio" class="btn-check" name="periodFilter" id="seluruhPeriode" value="seluruhPeriode">
                                <label class="btn btn-outline-secondary btn-sm" for="seluruhPeriode">📊 Seluruh Periode</label>
                            </div>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="chartType" id="lineChart" value="line" checked>
                                <label class="btn btn-outline-dark btn-sm" for="lineChart">📈 Line</label>
                                
                                <input type="radio" class="btn-check" name="chartType" id="barChart" value="bar">
                                <label class="btn btn-outline-dark btn-sm" for="barChart">📊 Bar</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="trenInfo" class="mb-3">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="border rounded p-2">
                                    <small class="text-muted d-block">Periode</small>
                                    <strong id="currentPeriod">7 Hari Terakhir</strong>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-2">
                                    <small class="text-muted d-block">Total Pendaftar</small>
                                    <strong id="totalInPeriod">-</strong>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-2">
                                    <small class="text-muted d-block">Rata-rata/Hari</small>
                                    <strong id="avgPerDay">-</strong>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-2">
                                    <small class="text-muted d-block">Tren</small>
                                    <strong id="trendIndicator">-</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <canvas id="trenChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Distribution -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">📊 Distribusi Status</h6>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 5: ANALISIS GEOGRAFIS & ASAL SEKOLAH -->
    <div class="row mb-4">
        <!-- Asal Sekolah -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">🏫 Top 5 Asal Sekolah</h6>
                </div>
                <div class="card-body">
                    @foreach($asalSekolah as $sekolah)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="fw-bold">{{ $sekolah['nama'] }}</div>
                            <small class="text-muted">{{ $sekolah['jumlah'] }} pendaftar</small>
                        </div>
                        <div class="progress" style="width: 100px; height: 10px;">
                            <div class="progress-bar bg-primary" 
                                 style="width: {{ $totalPendaftar > 0 ? ($sekolah['jumlah'] / $totalPendaftar) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sebaran Wilayah -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">🗺️ Sebaran Wilayah Pendaftar</h6>
                </div>
                <div class="card-body">
                    <canvas id="wilayahChart" height="200"></canvas>
                    <div class="mt-3">
                        <h6 class="text-muted mb-2">📊 Analisis Promosi Tahun Depan:</h6>
                        @if(count($distribusiWilayah) > 0)
                            @php
                                $topWilayah = collect($distribusiWilayah)->sortByDesc('jumlah')->take(3);
                                $totalWilayah = collect($distribusiWilayah)->sum('jumlah');
                            @endphp
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Area Terpopuler:</small>
                                    <div class="fw-bold text-success">{{ $topWilayah->first()['wilayah'] ?? '-' }}</div>
                                    <small>({{ $topWilayah->first()['jumlah'] ?? 0 }} pendaftar)</small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Total Wilayah:</small>
                                    <div class="fw-bold">{{ count($distribusiWilayah) }} area</div>
                                    <small>({{ $totalWilayah }} pendaftar)</small>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Ranking</th>
                                            <th>Wilayah</th>
                                            <th>Jumlah</th>
                                            <th>%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($distribusiWilayah as $index => $wilayah)
                                        <tr>
                                            <td>
                                                @if($index == 0)
                                                    🥇
                                                @elseif($index == 1)
                                                    🥈
                                                @elseif($index == 2)
                                                    🥉
                                                @else
                                                    {{ $index + 1 }}
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $wilayah['wilayah'] }}</td>
                                            <td><span class="badge bg-secondary">{{ $wilayah['jumlah'] }}</span></td>
                                            <td>{{ $totalWilayah > 0 ? round(($wilayah['jumlah'] / $totalWilayah) * 100, 1) : 0 }}%</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="alert alert-info mt-2">
                                <small>
                                    <i class="fas fa-lightbulb me-1"></i>
                                    <strong>Rekomendasi:</strong> Fokus promosi di {{ $topWilayah->first()['wilayah'] ?? 'area terpopuler' }} dan tingkatkan outreach di wilayah dengan pendaftar rendah.
                                </small>
                            </div>
                        @else
                            <div class="text-center text-muted py-3">
                                <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                                <p>Belum ada data distribusi wilayah</p>
                                <small>Data akan muncul setelah pendaftar mengisi wilayah</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 6: PERFORMANCE DETAIL -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">🎓 Performance Detail per Jurusan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Jurusan</th>
                            <th>Pendaftar</th>
                            <th>Kuota</th>
                            <th>Persentase</th>
                            <th>Sisa Kuota</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jurusanStats as $jurusan)
                        <tr>
                            <td>
                                <strong>{{ $jurusan['nama'] }}</strong><br>
                                <small class="text-muted">{{ $jurusan['kode'] }}</small>
                            </td>
                            <td><span class="badge bg-info">{{ $jurusan['pendaftar'] }}</span></td>
                            <td>{{ $jurusan['kuota'] }}</td>
                            <td>
                                <span class="badge bg-{{ $jurusan['persentase'] >= 100 ? 'secondary' : ($jurusan['persentase'] >= 80 ? 'dark' : 'light text-dark') }}">
                                    {{ $jurusan['persentase'] }}%
                                </span>
                            </td>
                            <td>{{ $jurusan['sisa'] }}</td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-{{ $jurusan['persentase'] >= 100 ? 'secondary' : ($jurusan['persentase'] >= 80 ? 'dark' : 'light') }}" 
                                         style="width: {{ min($jurusan['persentase'], 100) }}%">
                                        {{ $jurusan['persentase'] }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SECTION 7: PENDAFTAR TERBARU -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">👥 5 Pendaftar Terbaru</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftarTerbaru as $pendaftar)
                        <tr>
                            <td><span class="badge bg-info">{{ $pendaftar->no_pendaftaran }}</span></td>
                            <td>{{ $pendaftar->dataSiswa?->nama ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $pendaftar->jurusan?->nama ?? '-' }}</span></td>
                            <td>
                                <span class="badge bg-{{ App\Models\PendaftarStatus::getStatusColor($pendaftar->status) }}">
                                    {{ App\Models\PendaftarStatus::getStatusList()[$pendaftar->status] ?? $pendaftar->status }}
                                </span>
                            </td>
                            <td>{{ $pendaftar->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary { border-left: 0.25rem solid #6c757d !important; }
.border-left-success { border-left: 0.25rem solid #495057 !important; }
.border-left-info { border-left: 0.25rem solid #adb5bd !important; }
.border-left-warning { border-left: 0.25rem solid #343a40 !important; }
.border-left-danger { border-left: 0.25rem solid #dc3545 !important; }
.text-gray-800 { color: #5a5c69 !important; }
.text-gray-300 { color: #dddfeb !important; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Kuota Chart (Horizontal Bar)
const jurusanData = @json($jurusanStats);
new Chart(document.getElementById('kuotaChart'), {
    type: 'bar',
    data: {
        labels: jurusanData.map(j => j.nama),
        datasets: [{
            label: 'Kuota',
            data: jurusanData.map(j => j.kuota),
            backgroundColor: '#adb5bd',
            borderColor: '#6c757d',
            borderWidth: 1
        }, {
            label: 'Pendaftar',
            data: jurusanData.map(j => j.pendaftar),
            backgroundColor: '#6c757d',
            borderColor: '#495057',
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            title: { display: false }
        },
        scales: {
            x: {
                beginAtZero: true,
                ticks: {
                    stepSize: 5
                }
            }
        }
    }
});

// Tren Data
const trenMingguan = @json($trenMingguan);
const trenBulanan = @json($trenBulanan);
const trenSeluruhPeriode = @json($trenSeluruhPeriode);

let currentChart = null;
let currentData = trenMingguan;
let currentType = 'line';

function updateTrenChart() {
    if (currentChart) {
        currentChart.destroy();
    }
    
    // Calculate statistics
    const totalInPeriod = currentData.reduce((sum, d) => sum + d.count, 0);
    const avgPerDay = currentData.length > 0 ? (totalInPeriod / currentData.length).toFixed(1) : 0;
    
    // Calculate trend
    let trendText = '-';
    if (currentData.length >= 2) {
        const firstHalf = currentData.slice(0, Math.floor(currentData.length / 2));
        const secondHalf = currentData.slice(Math.floor(currentData.length / 2));
        const firstAvg = firstHalf.reduce((sum, d) => sum + d.count, 0) / firstHalf.length;
        const secondAvg = secondHalf.reduce((sum, d) => sum + d.count, 0) / secondHalf.length;
        
        if (secondAvg > firstAvg * 1.1) {
            trendText = '📈 Naik';
        } else if (secondAvg < firstAvg * 0.9) {
            trendText = '📉 Turun';
        } else {
            trendText = '➡️ Stabil';
        }
    }
    
    // Update info
    document.getElementById('totalInPeriod').textContent = totalInPeriod;
    document.getElementById('avgPerDay').textContent = avgPerDay;
    document.getElementById('trendIndicator').textContent = trendText;
    
    currentChart = new Chart(document.getElementById('trenChart'), {
        type: currentType,
        data: {
            labels: currentData.map(d => d.date),
            datasets: [{
                label: 'Pendaftar per Hari',
                data: currentData.map(d => d.count),
                borderColor: '#6c757d',
                backgroundColor: currentType === 'line' ? 'rgba(108, 117, 125, 0.1)' : '#6c757d',
                tension: currentType === 'line' ? 0.3 : 0,
                fill: currentType === 'line'
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
                        stepSize: 1
                    }
                }
            }
        }
    });
}

// Period filter handlers
document.querySelectorAll('input[name="periodFilter"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value === 'mingguan') {
            currentData = trenMingguan;
            document.getElementById('currentPeriod').textContent = '7 Hari Terakhir';
        } else if (this.value === 'bulanan') {
            currentData = trenBulanan;
            document.getElementById('currentPeriod').textContent = '30 Hari Terakhir';
        } else if (this.value === 'seluruhPeriode') {
            currentData = trenSeluruhPeriode;
            document.getElementById('currentPeriod').textContent = 'Seluruh Periode PPDB';
        }
        updateTrenChart();
    });
});

// Chart type handlers
document.querySelectorAll('input[name="chartType"]').forEach(radio => {
    radio.addEventListener('change', function() {
        currentType = this.value;
        updateTrenChart();
    });
});

// Initialize chart
updateTrenChart();

// Status Distribution Chart
const statusData = @json($statusDistribution);
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData),
        datasets: [{
            data: Object.values(statusData),
            backgroundColor: ['#495057', '#6c757d', '#adb5bd', '#ced4da', '#dee2e6']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});

// Wilayah Chart
const wilayahData = @json($distribusiWilayah);

// Check if data exists
if (wilayahData && wilayahData.length > 0) {
    new Chart(document.getElementById('wilayahChart'), {
        type: 'bar',
        data: {
            labels: wilayahData.map(w => w.wilayah),
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: wilayahData.map(w => w.jumlah),
                backgroundColor: '#6c757d'
            }]
        },
        options: {
            responsive: true,
            plugins: { 
                legend: { display: false },
                title: { 
                    display: true, 
                    text: 'Distribusi Wilayah Pendaftar' 
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
} else {
    // Show message when no data
    document.getElementById('wilayahChart').parentElement.innerHTML = `
        <div class="text-center py-4">
            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada data distribusi wilayah</p>
            <small class="text-muted">Data akan muncul setelah ada pendaftar yang mengisi wilayah</small>
        </div>
    `;
}

function printSummary() {
    const printContent = `
        <div style="font-family: Arial, sans-serif; padding: 20px;">
            <h1 style="text-align: center; color: #333;">Laporan Ringkasan PPDB</h1>
            <h2 style="text-align: center; color: #666;">SMK BaktiNusantara 666</h2>
            <p style="text-align: center;">Tanggal: ${new Date().toLocaleDateString('id-ID')}</p>
            <hr>
            
            <h3>Ringkasan Cepat</h3>
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr style="background: #f8f9fa;">
                    <td style="border: 1px solid #ddd; padding: 10px;"><strong>Pendaftar Hari Ini</strong></td>
                    <td style="border: 1px solid #ddd; padding: 10px;">{{ $pendaftarHariIni }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 10px;"><strong>Total Pendaftar</strong></td>
                    <td style="border: 1px solid #ddd; padding: 10px;">{{ $totalPendaftar }}</td>
                </tr>
                <tr style="background: #f8f9fa;">
                    <td style="border: 1px solid #ddd; padding: 10px;"><strong>Lulus Verifikasi Admin</strong></td>
                    <td style="border: 1px solid #ddd; padding: 10px;">{{ $lulusVerifikasiAdmin }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 10px;"><strong>Sudah Bayar</strong></td>
                    <td style="border: 1px solid #ddd; padding: 10px;">{{ $sudahBayar }}</td>
                </tr>
                <tr style="background: #f8f9fa;">
                    <td style="border: 1px solid #ddd; padding: 10px;"><strong>Diterima</strong></td>
                    <td style="border: 1px solid #ddd; padding: 10px;">{{ $diterima }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 10px;"><strong>Cadangan</strong></td>
                    <td style="border: 1px solid #ddd; padding: 10px;">{{ $cadangan }}</td>
                </tr>
                <tr style="background: #f8f9fa;">
                    <td style="border: 1px solid #ddd; padding: 10px;"><strong>Tidak Lulus</strong></td>
                    <td style="border: 1px solid #ddd; padding: 10px;">{{ $tidakLulus }}</td>
                </tr>
            </table>
            
            <h3>Performance per Jurusan</h3>
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <thead>
                    <tr style="background: #343a40; color: white;">
                        <th style="border: 1px solid #ddd; padding: 10px;">Jurusan</th>
                        <th style="border: 1px solid #ddd; padding: 10px;">Pendaftar</th>
                        <th style="border: 1px solid #ddd; padding: 10px;">Kuota</th>
                        <th style="border: 1px solid #ddd; padding: 10px;">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurusanStats as $jurusan)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 10px;">{{ $jurusan['nama'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 10px;">{{ $jurusan['pendaftar'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 10px;">{{ $jurusan['kuota'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 10px;">{{ $jurusan['persentase'] }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    `;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.print();
}

function printDetailed() {
    window.open('{{ route("admin.reports", ["type" => "detailed"]) }}', '_blank');
}

function printAnalytics() {
    window.open('{{ route("admin.reports", ["type" => "analytics"]) }}', '_blank');
}

function exportData() {
    // Redirect to export endpoint
    window.location.href = '{{ route("admin.export") }}';
}
</script>
@endsection