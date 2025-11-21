<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alur Pendaftaran - PPDB SMK BaktiNusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh; }
        .card { border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .step-card { transition: transform 0.3s ease; }
        .step-card:hover { transform: translateY(-5px); }
        .step-number { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; }
        .btn-primary { background: linear-gradient(45deg, #495057, #6c757d); border: none; }
        .btn-primary:hover { background: linear-gradient(45deg, #343a40, #495057); }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <img src="{{ asset('img/smk.png') }}" alt="Logo SMK" style="width: 80px; height: 80px;">
                            <h2 class="mt-3 fw-bold text-dark">Alur Pendaftaran PPDB</h2>
                            <p class="text-dark">SMK BaktiNusantara 666 - Sistem Pendaftaran dengan Verifikasi OTP</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card step-card h-100 border-primary">
                                    <div class="card-body text-center">
                                        <div class="step-number bg-primary text-white mx-auto mb-3">1</div>
                                        <h5 class="fw-bold">Registrasi Akun</h5>
                                        <p class="text-muted">Buat akun dengan nama, email, dan password. Email harus valid untuk menerima kode OTP.</p>
                                        <div class="text-start">
                                            <small class="text-muted">
                                                <i class="fas fa-check text-success me-1"></i>Isi nama lengkap<br>
                                                <i class="fas fa-check text-success me-1"></i>Masukkan email aktif<br>
                                                <i class="fas fa-check text-success me-1"></i>Buat password minimal 6 karakter
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card step-card h-100 border-warning">
                                    <div class="card-body text-center">
                                        <div class="step-number bg-warning text-white mx-auto mb-3">2</div>
                                        <h5 class="fw-bold">Verifikasi OTP</h5>
                                        <p class="text-muted">Cek email Anda dan masukkan kode OTP 6 digit yang dikirim untuk verifikasi.</p>
                                        <div class="text-start">
                                            <small class="text-muted">
                                                <i class="fas fa-clock text-warning me-1"></i>Kode berlaku 10 menit<br>
                                                <i class="fas fa-envelope text-info me-1"></i>Cek folder spam jika perlu<br>
                                                <i class="fas fa-redo text-primary me-1"></i>Bisa kirim ulang OTP
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card step-card h-100 border-success">
                                    <div class="card-body text-center">
                                        <div class="step-number bg-success text-white mx-auto mb-3">3</div>
                                        <h5 class="fw-bold">Isi Formulir</h5>
                                        <p class="text-muted">Lengkapi data pribadi, orang tua, pilih jurusan, dan upload berkas yang diperlukan.</p>
                                        <div class="text-start">
                                            <small class="text-muted">
                                                <i class="fas fa-user text-primary me-1"></i>Data pribadi lengkap<br>
                                                <i class="fas fa-users text-info me-1"></i>Data orang tua/wali<br>
                                                <i class="fas fa-file text-success me-1"></i>Upload berkas (PDF/JPG)
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card step-card h-100 border-info">
                                    <div class="card-body text-center">
                                        <div class="step-number bg-info text-white mx-auto mb-3">4</div>
                                        <h5 class="fw-bold">Verifikasi & Pengumuman</h5>
                                        <p class="text-muted">Tunggu proses verifikasi dari admin sekolah dan cek status kelulusan secara online.</p>
                                        <div class="text-start">
                                            <small class="text-muted">
                                                <i class="fas fa-search text-warning me-1"></i>Verifikasi berkas<br>
                                                <i class="fas fa-credit-card text-success me-1"></i>Konfirmasi pembayaran<br>
                                                <i class="fas fa-trophy text-primary me-1"></i>Pengumuman hasil
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <h6 class="fw-bold"><i class="fas fa-info-circle me-2"></i>Informasi Penting:</h6>
                            <ul class="mb-0">
                                <li>Pastikan email yang digunakan aktif dan dapat menerima pesan</li>
                                <li>Simpan nomor pendaftaran yang diberikan setelah submit formulir</li>
                                <li>Berkas yang diupload harus jelas dan sesuai format (PDF, JPG, PNG)</li>
                                <li>Hubungi admin jika mengalami kendala dalam proses pendaftaran</li>
                            </ul>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 me-3">
                                <i class="fas fa-user-plus me-2"></i>Mulai Registrasi
                            </a>
                            <a href="{{ route('welcome') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-home me-1"></i>Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>