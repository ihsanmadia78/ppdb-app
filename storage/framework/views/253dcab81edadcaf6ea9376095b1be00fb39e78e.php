

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">📋 Daftar Pendaftar PPDB</h1>
            <p class="text-muted mb-0">Kelola dan pantau semua pendaftar PPDB</p>
        </div>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
                <ul class="dropdown-menu">
                    <li><h6 class="dropdown-header">📊 Export Data</h6></li>
                    <li><a class="dropdown-item" href="<?php echo e(route('admin.export')); ?>">
                        <i class="fas fa-download me-2"></i>Export Semua Data
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="exportSelected()">
                        <i class="fas fa-check-square me-2"></i>Export Data Terpilih
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?php echo e(route('admin.export', ['status' => 'LULUS'])); ?>">
                        <i class="fas fa-check-circle me-2 text-success"></i>Export Diterima
                    </a></li>
                    <li><a class="dropdown-item" href="<?php echo e(route('admin.export', ['status' => 'SUBMIT'])); ?>">
                        <i class="fas fa-clock me-2 text-warning"></i>Export Menunggu
                    </a></li>
                </ul>
            </div>
            <button class="btn btn-outline-secondary btn-sm" onclick="window.open('<?php echo e(route('admin.export')); ?>', '_blank')">
                <i class="fas fa-download"></i> Download Excel
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pendaftar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($pendaftar->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Diterima</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($pendaftar->where('status', 'LULUS')->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($pendaftar->where('status', 'SUBMIT')->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($pendaftar->where('status', 'TIDAK_LULUS')->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
        <div class="collapse show" id="filterCollapse">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cari Nama/No. Pendaftaran</label>
                        <input type="text" class="form-control" id="searchInput" placeholder="Ketik untuk mencari...">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><i class="fas fa-flag me-1"></i>Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">🔍 Semua Status</option>
                            <option value="SUBMIT">⏳ Menunggu Verifikasi</option>
                            <option value="VERIFIKASI_ADMIN">🔍 Sedang Diverifikasi</option>
                            <option value="MENUNGGU_PEMBAYARAN">💳 Menunggu Pembayaran</option>
                            <option value="TERBAYAR">💰 Sudah Bayar</option>
                            <option value="VERIFIKASI_KEUANGAN">🧾 Verifikasi Keuangan</option>
                            <option value="LULUS">✅ Diterima</option>
                            <option value="TIDAK_LULUS">❌ Ditolak</option>
                            <option value="CADANGAN">⏰ Cadangan</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label"><i class="fas fa-graduation-cap me-1"></i>Jurusan</label>
                        <select class="form-select" id="jurusanFilter">
                            <option value="">🎓 Semua Jurusan</option>
                            <?php $__currentLoopData = $pendaftar->pluck('jurusan.nama')->unique()->filter(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jurusan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($jurusan); ?>">
                                    <?php if($jurusan == 'Pengembangan Perangkat Lunak dan Gim'): ?>
                                        💻 <?php echo e($jurusan); ?>

                                    <?php elseif($jurusan == 'Akuntansi dan Keuangan Lembaga'): ?>
                                        📊 <?php echo e($jurusan); ?>

                                    <?php elseif($jurusan == 'Animasi'): ?>
                                        🎬 <?php echo e($jurusan); ?>

                                    <?php elseif($jurusan == 'Pemasaran'): ?>
                                        📈 <?php echo e($jurusan); ?>

                                    <?php elseif($jurusan == 'Desain Komunikasi Visual'): ?>
                                        🎨 <?php echo e($jurusan); ?>

                                    <?php else: ?>
                                        📚 <?php echo e($jurusan); ?>

                                    <?php endif; ?>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Pendaftar</h6>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-secondary" onclick="selectAll()" id="selectAllBtn">
                    <i class="fas fa-check-square"></i> Pilih Semua
                </button>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" id="bulkActionBtn" disabled>
                        <i class="fas fa-tasks"></i> Aksi Bulk
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="bulkUpdateStatus()">Update Status</a></li>
                        <li><a class="dropdown-item" href="#" onclick="bulkExport()">Export Terpilih</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="bulkDelete()">Hapus Terpilih</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if($pendaftar->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th width="3%">
                                    <input type="checkbox" id="masterCheckbox" onchange="toggleAll()">
                                </th>
                                <th width="5%">No</th>
                                <th width="15%">No. Pendaftaran</th>
                                <th width="20%">Nama Lengkap</th>
                                <th width="15%">Jurusan</th>
                                <th width="12%">Gelombang</th>
                                <th width="10%">Status</th>
                                <th width="13%">Tanggal Daftar</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pendaftar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="row-checkbox" value="<?php echo e($p->id); ?>" onchange="updateBulkActions()">
                                    </td>
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td>
                                        <span class="badge bg-info text-dark"><?php echo e($p->no_pendaftaran); ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-gray-600 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold"><?php echo e($p->dataSiswa?->nama ?? '-'); ?></div>
                                                <small class="text-muted">NISN: <?php echo e($p->dataSiswa?->nisn ?? '-'); ?></small><br>
                                                <small class="text-info"><?php echo e($p->dataSiswa?->nama_sekolah_asal ?? '-'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo e($p->jurusan?->nama ?? '-'); ?></span>
                                    </td>
                                    <td><?php echo e($p->gelombang?->nama ?? '-'); ?></td>
                                    <td>
                                        <?php if($p->status == 'SUBMIT'): ?>
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock"></i> Menunggu
                                            </span>
                                        <?php elseif($p->status == 'LULUS'): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Diterima
                                            </span>
                                        <?php elseif($p->status == 'TIDAK_LULUS'): ?>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times"></i> Ditolak
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?php echo e($p->status); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small>
                                            <?php echo e($p->created_at->format('d/m/Y')); ?><br>
                                            <span class="text-muted"><?php echo e($p->created_at->format('H:i')); ?></span>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.show', $p->id)); ?>" class="btn btn-sm btn-outline-secondary" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if($p->status == 'SIAP_SELEKSI'): ?>
                                                <form action="<?php echo e(route('admin.pendaftar.status-akhir', $p->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menerima pendaftar ini?')">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="status" value="LULUS">
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Terima">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="<?php echo e(route('admin.pendaftar.status-akhir', $p->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menolak pendaftar ini?')">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="status" value="TIDAK_LULUS">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Tolak">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                                <form action="<?php echo e(route('admin.pendaftar.status-akhir', $p->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin jadikan cadangan?')">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="status" value="CADANGAN">
                                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Cadangan">
                                                        <i class="fas fa-clock"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Belum Ada Data Pendaftar</h5>
                    <p class="text-muted">Data pendaftar akan muncul di sini setelah ada yang mendaftar.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #6c757d !important;
}
.border-left-success {
    border-left: 0.25rem solid #495057 !important;
}
.border-left-warning {
    border-left: 0.25rem solid #adb5bd !important;
}
.border-left-danger {
    border-left: 0.25rem solid #343a40 !important;
}
.avatar-sm {
    width: 2rem;
    height: 2rem;
    font-size: 0.875rem;
}
.text-gray-800 {
    color: #5a5c69 !important;
}
.text-gray-600 {
    color: #858796 !important;
}
.text-gray-300 {
    color: #dddfeb !important;
}
.form-select {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23495057' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
}
.form-select:focus {
    border-color: #6c757d;
    box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
}
.form-select option {
    padding: 0.75rem;
    font-size: 0.95rem;
    background-color: white;
}
.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const jurusanFilter = document.getElementById('jurusanFilter');
    const tableRows = document.querySelectorAll('#dataTable tbody tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const jurusanValue = jurusanFilter.value;

        tableRows.forEach(row => {
            const nama = row.cells[2].textContent.toLowerCase();
            const noPendaftaran = row.cells[1].textContent.toLowerCase();
            const status = row.cells[5].textContent.trim();
            const jurusan = row.cells[3].textContent.trim();

            const matchesSearch = nama.includes(searchTerm) || noPendaftaran.includes(searchTerm);
            const matchesStatus = !statusValue || 
                (statusValue === 'SUBMIT' && status.includes('Menunggu')) ||
                (statusValue === 'LULUS' && status.includes('Diterima')) ||
                (statusValue === 'TIDAK_LULUS' && status.includes('Ditolak')) ||
                status.includes(statusValue);
            const matchesJurusan = !jurusanValue || jurusan.includes(jurusanValue);

            if (matchesSearch && matchesStatus && matchesJurusan) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    jurusanFilter.addEventListener('change', filterTable);
});

function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('jurusanFilter').value = '';
    
    const tableRows = document.querySelectorAll('#dataTable tbody tr');
    tableRows.forEach(row => {
        row.style.display = '';
    });
}

// Bulk Actions Functions
function toggleAll() {
    const masterCheckbox = document.getElementById('masterCheckbox');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = masterCheckbox.checked;
    });
    
    updateBulkActions();
}

function selectAll() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    const masterCheckbox = document.getElementById('masterCheckbox');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });
    
    masterCheckbox.checked = !allChecked;
    document.getElementById('selectAllBtn').innerHTML = allChecked ? 
        '<i class="fas fa-check-square"></i> Pilih Semua' : 
        '<i class="fas fa-square"></i> Batal Pilih';
    
    updateBulkActions();
}

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const bulkActionBtn = document.getElementById('bulkActionBtn');
    
    if (checkedBoxes.length > 0) {
        bulkActionBtn.disabled = false;
        bulkActionBtn.innerHTML = `<i class="fas fa-tasks"></i> Aksi Bulk (${checkedBoxes.length})`;
    } else {
        bulkActionBtn.disabled = true;
        bulkActionBtn.innerHTML = '<i class="fas fa-tasks"></i> Aksi Bulk';
    }
}

function getSelectedIds() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    return Array.from(checkedBoxes).map(cb => cb.value);
}

