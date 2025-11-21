<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - PPDB SMK BaktiNusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); 
            min-height: 100vh; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card { 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
            border: none;
        }
        .btn-primary { 
            background: linear-gradient(45deg, #495057, #6c757d); 
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #343a40, #495057);
            transform: translateY(-2px);
        }
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #495057;
            box-shadow: 0 0 0 0.2rem rgba(73, 80, 87, 0.25);
        }
        .form-label {
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.5rem;
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/smk.png') }}" alt="Logo SMK" style="width: 80px; height: 80px;">
                            <h3 class="mt-3 fw-bold text-dark">Registrasi Akun</h3>
                            <p class="text-dark">Buat akun untuk memulai pendaftaran</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-user me-2"></i>Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-envelope me-2"></i>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                                <small class="text-muted">Email akan digunakan untuk verifikasi OTP</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-lock me-2"></i>Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password yang sama" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-user-plus me-2"></i>Daftar Akun
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <div class="alert alert-info py-2 mb-3">
                                <small><i class="fas fa-info-circle me-1"></i>Setelah registrasi, Anda akan menerima kode OTP untuk verifikasi email</small>
                            </div>
                            <p class="text-muted">Sudah punya akun? <a href="{{ route('siswa.login') }}" class="text-decoration-none fw-bold">pergi ke portal siswa</a></p>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('welcome') }}" class="text-decoration-none text-muted">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Beranda
                                </a>
                                <a href="{{ route('registration.flow') }}" class="text-decoration-none text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Lihat Alur Pendaftaran
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>