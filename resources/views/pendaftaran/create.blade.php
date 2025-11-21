<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran PPDB SMK BaktiNusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #212529;
        }
        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #dee2e6;
            overflow: hidden;
            margin: 2rem 0;
        }
        .form-header {
            background: #6c757d;
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .form-body {
            padding: 2rem;
            color: #212529;
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-weight: bold;
        }
        .step.active {
            background: #495057;
            color: white;
        }
        .step.completed {
            background: #6c757d;
            color: white;
        }
        .form-section {
            display: none;
        }
        .form-section.active {
            display: block;
        }
        .section-title {
            color: #495057;
            border-bottom: 2px solid #495057;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .form-control:focus {
            border-color: #6c757d;
            box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
        }
        .btn-primary {
            background: #495057;
            border: none;
        }
        .btn-primary:hover {
            background: #6c757d;
        }
        .navbar {
            background: rgba(248,249,250,0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #dee2e6;
        }
        .navbar-brand {
            color: #495057 !important;
            font-weight: bold;
        }
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .form-select:focus {
            border-color: #6c757d;
            box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
        }
        .form-select option {
            padding: 0.5rem;
            font-size: 0.95rem;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <i class="fas fa-graduation-cap me-2"></i>PPDB SMK BaktiNusantara 666
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('welcome') }}">Beranda</a>
                <a class="nav-link" href="{{ route('pendaftaran.cek') }}">Cek Status</a>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-container">
                    <div class="form-header">
                        <h2 class="mb-0"><i class="fas fa-user-plus me-2"></i>Formulir Pendaftaran PPDB</h2>
                        <p class="mb-0 mt-2">SMK BaktiNusantara 666 - Isi data dengan lengkap dan benar</p>
                    </div>

                    <div class="form-body">
                        <!-- Step Indicator -->
                        <div class="step-indicator">
                            <div class="step active" id="step1">1</div>
                            <div class="step" id="step2">2</div>
                            <div class="step" id="step3">3</div>
                        </div>

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

                        <form method="POST" action="{{ route('pendaftaran.store') }}" id="registrationForm" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Step 1: Data Pribadi -->
                            <div class="form-section active" id="section1">
                                <h4 class="section-title"><i class="fas fa-user me-2"></i>Data Pribadi</h4>
                                
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-user me-1"></i>Nama Lengkap *</label>
                                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" placeholder="Nama lengkap sesuai ijazah" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-id-card me-1"></i>NIK *</label>
                                        <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" placeholder="Nomor Induk Kependudukan (16 digit)" maxlength="16" required>
                                        <small class="text-muted">NIK sesuai KTP/Kartu Keluarga</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-graduation-cap me-1"></i>NISN *</label>
                                        <input type="text" name="nisn" class="form-control" value="{{ old('nisn') }}" placeholder="Nomor Induk Siswa Nasional" required>
                                        <small class="text-muted">NISN harus unik, tidak boleh sama dengan siswa lain</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label"><i class="fas fa-venus-mars me-1"></i>Jenis Kelamin *</label>
                                        <select name="jk" class="form-select" required>
                                            <option value="">🔍 Pilih Jenis Kelamin</option>
                                            <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>👨 Laki-laki</option>
                                            <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>👩 Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Tempat Lahir *</label>
                                        <input type="text" name="tmp_lahir" class="form-control" value="{{ old('tmp_lahir') }}" placeholder="Kota kelahiran" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label"><i class="fas fa-calendar me-1"></i>Tanggal Lahir *</label>
                                        <input type="date" name="tgl_lahir" class="form-control" value="{{ old('tgl_lahir') }}" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label"><i class="fas fa-pray me-1"></i>Agama</label>
                                        <select name="agama" class="form-select">
                                            <option value="">🕌 Pilih Agama</option>
                                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-home me-1"></i>Alamat Lengkap *</label>
                                    <textarea name="alamat" class="form-control" rows="3" placeholder="Jalan, RT/RW, No. Rumah" required>{{ old('alamat') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-map me-1"></i>Provinsi *</label>
                                        <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi') }}" placeholder="Contoh: Jawa Barat" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-city me-1"></i>Kabupaten/Kota *</label>
                                        <input type="text" name="kabupaten" class="form-control" value="{{ old('kabupaten') }}" placeholder="Contoh: Bandung" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fas fa-building me-1"></i>Kecamatan *</label>
                                        <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan') }}" placeholder="Nama kecamatan" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fas fa-home me-1"></i>Kelurahan/Desa *</label>
                                        <input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan') }}" placeholder="Nama kelurahan/desa" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fas fa-mail-bulk me-1"></i>Kode Pos</label>
                                        <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos') }}" placeholder="12345" maxlength="5">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-envelope me-1"></i>Email *</label>
                                    <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" required placeholder="contoh@email.com" {{ $email ? 'readonly' : '' }}>
                                    @if($email)
                                        <small class="text-success"><i class="fas fa-check-circle me-1"></i>Email sudah diverifikasi</small>
                                    @else
                                        <small class="text-muted">Email untuk notifikasi status pendaftaran</small>
                                    @endif
                                </div>

                                <h5 class="mt-4 mb-3 text-primary"><i class="fas fa-school me-2"></i>Data Sekolah Asal</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-id-badge me-1"></i>NPSN Sekolah</label>
                                        <input type="text" name="npsn_sekolah" class="form-control" value="{{ old('npsn_sekolah') }}" placeholder="8 digit NPSN" maxlength="8">
                                        <small class="text-muted">Nomor Pokok Sekolah Nasional (opsional)</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-school me-1"></i>Nama Sekolah Asal *</label>
                                        <input type="text" name="nama_sekolah_asal" class="form-control" value="{{ old('nama_sekolah_asal') }}" placeholder="Contoh: SMP Negeri 1 Jakarta" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Kabupaten Sekolah *</label>
                                        <input type="text" name="kabupaten_sekolah" class="form-control" value="{{ old('kabupaten_sekolah') }}" placeholder="Contoh: Jakarta Pusat" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-star me-1"></i>Nilai Rata-rata Rapor/Akhir *</label>
                                        <input type="number" name="nilai_rata_rata" class="form-control" value="{{ old('nilai_rata_rata') }}" placeholder="Contoh: 85.50" step="0.01" min="0" max="100" required>
                                        <small class="text-muted">Nilai rata-rata rapor atau ujian akhir (0-100)</small>
                                    </div>
                                </div>

                            </div>

                            <!-- Step 2: Data Orang Tua -->
                            <div class="form-section" id="section2">
                                <h4 class="section-title"><i class="fas fa-users me-2"></i>Data Orang Tua/Wali</h4>
                                
                                <!-- Data Ayah -->
                                <h5 class="mb-3 text-primary"><i class="fas fa-male me-2"></i>Data Ayah</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fas fa-user me-1"></i>Nama Ayah</label>
                                        <input type="text" name="nama_ayah" class="form-control" value="{{ old('nama_ayah') }}" placeholder="Nama lengkap ayah">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fas fa-briefcase me-1"></i>Pekerjaan Ayah</label>
                                        <input type="text" name="pekerjaan_ayah" class="form-control" value="{{ old('pekerjaan_ayah') }}" placeholder="Contoh: PNS, Wiraswasta">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fas fa-phone me-1"></i>No. HP Ayah</label>
                                        <input type="tel" name="hp_ayah" class="form-control" value="{{ old('hp_ayah') }}" placeholder="08xxxxxxxxxx">
                                    </div>
                                </div>

                                <!-- Data Ibu -->
                                <h5 class="mb-3 text-success mt-4"><i class="fas fa-female me-2"></i>Data Ibu</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fas fa-user me-1"></i>Nama Ibu</label>
                                        <input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu') }}" placeholder="Nama lengkap ibu">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fas fa-briefcase me-1"></i>Pekerjaan Ibu</label>
                                        <input type="text" name="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu') }}" placeholder="Contoh: Ibu Rumah Tangga, Guru">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><i class="fas fa-phone me-1"></i>No. HP Ibu</label>
                                        <input type="tel" name="hp_ibu" class="form-control" value="{{ old('hp_ibu') }}" placeholder="08xxxxxxxxxx">
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Pilihan Jurusan -->
                            <div class="form-section" id="section3">
                                <h4 class="section-title"><i class="fas fa-graduation-cap me-2"></i>Pilihan Pendaftaran</h4>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-book me-1"></i>Pilih Jurusan *</label>
                                        <select name="jurusan_id" class="form-select" required>
                                            <option value="">🎓 Pilih Jurusan yang Diminati</option>
                                            @foreach($jurusan as $j)
                                            <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>
                                                @if($j->kode == 'PPLG')
                                                    💻 {{ $j->nama }} ({{ $j->kode }})
                                                @elseif($j->kode == 'AKT')
                                                    📊 {{ $j->nama }} ({{ $j->kode }})
                                                @elseif($j->kode == 'ANIMASI')
                                                    🎬 {{ $j->nama }} ({{ $j->kode }})
                                                @elseif($j->kode == 'PEMASARAN')
                                                    📈 {{ $j->nama }} ({{ $j->kode }})
                                                @elseif($j->kode == 'DKV')
                                                    🎨 {{ $j->nama }} ({{ $j->kode }})
                                                @else
                                                    📚 {{ $j->nama }} ({{ $j->kode }})
                                                @endif
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><i class="fas fa-calendar-alt me-1"></i>Pilih Gelombang *</label>
                                        <select name="gelombang_id" class="form-select" required>
                                            <option value="">🌊 Pilih Gelombang Pendaftaran</option>
                                            @foreach($gelombang as $g)
                                            <option value="{{ $g->id }}" {{ old('gelombang_id') == $g->id ? 'selected' : '' }}>
                                                📅 {{ $g->nama }} - {{ $g->tahun }}
                                                @if($g->biaya_daftar)
                                                    (Rp {{ number_format($g->biaya_daftar, 0, ',', '.') }})
                                                @endif
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <h5 class="mt-4 mb-3"><i class="fas fa-file-upload me-2"></i>Upload Berkas</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ijazah/SKHUN *</label>
                                        <input type="file" name="ijazah" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                        <small class="text-muted">Format: PDF, JPG, PNG (Max: 5MB)</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kartu Keluarga *</label>
                                        <input type="file" name="kk" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                        <small class="text-muted">Format: PDF, JPG, PNG (Max: 5MB)</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Akta Kelahiran *</label>
                                        <input type="file" name="akta" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                        <small class="text-muted">Format: PDF, JPG, PNG (Max: 5MB)</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Pas Foto *</label>
                                        <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png" required>
                                        <small class="text-muted">Format: JPG, PNG (Max: 5MB)</small>
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Informasi:</strong> 
                                    <ul class="mb-0 mt-2">
                                        <li>Pastikan semua data dan berkas yang diupload sudah benar</li>
                                        <li>Nomor HP orang tua akan digunakan untuk komunikasi penting</li>
                                        <li>Setelah submit, Anda akan mendapat nomor pendaftaran untuk cek status</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeStep(-1)" style="display: none;">
                                    <i class="fas fa-arrow-left me-1"></i>Sebelumnya
                                </button>
                                <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeStep(1)">
                                    Selanjutnya<i class="fas fa-arrow-right ms-1"></i>
                                </button>
                                <button type="submit" class="btn btn-secondary" id="submitBtn" style="display: none;">
                                    <i class="fas fa-paper-plane me-1"></i>Kirim Pendaftaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentStep = 1;
        const totalSteps = 3;
        
        // File upload preview
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0]?.name || 'Tidak ada file dipilih';
                const small = this.nextElementSibling;
                if (this.files[0]) {
                    small.textContent = `File: ${fileName}`;
                    small.className = 'text-success';
                } else {
                    small.textContent = 'Format: PDF, JPG, PNG (Max: 5MB)';
                    small.className = 'text-muted';
                }
            });
        });

        function showStep(step) {
            // Hide all sections
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show current section
            document.getElementById('section' + step).classList.add('active');
            
            // Update step indicators
            document.querySelectorAll('.step').forEach((stepEl, index) => {
                stepEl.classList.remove('active', 'completed');
                if (index + 1 < step) {
                    stepEl.classList.add('completed');
                } else if (index + 1 === step) {
                    stepEl.classList.add('active');
                }
            });
            
            // Update buttons
            document.getElementById('prevBtn').style.display = step === 1 ? 'none' : 'block';
            document.getElementById('nextBtn').style.display = step === totalSteps ? 'none' : 'block';
            document.getElementById('submitBtn').style.display = step === totalSteps ? 'block' : 'none';
        }

        function changeStep(direction) {
            const newStep = currentStep + direction;
            
            if (newStep >= 1 && newStep <= totalSteps) {
                // Validate current step before moving forward
                if (direction === 1 && !validateStep(currentStep)) {
                    return;
                }
                
                currentStep = newStep;
                showStep(currentStep);
            }
        }

        function validateStep(step) {
            const section = document.getElementById('section' + step);
            const requiredFields = section.querySelectorAll('[required]');
            
            for (let field of requiredFields) {
                if (!field.value.trim()) {
                    field.focus();
                    field.classList.add('is-invalid');
                    return false;
                }
                field.classList.remove('is-invalid');
            }
            
            return true;
        }

        // Initialize
        showStep(1);
    </script>
</body>
</html>