function bulkUpdateStatus() {
    const selectedIds = getSelectedIds();
    if (selectedIds.length === 0) {
        alert('Pilih minimal satu pendaftar!');
        return;
    }
    
    const newStatus = prompt('Masukkan status baru (SUBMIT/LULUS/TIDAK_LULUS):');
    if (!newStatus) return;
    
    if (confirm(`Yakin ingin mengubah status ${selectedIds.length} pendaftar ke ${newStatus}?`)) {
        fetch('<?php echo e(route("admin.bulk.update-status")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                pendaftar_ids: selectedIds,
                new_status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
}

function bulkExport() {
    const selectedIds = getSelectedIds();
    if (selectedIds.length === 0) {
        alert('Pilih minimal satu pendaftar!');
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo e(route("admin.bulk.export")); ?>';
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '<?php echo e(csrf_token()); ?>';
    form.appendChild(csrfInput);
    
    selectedIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'pendaftar_ids[]';
        input.value = id;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function bulkDelete() {
    const selectedIds = getSelectedIds();
    if (selectedIds.length === 0) {
        alert('Pilih minimal satu pendaftar!');
        return;
    }
    
    if (confirm(`PERINGATAN: Yakin ingin menghapus ${selectedIds.length} pendaftar? Tindakan ini tidak dapat dibatalkan!`)) {
        fetch('<?php echo e(route("admin.bulk.delete")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                pendaftar_ids: selectedIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
}

function exportSelected() {
    const selectedIds = getSelectedIds();
    if (selectedIds.length === 0) {
        alert('Pilih minimal satu pendaftar!');
        return;
    }
    
    bulkExport();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/admin/pendaftar.blade.php ENDPATH**/ ?>