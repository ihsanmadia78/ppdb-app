<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB SMK BaktiNusantara 666 - Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/purple-theme.css')); ?>" rel="stylesheet">
    <style>
        .hero-section {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: #212529;
        }
        .feature-card {
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .stats-section {
            background: #ffffff;
            padding: 80px 0;
        }
        .cta-section {
            background: #37474f;
            color: white;
            padding: 80px 0;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .navbar-custom {
            background: #37474f;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .navbar-custom.scrolled {
            background: #37474f;
            box-shadow: 0 4px 30px rgba(0,0,0,0.2);
        }
        .navbar-nav .nav-link {
            color: #ecf0f1 !important;
            font-weight: 500;
            padding: 0.75rem 1rem !important;
            border-radius: 8px;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
            position: relative;
        }
        .navbar-nav .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 5px;
            left: 50%;
            background: #fff;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .navbar-nav .nav-link:hover::after {
            width: 80%;
        }
        .btn-login {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        .btn-login:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: white;
            transform: translateY(-2px);
            color: white;
        }
        .navbar-brand-text {
            color: white;
            font-weight: 700;
        }
        .school-logo-container {
            position: relative;
            display: inline-block;
            margin: 2rem 0;
        }
        .logo-frame {
            width: 250px;
            height: 250px;
            background: #ffffff;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
            border: 4px solid #e9ecef;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            padding: 20px;
        }
        .school-logo-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 10px;
        }
        .logo-shadow {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 250px;
            height: 250px;
            background: rgba(0,0,0,0.1);
            border-radius: 20px;
            z-index: 1;
        }
        .navbar-logo-img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            border-radius: 10px;
            background: #37474f;
            padding: 3px;
            border: 2px solid rgba(255,255,255,0.2);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .navbar-logo-img:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        @media (max-width: 768px) {
            .logo-frame {
                width: 180px;
                height: 180px;
                padding: 15px;
            }
            .logo-shadow {
                width: 180px;
                height: 180px;
            }
            .navbar-logo-img {
                width: 30px;
                height: 30px;
            }
            .footer-logo-img {
                width: 40px;
                height: 40px;
            }
            .navbar-brand {
                font-size: 1.1rem;
            }
            .navbar-brand-text {
                font-size: 0.9rem;
            }
            .navbar-nav .nav-link {
                padding: 0.5rem 1rem !important;
                margin: 0.1rem 0;
            }
            .btn-login {
                padding: 0.5rem 1.2rem;
                font-size: 0.9rem;
                margin-top: 0.5rem;
            }
            .navbar-custom {
                padding: 0.5rem 0;
            }
        }
        .footer-logo-img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            border-radius: 10px;
            background: white;
            padding: 5px;
            border: 2px solid #6c757d;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <div class="d-flex align-items-center">
                    <div class="navbar-logo me-3">
                        <img src="<?php echo e(asset('img/smk.png')); ?>" alt="Logo SMK" class="navbar-logo-img">
                    </div>
                    <div>
                        <span class="navbar-brand-text">PPDB SMK BaktiNusantara 666</span>
                        <div class="small text-light opacity-75">Sistem Penerimaan Peserta Didik Baru</div>
                    </div>
                </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#panduan">
                            <i class="fas fa-book-open me-1"></i>Panduan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#lokasi">
                            <i class="fas fa-map-marker-alt me-1"></i>Lokasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('pendaftaran.cek')); ?>">
                            <i class="fas fa-search me-1"></i>Cek Status
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-login" href="<?php echo e(route('login')); ?>">
                            <i class="fas fa-sign-in-alt me-1"></i>Login Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        Selamat Datang di<br>
                        <span class="text-dark">PPDB SMK BaktiNusantara 666</span>
                    </h1>
                    <p class="lead mb-4">
                        Sistem Penerimaan Peserta Didik Baru yang mudah, cepat, dan terpercaya. 
                        Daftar sekarang dan wujudkan impian pendidikan Anda!
                    </p>
                    <div class="d-flex gap-3">
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-lg px-4" style="background: #37474f; color: white; border: none;">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </a>
                        <a href="<?php echo e(route('pendaftaran.cek')); ?>" class="btn btn-outline-purple btn-lg px-4" style="border-color: #37474f; color: #37474f;">
                            <i class="fas fa-search me-2"></i>Cek Status
                        </a>
                        <a href="<?php echo e(route('siswa.login')); ?>" class="btn btn-outline-purple btn-lg px-4" style="border-color: #37474f; color: #37474f;">
                            <i class="fas fa-sign-in-alt me-2"></i>Portal Siswa
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="school-logo-container">
                        <div class="logo-frame">
                            <img src="<?php echo e(asset('img/smk.png')); ?>" alt="Logo SMK BaktiNusantara 666" class="school-logo-img">
                        </div>
                        <div class="logo-shadow"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body">
                            <i class="fas fa-users fa-3x mb-3" style="color: #37474f;"></i>
                            <h3 class="fw-bold">1000+</h3>
                            <p class="text-muted">Siswa Terdaftar</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body">
                            <i class="fas fa-book fa-3x mb-3" style="color: #37474f;"></i>
                            <h3 class="fw-bold">15+</h3>
                            <p class="text-muted">Program Keahlian</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body">
                            <i class="fas fa-award fa-3x mb-3" style="color: #37474f;"></i>
                            <h3 class="fw-bold">95%</h3>
                            <p class="text-muted">Tingkat Kelulusan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body">
                            <i class="fas fa-clock fa-3x mb-3" style="color: #37474f;"></i>
                            <h3 class="fw-bold">24/7</h3>
                            <p class="text-muted">Pendaftaran Online</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Guide Section -->
    <section id="panduan" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold" style="color: #37474f;">Panduan Pendaftaran</h2>
                    <p class="text-muted">Ikuti langkah-langkah mudah berikut</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="text-center">
                        <div class="text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #37474f;">
                            <span class="fw-bold fs-4">1</span>
                        </div>
                        <h5 class="fw-bold" style="color: #37474f;">Registrasi Akun</h5>
                        <p class="text-muted">Buat akun dan verifikasi email dengan kode OTP</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="text-center">
                        <div class="text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #37474f;">
                            <span class="fw-bold fs-4">2</span>
                        </div>
                        <h5 class="fw-bold" style="color: #37474f;">Isi Formulir</h5>
                        <p class="text-muted">Lengkapi data dan upload berkas persyaratan</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="text-center">
                        <div class="text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #37474f;">
                            <span class="fw-bold fs-4">3</span>
                        </div>
                        <h5 class="fw-bold" style="color: #37474f;">Verifikasi</h5>
                        <p class="text-muted">Tunggu proses verifikasi dari admin sekolah</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="text-center">
                        <div class="text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: #37474f;">
                            <span class="fw-bold fs-4">4</span>
                        </div>
                        <h5 class="fw-bold" style="color: #37474f;">Pengumuman</h5>
                        <p class="text-muted">Cek status kelulusan secara online</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold" style="color: #37474f;">Berita Sekolah</h2>
                    <p class="text-muted">Informasi terbaru dari SMK BaktiNusantara 666</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-trophy fa-2x text-warning me-3"></i>
                                <div>
                                    <h6 class="mb-0">Prestasi Siswa</h6>
                                    <small class="text-muted">2 hari yang lalu</small>
                                </div>
                            </div>
                            <h5 class="fw-bold">Juara 1 Lomba Programming</h5>
                            <p class="text-muted">Siswa SMK BaktiNusantara 666 meraih juara 1 dalam lomba programming tingkat provinsi dengan aplikasi inovatif.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-graduation-cap fa-2x text-success me-3"></i>
                                <div>
                                    <h6 class="mb-0">Kelulusan</h6>
                                    <small class="text-muted">1 minggu yang lalu</small>
                                </div>
                            </div>
                            <h5 class="fw-bold">Tingkat Kelulusan 98%</h5>
                            <p class="text-muted">Alhamdulillah, tingkat kelulusan siswa tahun ini mencapai 98% dengan banyak yang diterima di perusahaan ternama.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-building fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-0">Fasilitas</h6>
                                    <small class="text-muted">2 minggu yang lalu</small>
                                </div>
                            </div>
                            <h5 class="fw-bold">Laboratorium Baru</h5>
                            <p class="text-muted">Pembangunan laboratorium komputer dan multimedia baru telah selesai dengan peralatan modern dan canggih.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section id="lokasi" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold" style="color: #37474f;">Lokasi Sekolah</h2>
                    <p class="text-muted">SMK BaktiNusantara 666 - Temukan kami di sini</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body p-0">
                            <div class="ratio ratio-16x9">
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.8956147344896!2d107.7742!3d-6.9175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e9adf177bf8d%3A0x23a1ac4d1fd0c1a2!2sJl.%20Raya%20Percobaan%20No.65%2C%20Cileunyi%20Kulon%2C%20Kec.%20Cileunyi%2C%20Kabupaten%20Bandung%2C%20Jawa%20Barat%2040622!5e0!3m2!1sen!2sid!4v1635123456789!5m2!1sen!2sid" 
                                    style="border:0; border-radius: 8px;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card feature-card h-100">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4" style="color: #37474f;">Informasi Kontak</h5>
                            <div class="mb-3">
                                <i class="fas fa-map-marker-alt text-danger me-3"></i>
                                <strong>Alamat:</strong><br>
                                <span class="text-muted ms-4">Jl. Raya Percobaan No.65, Cileunyi Kulon<br>Kec. Cileunyi, Kabupaten Bandung<br>Jawa Barat 40622, Indonesia</span>
                            </div>
                            <div class="mb-3">
                                <i class="fas fa-phone text-success me-3"></i>
                                <strong>Telepon:</strong><br>
                                <span class="text-muted ms-4">(022) 123-4567</span>
                            </div>
                            <div class="mb-3">
                                <i class="fas fa-envelope text-primary me-3"></i>
                                <strong>Email:</strong><br>
                                <span class="text-muted ms-4">info@smkbaktinusantara666.sch.id</span>
                            </div>
                            <div class="mb-3">
                                <i class="fas fa-clock text-warning me-3"></i>
                                <strong>Jam Operasional:</strong><br>
                                <span class="text-muted ms-4">Senin - Jumat: 07:00 - 16:00<br>Sabtu: 07:00 - 12:00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Siap Memulai Pendaftaran?</h2>
            <p class="lead mb-4">Jangan lewatkan kesempatan emas ini. Daftar sekarang dan raih masa depan cerah!</p>
            <a href="<?php echo e(route('register')); ?>" class="btn btn-light btn-lg px-5 me-3" style="color: #37474f;">
                <i class="fas fa-rocket me-2"></i>Mulai Daftar
            </a>
            <a href="<?php echo e(route('registration.flow')); ?>" class="btn btn-outline-light">
                <i class="fas fa-info-circle me-2"></i>Lihat Alur Pendaftaran
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-white py-4" style="background: #37474f;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <div class="footer-logo me-3">
                            <img src="<?php echo e(asset('img/smk.png')); ?>" alt="Logo SMK" class="footer-logo-img">
                        </div>
                        <div>
                            <h5 class="mb-1">PPDB SMK BaktiNusantara 666</h5>
                            <p class="mb-0" style="color: rgba(255,255,255,0.8);">Sistem Penerimaan Peserta Didik Baru yang terpercaya</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0" style="color: rgba(255,255,255,0.8);">&copy; <?php echo e(date('Y')); ?> PPDB SMK BaktiNusantara 666. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto-close navbar on mobile when clicking a link
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                const navbarCollapse = document.querySelector('.navbar-collapse');
                if (navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                    bsCollapse.hide();
                }
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\ppdb-app\resources\views/welcome.blade.php ENDPATH**/ ?>