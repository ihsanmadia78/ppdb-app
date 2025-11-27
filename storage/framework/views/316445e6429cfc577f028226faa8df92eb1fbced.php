<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal Siswa - PPDB SMK BaktiNusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #37474f;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            max-width: 450px;
            margin: 0 auto;
        }
        .login-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }
        .login-header {
            background: #ffffff;
            color: #333333;
            padding: 2.5rem 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }
        .school-logo {
            width: 90px;
            height: 90px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            padding: 15px;
            border: 3px solid #e9ecef;
        }
        .school-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .login-body {
            padding: 2rem;
            background: #ffffff;
        }
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #37474f;
            box-shadow: 0 0 0 3px rgba(74, 20, 140, 0.1);
        }
        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-right: none;
            color: #6c757d;
        }
        .btn-primary {
            background: #37474f;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: #37474f;
            transform: translateY(-1px);
        }
        .btn-outline-secondary {
            border: 2px solid #37474f;
            color: #37474f;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
        }
        .btn-outline-secondary:hover {
            background: #37474f;
            border-color: #37474f;
            color: white;
        }
        .text-muted {
            color: #666666 !important;
        }
        h4, h5, h6 {
            color: #333333;
            font-weight: 600;
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="login-container">
                    <div class="login-card">
                        <div class="login-header">
                            <div class="school-logo">
                                <img src="<?php echo e(asset('img/smk.png')); ?>" alt="Logo SMK">
                            </div>
                            <h4 class="mb-2">Portal Calon Siswa</h4>
                            <p class="text-muted mb-0">SMK BaktiNusantara 666</p>
                        </div>
                        
                        <div class="login-body">
                            <?php if(session('error')): ?>
                                <div class="alert alert-danger mb-4">
                                    <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                                </div>
                            <?php endif; ?>
                            <?php if(session('success')): ?>
                                <div class="alert alert-success mb-4">
                                    <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                                </div>
                            <?php endif; ?>

                            <form method="POST" action="<?php echo e(route('siswa.login.post')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-bold text-dark">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email Anda" required>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold text-dark">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password Anda" required>
                                    </div>
                                </div>
                                
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Portal
                                    </button>
                                </div>
                            </form>
                            
                            <div class="text-center">
                                <div class="divider my-4">
                                    <hr class="my-3">
                                    <p class="text-muted mb-3">Belum memiliki akun?</p>
                                </div>
                                <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-secondary w-100 mb-3">
                                    <i class="fas fa-user-plus me-2"></i>Daftar Sebagai Calon Siswa
                                </a>
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="<?php echo e(route('welcome')); ?>" class="text-muted text-decoration-none">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\xampp\ppdb-app\resources\views/siswa/login.blade.php ENDPATH**/ ?>