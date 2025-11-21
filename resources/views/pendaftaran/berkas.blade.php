<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Berkas - PPDB SMK BaktiNusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .berkas-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
            margin: 2rem 0;
        }
        .berkas-header {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .berkas-body {
            padding: 2rem;
        }
        .navbar {
            background: rgba(255,255,255,0.95) !important;
            backdrop-filter: blur(10px);
        }
        .navbar-brand {
            color: #667eea !important;
            font-weight: bold;
        }
        .upload-area {
            border: 2px dashed #667eea;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }
        .upload-area:hover {
            border-color: #5a6fd8;
            background-color: #f8f9ff;
        }
        .file-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid #28a745;
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
            <div class="col-lg-10">
                <div class="berkas-container">
                    <div class="berkas-header">
                        <h2 class="mb-0"><i class="fas fa-upload me-2"></i>Upload Berkas Pendaftaran</h2>
                        <p class="mb-0 mt-2">No. Pendaftaran: <strong>{{ $pendaftar->no_pendaftaran }}</strong></p>
                        <p class="mb-0">Nama: <strong>{{ $pendaftar->dataSiswa?->nama }}</strong></p>
                    </div>

                    <div class="berkas-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Upload Form -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-cloud-upload-alt me-2"></i>Upload Berkas Baru</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('berkas.store', $pendaftar->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jenis Berkas *</label>
                                            <select name="jenis_berkas" class="form-select" required>
                                                <option value="">-- Pilih Jenis Berkas --</option>
                                                <option value="ijazah">Ijazah/SKHUN</option>
                                                <option value="rapor">Rapor Semester Terakhir</option>
                                                <option value="kip_kks">KIP/KKS</option>
                                                <option value="akta_kelahiran">Akta Kelahiran</option>
                                                <option value="kartu_keluarga">Kartu Keluarga</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">File Berkas *</label>
                                            <input type="file" name="file_berkas" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                            <div class="form-text">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Format: PDF, JPG, PNG. Maksimal 2MB
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload me-1"></i>Upload Berkas
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Berkas yang Sudah Diupload -->
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-folder-open me-2"></i>Berkas yang Sudah Diupload</h5>
                            </div>
                            <div class="card-body">
                                @if($pendaftar->berkas && $pendaftar->berkas->count() > 0)
                                    @foreach($pendaftar->berkas as $berkas)
                                        <div class="file-item">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-file-pdf fa-2x text-danger me-3"></i>
                                                        <div>
                                                            <div class="fw-bold">{{ $berkas->nama_berkas }}</div>
                                                            <small class="text-muted">
                                                                {{ number_format($berkas->ukuran_file / 1024, 2) }} KB • 
                                                                {{ $berkas->created_at->format('d/m/Y H:i') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <a href="{{ Storage::url($berkas->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                    <a href="{{ Storage::url($berkas->file_path) }}" download class="btn btn-sm btn-outline-success me-2">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                    <form action="{{ route('berkas.destroy', $berkas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus berkas ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                                        <h6 class="text-gray-600">Belum Ada Berkas</h6>
                                        <p class="text-muted">Upload berkas pendukung untuk melengkapi pendaftaran Anda.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Informasi Berkas -->
                        <div class="alert alert-info mt-4">
                            <h6><i class="fas fa-info-circle me-2"></i>Informasi Upload Berkas:</h6>
                            <ul class="mb-0">
                                <li><strong>Format yang diterima:</strong> PDF, JPG, JPEG, PNG</li>
                                <li><strong>Ukuran maksimal:</strong> 2MB per file</li>
                                <li><strong>Berkas wajib:</strong> Ijazah/SKHUN, Rapor, Akta Kelahiran, Kartu Keluarga</li>
                                <li><strong>Berkas opsional:</strong> KIP/KKS (jika ada)</li>
                                <li><strong>Catatan:</strong> Pastikan berkas jelas dan dapat dibaca</li>
                            </ul>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('pendaftaran.cek') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Status
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>