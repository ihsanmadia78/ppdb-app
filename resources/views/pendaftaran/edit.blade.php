<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pendaftaran - PPDB SMK BaktiNusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
            margin: 2rem 0;
        }
        .form-header {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .form-body {
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
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: #667eea;
            border: none;
        }
        .btn-primary:hover {
            background: #5a6fd8;
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
                <div class="form-container">
                    <div class="form-header">
                        <h2 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Data Pendaftaran</h2>
                        <p class="mb-0 mt-2">No. Pendaftaran: <strong>{{ $pendaftar->no_pendaftaran }}</strong></p>
                    </div>

                    <div class="form-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Perhatian:</strong> Data hanya dapat diubah selama status masih "Menunggu Verifikasi".
                        </div>

                        <form method="POST" action="{{ route('pendaftaran.update', $pendaftar->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <!-- Data Pribadi -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Data Pribadi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i class="fas fa-user me-1"></i>Nama Lengkap *</label>
                                            <input type="text" name="nama" class="form-control" 
                                                   value="{{ old('nama', $pendaftar->dataSiswa?->nama) }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i class="fas fa-id-card me-1"></i>NISN</label>
                                            <input type="text" name="nisn" class="form-control" 
                                                   value="{{ old('nisn', $pendaftar->dataSiswa?->nisn) }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label"><i class="fas fa-venus-mars me-1"></i>Jenis Kelamin *</label>
                                            <select name="jk" class="form-select" required>
                                                <option value="">-- Pilih --</option>
                                                <option value="L" {{ old('jk', $pendaftar->dataSiswa?->jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ old('jk', $pendaftar->dataSiswa?->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Tempat Lahir</label>
                                            <input type="text" name="tmp_lahir" class="form-control" 
                                                   value="{{ old('tmp_lahir', $pendaftar->dataSiswa?->tmp_lahir) }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label"><i class="fas fa-calendar me-1"></i>Tanggal Lahir</label>
                                            <input type="date" name="tgl_lahir" class="form-control" 
                                                   value="{{ old('tgl_lahir', $pendaftar->dataSiswa?->tgl_lahir) }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"><i class="fas fa-home me-1"></i>Alamat Lengkap</label>
                                        <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $pendaftar->dataSiswa?->alamat) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Orang Tua -->
                            <div class="card mb-4">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>Data Orang Tua/Wali</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i class="fas fa-user me-1"></i>Nama Ayah</label>
                                            <input type="text" name="nama_ayah" class="form-control" 
                                                   value="{{ old('nama_ayah', $pendaftar->dataSiswa?->nama_ayah) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i class="fas fa-user me-1"></i>Nama Ibu</label>
                                            <input type="text" name="nama_ibu" class="form-control" 
                                                   value="{{ old('nama_ibu', $pendaftar->dataSiswa?->nama_ibu) }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i class="fas fa-phone me-1"></i>No. Telepon Orang Tua</label>
                                            <input type="tel" name="telp_ortu" class="form-control" 
                                                   value="{{ old('telp_ortu', $pendaftar->dataSiswa?->telp_ortu) }}" placeholder="08xxxxxxxxxx">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i class="fas fa-briefcase me-1"></i>Pekerjaan Orang Tua</label>
                                            <input type="text" name="pekerjaan_ortu" class="form-control" 
                                                   value="{{ old('pekerjaan_ortu', $pendaftar->dataSiswa?->pekerjaan_ortu) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pilihan Pendaftaran -->
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Pilihan Pendaftaran</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i class="fas fa-book me-1"></i>Pilih Jurusan *</label>
                                            <select name="jurusan_id" class="form-select" required>
                                                <option value="">-- Pilih Jurusan --</option>
                                                @foreach($jurusan as $j)
                                                <option value="{{ $j->id }}" 
                                                        {{ old('jurusan_id', $pendaftar->jurusan_id) == $j->id ? 'selected' : '' }}>
                                                    {{ $j->nama }} ({{ $j->kode }})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label"><i class="fas fa-calendar-alt me-1"></i>Pilih Gelombang *</label>
                                            <select name="gelombang_id" class="form-select" required>
                                                <option value="">-- Pilih Gelombang --</option>
                                                @foreach($gelombang as $g)
                                                <option value="{{ $g->id }}" 
                                                        {{ old('gelombang_id', $pendaftar->gelombang_id) == $g->id ? 'selected' : '' }}>
                                                    {{ $g->nama }} - {{ $g->tahun }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('pendaftaran.cek') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>