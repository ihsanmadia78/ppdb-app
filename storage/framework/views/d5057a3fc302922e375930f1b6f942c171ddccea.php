<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Siswa - PPDB SMK BaktiNusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            color: #333333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: #ffffff !important;
            border-bottom: 2px solid #e0e0e0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 600;
            font-size: 1.4rem;
            color: #333333 !important;
        }
        .sidebar {
            background-color: #ffffff !important;
            border-right: 2px solid #e0e0e0;
            box-shadow: 2px 0 4px rgba(0,0,0,0.05);
        }
        .nav-link {
            border-radius: 8px;
            margin-bottom: 8px;
            padding: 12px 16px;
            color: #333333 !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            background-color: #f0f0f0;
            color: #000000 !important;
            transform: translateX(5px);
        }
        .nav-link.active {
            background-color: #6c757d !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            background-color: #ffffff;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
            border-radius: 12px 12px 0 0 !important;
            padding: 20px;
        }
        .card-body {
            padding: 25px;
        }
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-primary:hover {
            background-color: #5a6268;
            border-color: #545b62;
            transform: translateY(-2px);
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #333333;
        }
        .badge {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
        }
        .badge-success {
            background-color: #28a745;
            color: #ffffff;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #333333;
        }
        .badge-danger {
            background-color: #dc3545;
            color: #ffffff;
        }
        .badge-info {
            background-color: #17a2b8;
            color: #ffffff;
        }
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #6c757d;
            box-shadow: 0 0 0 3px rgba(108, 117, 125, 0.1);
        }
        .table {
            color: #333333;
        }
        .table th {
            background-color: #f8f9fa;
            border-color: #e0e0e0;
            color: #333333;
            font-weight: 600;
        }
        .badge {
            font-size: 0.85em;
            padding: 6px 12px;
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        h1, h2, h3, h4, h5, h6 {
            color: #333333;
            font-weight: 600;
        }
        .text-muted {
            color: #666666 !important;
        }
        .navbar-text {
            color: #333333 !important;
            font-weight: 500;
        }
        .btn-outline-light {
            color: #333333;
            border-color: #6c757d;
        }
        .btn-outline-light:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #ffffff;
        }
        .page-header {
            padding: 1.5rem 0;
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 1.5rem;
        }
        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.25rem;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('siswa.profil')); ?>">
                <img src="<?php echo e(asset('img/smk.png')); ?>" alt="Logo SMK" height="40" class="me-2">
                Portal Siswa - SMK BaktiNusantara 666
            </a>
            
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user-circle me-1"></i><?php echo e(Auth::user()->name); ?>

                </span>
                <a href="<?php echo e(route('siswa.logout')); ?>" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar" style="min-height: calc(100vh - 56px);">
                    <div class="p-4">
                        <h6 class="text-muted mb-4 fw-bold">MENU SISWA</h6>
                        <nav class="nav flex-column">
                            <a class="nav-link <?php echo e(request()->routeIs('siswa.profil') ? 'active' : ''); ?>" href="<?php echo e(route('siswa.profil')); ?>">
                                <i class="fas fa-user-circle me-3"></i>Profil
                            </a>
                            <a class="nav-link <?php echo e(request()->routeIs('siswa.timeline') ? 'active' : ''); ?>" href="<?php echo e(route('siswa.timeline')); ?>">
                                <i class="fas fa-timeline me-3"></i>Timeline Status
                            </a>
                            <a class="nav-link <?php echo e(request()->routeIs('siswa.biodata') ? 'active' : ''); ?>" href="<?php echo e(route('siswa.biodata')); ?>">
                                <i class="fas fa-id-card me-3"></i>Biodata
                            </a>
                            <a class="nav-link <?php echo e(request()->routeIs('siswa.pembayaran') ? 'active' : ''); ?>" href="<?php echo e(route('siswa.pembayaran')); ?>">
                                <i class="fas fa-credit-card me-3"></i>Pembayaran
                            </a>
                            <a class="nav-link <?php echo e(request()->routeIs('siswa.perbaikan-berkas') ? 'active' : ''); ?>" href="<?php echo e(route('siswa.perbaikan-berkas')); ?>">
                                <i class="fas fa-upload me-3"></i>Perbaikan Berkas
                            </a>
                            <hr class="my-3">
                            <a class="nav-link" href="<?php echo e(route('siswa.cetak-kartu')); ?>" target="_blank">
                                <i class="fas fa-print me-3"></i>Cetak Kartu
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <main class="p-4">
                    <?php echo $__env->yieldContent('content'); ?>
                </main>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\ppdb-app\resources\views/siswa/layout.blade.php ENDPATH**/ ?>