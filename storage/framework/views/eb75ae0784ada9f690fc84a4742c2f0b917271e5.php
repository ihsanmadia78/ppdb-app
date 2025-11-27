<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin PPDB SMK BaktiNusantara 666</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            color: #212529;
        }
        .login-card {
            width: 400px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border: 1px solid #dee2e6;
            overflow: hidden;
        }
        .login-header {
            background: #37474f;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .login-header h4 {
            margin: 0;
            font-weight: 600;
            color: #ffffff;
        }
        .login-body {
            padding: 25px;
            background: #ffffff;
        }
        .form-label {
            font-weight: 500;
            color: #212529;
        }
        .btn-primary {
            background: #37474f;
            border: none;
            transition: 0.3s;
            color: #ffffff;
        }
        .btn-primary:hover {
            background: #37474f;
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            margin-top: 15px;
        }
        .form-control {
            border: 1px solid #ced4da;
            color: #212529;
        }
        .form-control:focus {
            border-color: #37474f;
            box-shadow: 0 0 0 0.2rem rgba(74, 20, 140, 0.25);
        }
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <img src="<?php echo e(asset('img/smk.png')); ?>" alt="Logo SMK BaktiNusantara 666" style="width: 60px; height: 60px; margin-bottom: 10px; border-radius: 50%; background: white; padding: 5px;">
        <h4 style="color: #ffffff;">Login Admin PPDB</h4>
        <p class="mb-0" style="font-size: 14px; color: #ffffff; opacity: 0.95;">SMK BaktiNusantara 666</p>
    </div>
    <div class="login-body">
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>
        
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <form action="<?php echo e(route('login.post')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="admin@ppdb.com" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><i class="fas fa-lock me-2"></i>Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-2">
                <i class="fas fa-sign-in-alt me-2"></i>Masuk
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="<?php echo e(route('welcome')); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-home me-2"></i>Kembali ke Beranda
            </a>
        </div>
        
        <div class="footer">
            &copy; <?php echo e(date('Y')); ?> PPDB SMK BaktiNusantara 666 • Semua Hak Dilindungi
        </div>
    </div>
</div>

</body>
</html>
<?php /**PATH C:\xampp\ppdb-app\resources\views/auth/login.blade.php ENDPATH**/ ?>