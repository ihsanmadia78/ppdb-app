<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftaran - PPDB SMK BaktiNusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .success-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
            margin: 2rem 0;
        }
        .success-header {
            background: linear-gradient(45deg, #495057, #6c757d);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .success-body {
            padding: 2rem;
        }
        .navbar {
            background: rgba(255,255,255,0.95) !important;
            backdrop-filter: blur(10px);
        }
        .navbar-brand {
            color: #495057 !important;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-graduation-cap me-2"></i>PPDB SMK BaktiNusantara 666
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                <a class="nav-link" href="{{ route('pendaftaran.cek') }}">Cek Status</a>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-container">
                    <div class="success-header">
                        <i class="fas fa-check-circle fa-3x mb-3"></i>
                        <h2 class="mb-0">Pendaftaran Berhasil!</h2>
                        <p class="mb-0 mt-2">Terima kasih telah mendaftar di PPDB SMK BaktiNusantara 666</p>
                    </div>

                    <div class="success-body">
                        @if ($pendaftar)
                            <div class="alert alert-success">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Pendaftaran Anda telah berhasil disimpan!</strong><br>
                                Silakan simpan nomor pendaftaran di bawah ini untuk cek status.
                            </div>

                            <!-- Data Pribadi -->
                            <div class="card border-primary mb-3">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Data Pribadi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <td width="40%"><strong>No. Pendaftaran:</strong></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-info fs-6 me-2" id="noPendaftaran">{{ $pendaftar->no_pendaftaran }}</span>
                                                            <button class="btn btn-sm btn-outline-primary" onclick="copyNoPendaftaran()" title="Salin Nomor Pendaftaran">
                                                                <i class="fas fa-copy"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Nama Lengkap:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->nama ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>NIK:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->nik ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>NISN:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->nisn ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Jenis Kelamin:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <td width="40%"><strong>Tempat, Tgl Lahir:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->tmp_lahir ?? '-' }}, {{ $pendaftar->dataSiswa?->tgl_lahir ? \Carbon\Carbon::parse($pendaftar->dataSiswa->tgl_lahir)->format('d/m/Y') : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Agama:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->agama ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Email:</strong></td>
                                                    <td>{{ $pendaftar->email ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Nama Sekolah:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->nama_sekolah_asal ?? '-' }}</td>
                                                </tr>
                                                @if($pendaftar->dataSiswa?->npsn_sekolah)
                                                <tr>
                                                    <td><strong>NPSN Sekolah:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa->npsn_sekolah }}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td><strong>Kabupaten Sekolah:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->kabupaten_sekolah ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Nilai Rata-rata:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->nilai_rata_rata ? number_format($pendaftar->dataSiswa->nilai_rata_rata, 2) : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tanggal Daftar:</strong></td>
                                                    <td>{{ $pendaftar->created_at->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Alamat -->
                            <div class="card border-secondary mb-3">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Data Alamat</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <td width="40%"><strong>Alamat Lengkap:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->alamat ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Kelurahan/Desa:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->kelurahan ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Kecamatan:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->kecamatan ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <td width="40%"><strong>Kabupaten/Kota:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->kabupaten ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Provinsi:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->provinsi ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Kode Pos:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->kode_pos ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Orang Tua -->
                            <div class="card border-info mb-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Data Orang Tua</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-primary mb-2"><i class="fas fa-male me-1"></i> Data Ayah</h6>
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <td width="40%"><strong>Nama Ayah:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->nama_ayah ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Pekerjaan:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->pekerjaan_ayah ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>No. HP:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->hp_ayah ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-success mb-2"><i class="fas fa-female me-1"></i> Data Ibu</h6>
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <td width="40%"><strong>Nama Ibu:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->nama_ibu ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Pekerjaan:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->pekerjaan_ibu ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>No. HP:</strong></td>
                                                    <td>{{ $pendaftar->dataSiswa?->hp_ibu ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Pendaftaran -->
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Data Pendaftaran</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <td width="40%"><strong>Jurusan Pilihan:</strong></td>
                                                    <td><span class="badge bg-secondary">{{ $pendaftar->jurusan?->nama ?? '-' }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Gelombang:</strong></td>
                                                    <td>{{ $pendaftar->gelombang?->nama ?? '-' }} ({{ $pendaftar->gelombang?->tahun ?? '-' }})</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Biaya Pendaftaran:</strong></td>
                                                    <td class="fw-bold text-success">Rp {{ number_format($pendaftar->gelombang?->biaya_daftar ?? 0, 0, ',', '.') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <td width="40%"><strong>Status:</strong></td>
                                                    <td>
                                                        @if($pendaftar->status == 'SUBMIT')
                                                            <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Menunggu Verifikasi</span>
                                                        @elseif($pendaftar->status == 'LULUS')
                                                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Diterima</span>
                                                        @elseif($pendaftar->status == 'TIDAK_LULUS')
                                                            <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Ditolak</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ $pendaftar->status }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Berkas Upload:</strong></td>
                                                    <td><span class="badge bg-info">{{ $pendaftar->berkas->count() }} berkas</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning mt-4">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Langkah Selanjutnya:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Simpan nomor pendaftaran: 
                                        <strong class="text-primary">{{ $pendaftar->no_pendaftaran }}</strong>
                                        <button class="btn btn-sm btn-link p-0 ms-1" onclick="copyNoPendaftaran()" title="Salin">
                                            <i class="fas fa-copy text-primary"></i>
                                        </button>
                                    </li>
                                    <li>Gunakan nomor tersebut untuk cek status pendaftaran</li>
                                    <li>Tunggu proses verifikasi dari admin sekolah</li>
                                    <li>Cek status secara berkala untuk mengetahui hasil verifikasi</li>
                                </ul>
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('pendaftaran.cek') }}" class="btn btn-dark btn-lg me-2">
                                    <i class="fas fa-search me-1"></i>Cek Status
                                </a>
                                <button class="btn btn-outline-dark btn-lg" onclick="window.print()">
                                    <i class="fas fa-print me-1"></i>Cetak
                                </button>
                            </div>
                        @else
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                <h5>Data Tidak Ditemukan</h5>
                                <p>Belum ada data pendaftaran yang ditemukan.</p>
                                <a href="{{ route('pendaftaran.create') }}" class="btn btn-dark">
                                    <i class="fas fa-user-plus me-1"></i>Daftar Sekarang
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyNoPendaftaran() {
            const noPendaftaran = '{{ $pendaftar->no_pendaftaran ?? "" }}';
            
            // Copy to clipboard
            navigator.clipboard.writeText(noPendaftaran).then(function() {
                // Show success message
                showCopySuccess();
            }).catch(function(err) {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = noPendaftaran;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showCopySuccess();
            });
        }
        
        function showCopySuccess() {
            // Create temporary success message
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
            alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alert.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                <strong>Berhasil!</strong> Nomor pendaftaran telah disalin.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(alert);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 3000);
        }
    </script>
</body>
</html>
