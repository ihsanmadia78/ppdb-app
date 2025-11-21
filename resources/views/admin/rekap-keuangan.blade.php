@extends('layouts.app')

@section('title', 'Rekap Keuangan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Rekap Keuangan PPDB</h1>
                <div>
                    <a href="{{ route('admin.export-keuangan', ['format' => 'excel']) }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('admin.export-keuangan', ['format' => 'pdf']) }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Penerimaan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-success shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Penerimaan</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Rekap Per Jurusan -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Penerimaan Per Jurusan</h6>
                </div>
                <div class="card-body">
                    @if($perJurusan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Jurusan</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($perJurusan as $j)
                                <tr>
                                    <td>{{ $j->nama }}</td>
                                    <td>{{ $j->jumlah }} siswa</td>
                                    <td>Rp {{ number_format($j->total, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted text-center">Belum ada data pembayaran</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Rekap Per Gelombang -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Penerimaan Per Gelombang</h6>
                </div>
                <div class="card-body">
                    @if($perGelombang->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Gelombang</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($perGelombang as $g)
                                <tr>
                                    <td>{{ $g->nama }}</td>
                                    <td>{{ $g->jumlah }} siswa</td>
                                    <td>Rp {{ number_format($g->total, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted text-center">Belum ada data pembayaran</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Visualization -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Per Jurusan</h6>
                </div>
                <div class="card-body">
                    <canvas id="jurusanChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Per Gelombang</h6>
                </div>
                <div class="card-body">
                    <canvas id="gelombangChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart Per Jurusan
const jurusanCtx = document.getElementById('jurusanChart').getContext('2d');
new Chart(jurusanCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($perJurusan->pluck('nama')) !!},
        datasets: [{
            data: {!! json_encode($perJurusan->pluck('total')) !!},
            backgroundColor: [
                '#4e73df',
                '#1cc88a', 
                '#36b9cc',
                '#f6c23e',
                '#e74a3b'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Chart Per Gelombang
const gelombangCtx = document.getElementById('gelombangChart').getContext('2d');
new Chart(gelombangCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($perGelombang->pluck('nama')) !!},
        datasets: [{
            label: 'Total Penerimaan',
            data: {!! json_encode($perGelombang->pluck('total')) !!},
            backgroundColor: '#1cc88a'
        }]
    },
    options: {
        responsive: true,
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
</script>
@endsection