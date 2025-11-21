<?php $__env->startSection('title', 'Laporan Keuangan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    <!-- HEADER SECTION -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">📈 Laporan Keuangan PPDB</h1>
            <p class="text-muted mb-0">Rekapitulasi lengkap pemasukan dan pembayaran - <?php echo e(date('d F Y')); ?></p>
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
            <form method="GET" action="<?php echo e(route('keuangan.laporan')); ?>" id="filterForm">
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-3">
                        <label class="form-label fw-bold">📅 Periode Tanggal</label>
                        <div class="input-group">
                            <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from', date('Y-m-01'))); ?>">
                            <span class="input-group-text">s/d</span>
                            <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to', date('Y-m-d'))); ?>">
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <label class="form-label fw-bold">🎓 Filter Jurusan</label>
                        <select name="jurusan_id" class="form-select">
                            <option value="">Semua Jurusan</option>
                            <?php $__currentLoopData = \App\Models\Jurusan::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($j->id); ?>" <?php echo e(request('jurusan_id') == $j->id ? 'selected' : ''); ?>>
                                <?php echo e($j->kode); ?> - <?php echo e($j->nama); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-3">
                        <label class="form-label fw-bold">🌊 Filter Gelombang</label>
                        <select name="gelombang_id" class="form-select">
                            <option value="">Semua Gelombang</option>
                            <?php $__currentLoopData = \App\Models\Gelombang::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($g->id); ?>" <?php echo e(request('gelombang_id') == $g->id ? 'selected' : ''); ?>>
                                <?php echo e($g->nama); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?php echo e(number_format($totalPeriode ?? 0, 0, ',', '.')); ?></div>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($jumlahSudahBayar ?? 0); ?></div>
                                    <div class="text-xs text-muted">dari <?php echo e($totalPendaftar ?? 0); ?> pendaftar</div>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($jumlahBelumBayar ?? 0); ?></div>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalTransaksi ?? 0); ?></div>
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
                        <?php if(isset($pemasukanPerJurusan) && count($pemasukanPerJurusan) > 0): ?>
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
                                        <?php $__currentLoopData = $pemasukanPerJurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jurusan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><strong><?php echo e($jurusan->kode); ?></strong></td>
                                            <td><span class="badge bg-info"><?php echo e($jurusan->jumlah ?? 0); ?></span></td>
                                            <td><span class="badge bg-success">Rp <?php echo e(number_format($jurusan->total, 0, ',', '.')); ?></span></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
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
                        <?php if(isset($pemasukanPerGelombang) && count($pemasukanPerGelombang) > 0): ?>
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
                                        <?php $__currentLoopData = $pemasukanPerGelombang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gelombang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><strong><?php echo e($gelombang->nama); ?></strong></td>
                                            <td><span class="badge bg-info"><?php echo e($gelombang->jumlah ?? 0); ?></span></td>
                                            <td><span class="badge bg-success">Rp <?php echo e(number_format($gelombang->total, 0, ',', '.')); ?></span></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 4: DAFTAR SISWA SUDAH BAYAR -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">✅ Daftar Siswa yang Sudah Bayar</h6>
            <span class="badge bg-success fs-6"><?php echo e(isset($siswasSudahBayar) ? $siswasSudahBayar->count() : 0); ?> siswa</span>
        </div>
        <div class="card-body">
            <?php if(isset($siswasSudahBayar) && $siswasSudahBayar->count() > 0): ?>
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
                        <?php $__currentLoopData = $siswasSudahBayar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $siswa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                            <td><span class="badge bg-info"><?php echo e($siswa->pendaftar->no_pendaftaran); ?></span></td>
                            <td class="fw-bold"><?php echo e($siswa->pendaftar->dataSiswa->nama ?? '-'); ?></td>
                            <td><span class="badge bg-secondary"><?php echo e($siswa->pendaftar->jurusan->kode ?? '-'); ?></span></td>
                            <td><span class="badge bg-dark text-white"><?php echo e($siswa->pendaftar->gelombang->nama ?? '-'); ?></span></td>
                            <td class="fw-bold text-success">Rp <?php echo e(number_format($siswa->nominal, 0, ',', '.')); ?></td>
                            <td><?php echo e($siswa->verified_at ? $siswa->verified_at->format('d/m/Y H:i') : '-'); ?></td>
                            <td><span class="badge bg-success">✅ Lunas</span></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="table-success">
                        <tr>
                            <th colspan="5" class="text-end">Total Pemasukan:</th>
                            <th class="fw-bold">Rp <?php echo e(number_format($siswasSudahBayar->sum('nominal'), 0, ',', '.')); ?></th>
                            <th colspan="2"><?php echo e($siswasSudahBayar->count()); ?> transaksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-money-bill-wave fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-600">Belum Ada Pembayaran</h5>
                <p class="text-muted">Belum ada siswa yang melakukan pembayaran pada periode ini.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- SECTION 5: DAFTAR SISWA BELUM BAYAR -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">⏰ Daftar Siswa yang Belum Bayar</h6>
            <span class="badge bg-warning text-dark fs-6"><?php echo e(isset($siswasBelumBayar) ? $siswasBelumBayar->count() : 0); ?> siswa</span>
        </div>
        <div class="card-body">
            <?php if(isset($siswasBelumBayar) && $siswasBelumBayar->count() > 0): ?>
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
                        <?php $__currentLoopData = $siswasBelumBayar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $siswa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                            <td><span class="badge bg-info"><?php echo e($siswa->no_pendaftaran); ?></span></td>
                            <td class="fw-bold"><?php echo e($siswa->dataSiswa->nama ?? '-'); ?></td>
                            <td><span class="badge bg-secondary"><?php echo e($siswa->jurusan->kode ?? '-'); ?></span></td>
                            <td><span class="badge bg-dark text-white"><?php echo e($siswa->gelombang->nama ?? '-'); ?></span></td>
                            <td><?php echo e($siswa->email ?? '-'); ?></td>
                            <td><?php echo e($siswa->dataSiswa->telp_ortu ?? '-'); ?></td>
                            <td><span class="badge bg-warning text-dark">⏰ Belum</span></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="table-warning">
                        <tr>
                            <th colspan="7" class="text-end">Total Siswa Belum Bayar:</th>
                            <th><?php echo e($siswasBelumBayar->count()); ?> siswa</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h5 class="text-success">Semua Siswa Sudah Bayar!</h5>
                <p class="text-muted">Tidak ada siswa yang belum melakukan pembayaran pada periode ini.</p>
            </div>
            <?php endif; ?>
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
const pemasukanJurusan = <?php echo json_encode($pemasukanPerJurusan ?? [], 15, 512) ?>;
const pemasukanGelombang = <?php echo json_encode($pemasukanPerGelombang ?? [], 15, 512) ?>;

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
    window.location.href = '<?php echo e(route("keuangan.laporan")); ?>?' + params.toString();
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/keuangan/laporan.blade.php ENDPATH**/ ?>