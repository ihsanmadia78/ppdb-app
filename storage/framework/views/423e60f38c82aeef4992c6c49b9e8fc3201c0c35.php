<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - PPDB SMK BaktiNusantara 666</title>
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
        .otp-input { 
            font-size: 1.8rem; 
            text-align: center; 
            letter-spacing: 0.8rem;
            font-weight: bold;
            background: #f8f9fa;
        }
        .countdown { 
            font-size: 1rem; 
            font-weight: 600; 
            color: #dc3545; 
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
        .btn-outline-secondary {
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-outline-secondary:hover {
            transform: translateY(-1px);
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
                            <img src="<?php echo e(asset('img/smk.png')); ?>" alt="Logo SMK" style="width: 80px; height: 80px;">
                            <h3 class="mt-3 fw-bold text-dark">Verifikasi OTP</h3>
                            <p class="text-dark">Masukkan kode OTP yang dikirim ke email:<br><strong><?php echo e($email); ?></strong></p>
                        </div>

                        <?php if(session('success')): ?>
                            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                        <?php endif; ?>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('otp.verify')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="email" value="<?php echo e($email); ?>">
                            
                            <div class="mb-4">
                                <label class="form-label text-center d-block"><i class="fas fa-key me-2"></i>Kode OTP (6 digit)</label>
                                <input type="text" name="otp_code" class="form-control otp-input" maxlength="6" pattern="[0-9]{6}" placeholder="000000" required>
                                <small class="text-muted d-block text-center mt-2">Masukkan 6 digit kode yang dikirim ke email Anda</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                                <i class="fas fa-check me-2"></i>Verifikasi OTP
                            </button>
                        </form>

                        <div class="text-center">
                            <div class="alert alert-info py-2 mb-3">
                                <small><i class="fas fa-info-circle me-1"></i>Kode OTP berlaku selama 10 menit</small>
                            </div>
                            <p class="text-muted mb-2">Tidak menerima kode OTP?</p>
                            <form method="POST" action="<?php echo e(route('otp.resend')); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="email" value="<?php echo e($email); ?>">
                                <button type="submit" class="btn btn-outline-secondary btn-sm" id="resendBtn">
                                    <i class="fas fa-redo me-1"></i>Kirim Ulang OTP
                                </button>
                            </form>
                            <div class="mt-2">
                                <span class="countdown" id="countdown"></span>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <div class="d-flex justify-content-between">
                                <a href="<?php echo e(route('register')); ?>" class="text-decoration-none text-muted">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Registrasi
                                </a>
                                <a href="<?php echo e(route('welcome')); ?>" class="text-decoration-none text-muted">
                                    <i class="fas fa-home me-1"></i>Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-format OTP input
        document.querySelector('input[name="otp_code"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Countdown timer for resend button
        let countdown = 60;
        const resendBtn = document.getElementById('resendBtn');
        const countdownEl = document.getElementById('countdown');
        
        function updateCountdown() {
            if (countdown > 0) {
                resendBtn.disabled = true;
                countdownEl.textContent = `Kirim ulang dalam ${countdown} detik`;
                countdown--;
                setTimeout(updateCountdown, 1000);
            } else {
                resendBtn.disabled = false;
                countdownEl.textContent = '';
            }
        }
        
        updateCountdown();
    </script>
</body>
</html><?php /**PATH C:\xampp\ppdb-app\resources\views/auth/verify-otp.blade.php ENDPATH**/ ?>