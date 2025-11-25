

<?php $__env->startSection('title', 'Peta Lokasi Pendaftar'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-map-marker-alt me-2"></i>Koordinat Lokasi Pendaftar</h1>
            <p class="text-muted mb-0">Visualisasi sebaran lokasi pendaftar PPDB (<?php echo e($pendaftar->count()); ?> lokasi)</p>
        </div>
        <a href="<?php echo e(route('admin.pendaftar')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">📍 Sebaran Lokasi Pendaftar</h6>
        </div>
        <div class="card-body p-0">
            <div id="map" style="height: 600px;"></div>
        </div>
    </div>

    <!-- Legend -->
    <div class="card shadow mt-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="font-weight-bold">📊 Statistik Pendaftar:</h6>
                    <ul class="list-unstyled mb-0">
                        <li><i class="fas fa-map-marker-alt text-primary me-2"></i>Dengan Koordinat: <strong><?php echo e($pendaftar->count()); ?></strong></li>
                        <li><i class="fas fa-users text-secondary me-2"></i>Total Pendaftar: <strong><?php echo e(\App\Models\Pendaftar::count()); ?></strong></li>
                        <li><i class="fas fa-users text-success me-2"></i>Lulus: <strong><?php echo e(\App\Models\Pendaftar::where('status', 'LULUS')->count()); ?></strong></li>
                        <li><i class="fas fa-clock text-warning me-2"></i>Proses: <strong><?php echo e(\App\Models\Pendaftar::whereIn('status', ['SUBMIT', 'VERIFIKASI_BERKAS', 'MENUNGGU_PEMBAYARAN', 'SIAP_SELEKSI'])->count()); ?></strong></li>
                        <li><i class="fas fa-times text-danger me-2"></i>Tidak Lulus: <strong><?php echo e(\App\Models\Pendaftar::where('status', 'TIDAK_LULUS')->count()); ?></strong></li>
                        <li><i class="fas fa-list text-info me-2"></i>Cadangan: <strong><?php echo e(\App\Models\Pendaftar::where('status', 'CADANGAN')->count()); ?></strong></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="font-weight-bold">🎯 Keterangan Marker:</h6>
                    <ul class="list-unstyled mb-0">
                        <li><i class="fas fa-circle text-primary me-2"></i>Biru: Pendaftar Baru (SUBMIT)</li>
                        <li><i class="fas fa-circle text-info me-2"></i>Cyan: Verifikasi Berkas</li>
                        <li><i class="fas fa-circle text-warning me-2"></i>Orange: Menunggu/Siap Seleksi</li>
                        <li><i class="fas fa-circle text-success me-2"></i>Hijau: Lulus</li>
                        <li><i class="fas fa-circle text-danger me-2"></i>Merah: Tidak Lulus</li>
                        <li><i class="fas fa-circle text-secondary me-2"></i>Abu: Cadangan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Initialize map centered on Indonesia
    const map = L.map('map').setView([-2.5, 118], 5);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Add markers for each applicant
    const markers = [];
    const pendaftarData = <?php echo json_encode($pendaftar->map(function($p) {
        $alamat = $p->dataSiswa->alamat ?? '-';
        $fullAlamat = trim(($p->dataSiswa->alamat ?? '') . ', ' . 
                          ($p->dataSiswa->kelurahan ?? '') . ', ' . 
                          ($p->dataSiswa->kecamatan ?? '') . ', ' . 
                          ($p->dataSiswa->kabupaten ?? '') . ', ' . 
                          ($p->dataSiswa->provinsi ?? ''), ', ');
        return [
            'id' => $p->id,
            'lat' => floatval($p->dataSiswa->lat ?? 0),
            'lng' => floatval($p->dataSiswa->lng ?? 0),
            'nama' => $p->dataSiswa->nama ?? '-',
            'no_pendaftaran' => $p->no_pendaftaran ?? 'N/A',
            'jurusan' => $p->jurusan->nama ?? '-',
            'alamat' => strlen($alamat) > 50 ? substr($alamat, 0, 50) . '...' : $alamat,
            'alamat_lengkap' => $fullAlamat,
            'status' => $p->status ?? 'SUBMIT',
            'tanggal_daftar' => $p->created_at ? $p->created_at->format('d/m/Y H:i') : '-',
            'detail_url' => route('admin.show', $p->id)
        ];
    })); ?>;
    
    pendaftarData.forEach(function(p) {
        if (p.lat && p.lng && !isNaN(p.lat) && !isNaN(p.lng) && p.lat != 0 && p.lng != 0) {
            // Determine marker color based on status
            let markerColor = 'blue';
            let statusBadge = 'secondary';
            switch(p.status) {
                case 'LULUS':
                    markerColor = 'green';
                    statusBadge = 'success';
                    break;
                case 'TIDAK_LULUS':
                    markerColor = 'red';
                    statusBadge = 'danger';
                    break;
                case 'CADANGAN':
                    markerColor = 'gray';
                    statusBadge = 'secondary';
                    break;
                case 'VERIFIKASI_BERKAS':
                    markerColor = 'lightblue';
                    statusBadge = 'info';
                    break;
                case 'MENUNGGU_PEMBAYARAN':
                case 'SIAP_SELEKSI':
                    markerColor = 'orange';
                    statusBadge = 'warning';
                    break;
                case 'BERKAS_DITOLAK':
                case 'PEMBAYARAN_DITOLAK':
                    markerColor = 'darkred';
                    statusBadge = 'danger';
                    break;
                case 'SUBMIT':
                default:
                    markerColor = 'blue';
                    statusBadge = 'primary';
            }
            
            const marker = L.marker([parseFloat(p.lat), parseFloat(p.lng)])
                .addTo(map)
                .bindPopup(`
                    <div style="min-width: 250px;">
                        <h6 class="mb-2"><strong>👤 ${p.nama || 'Nama tidak tersedia'}</strong></h6>
                        <p class="mb-1"><small><strong>📋 No. Pendaftaran:</strong> ${p.no_pendaftaran || 'N/A'}</small></p>
                        <p class="mb-1"><small><strong>🎓 Jurusan:</strong> ${p.jurusan || 'Belum dipilih'}</small></p>
                        <p class="mb-1"><small><strong>📅 Tanggal Daftar:</strong> ${p.tanggal_daftar || '-'}</small></p>
                        <p class="mb-1"><small><strong>📍 Status:</strong> <span class="badge bg-${statusBadge}">${p.status || 'SUBMIT'}</span></small></p>
                        <p class="mb-1"><small><strong>🏠 Alamat:</strong> ${p.alamat_lengkap || p.alamat || 'Alamat tidak tersedia'}</small></p>
                        <p class="mb-2"><small><strong>🗺️ Koordinat:</strong> ${parseFloat(p.lat).toFixed(6)}, ${parseFloat(p.lng).toFixed(6)}</small></p>
                        <div class="d-flex gap-1">
                            <a href="${p.detail_url}" class="btn btn-sm btn-primary" target="_blank">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <button class="btn btn-sm btn-success" onclick="navigator.clipboard.writeText('${p.lat}, ${p.lng}')">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                    </div>
                `);
            markers.push(marker);
        }
    });
    
    // Fit map to show all markers
    if (markers.length > 0) {
        const group = new L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.1));
        
        // Set minimum zoom level for better visibility
        if (map.getZoom() > 15) {
            map.setZoom(12);
        }
    } else {
        // Default view centered on Indonesia if no markers
        map.setView([-2.5, 118], 5);
        console.log('No markers found - showing default Indonesia view');
    }
    
    console.log('=== PETA PENDAFTAR DEBUG ===');
    console.log('Loaded at:', new Date().toLocaleString());
    console.log('Total markers:', markers.length);
    console.log('Total data:', pendaftarData.length);
    console.log('\nAll pendaftar data:');
    pendaftarData.forEach((p, i) => {
        console.log(`${i+1}. ${p.nama} (${p.no_pendaftaran})`);
        console.log(`   Koordinat: ${p.lat}, ${p.lng}`);
        console.log(`   Status: ${p.status}`);
    });
</script>

<style>
.text-gray-800 { color: #212529 !important; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/admin/peta-pendaftar.blade.php ENDPATH**/ ?>