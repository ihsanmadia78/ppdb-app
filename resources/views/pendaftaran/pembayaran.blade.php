<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran PPDB - SMK BaktiNusantara 666</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .payment-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #dee2e6;
            overflow: hidden;
            margin: 2rem 0;
        }
        .payment-header {
            background: linear-gradient(45deg, #495057, #6c757d);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .payment-body {
            padding: 2rem;
            color: #212529;
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
        .qr-code {
            max-width: 200px;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 10px;
            background: white;
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
                <div class="payment-container">
                    <div class="payment-header">
                        <i class="fas fa-credit-card fa-3x mb-3"></i>
                        <h2 class="mb-0">Pembayaran Pendaftaran</h2>
                        <p class="mb-0 mt-2">SMK BaktiNusantara 666</p>
                    </div>

                    <div class="payment-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Info Pendaftar -->
                        <div class="card mb-4">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Pendaftar</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>No. Pendaftaran:</strong></td>
                                                <td><span class="badge bg-secondary fs-6">{{ $pendaftar->no_pendaftaran }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nama:</strong></td>
                                                <td>{{ $pendaftar->dataSiswa?->nama ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Jurusan:</strong></td>
                                                <td>{{ $pendaftar->jurusan?->nama ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status Pembayaran:</strong></td>
                                                <td>
                                                    <span class="badge bg-{{ \App\Models\Pembayaran::getStatusColor($pembayaran->status) }} fs-6">
                                                        {{ \App\Models\Pembayaran::getStatusList()[$pembayaran->status] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Pembayaran -->
                        <div class="card mb-4">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0"><i class="fas fa-money-bill me-2"></i>Detail Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h3 class="text-dark mb-3">Biaya Pendaftaran</h3>
                                        <h2 class="text-success mb-3">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</h2>
                                        <p class="text-muted">Biaya pendaftaran PPDB SMK BaktiNusantara 666</p>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <div class="qr-code mx-auto mb-3">
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=PPDB_{{ $pendaftar->no_pendaftaran }}_{{ $pembayaran->nominal }}" 
                                                 alt="QR Code Pembayaran" class="img-fluid">
                                        </div>
                                        <small class="text-muted">Scan QR Code untuk pembayaran QRIS</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="card mb-4">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Metode Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100 border-secondary">
                                            <div class="card-body text-center">
                                                <i class="fas fa-university fa-2x text-secondary mb-2"></i>
                                                <h6>Transfer Bank</h6>
                                                <p class="small text-muted">BCA: 1234567890<br>a.n SMK BaktiNusantara 666</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100 border-secondary">
                                            <div class="card-body text-center">
                                                <i class="fas fa-mobile-alt fa-2x text-secondary mb-2"></i>
                                                <h6>Virtual Account</h6>
                                                <p class="small text-muted">VA: 8808{{ substr($pendaftar->no_pendaftaran, -8) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100 border-secondary">
                                            <div class="card-body text-center">
                                                <i class="fas fa-qrcode fa-2x text-secondary mb-2"></i>
                                                <h6>QRIS</h6>
                                                <p class="small text-muted">Scan QR Code di atas</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Bukti Bayar -->
                        @if($pembayaran->status == 'pending' || $pembayaran->status == 'rejected')
                        <div class="card mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Upload Bukti Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('pembayaran.upload', $pendaftar->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Metode Pembayaran</label>
                                            <select name="metode_pembayaran" class="form-select" required>
                                                <option value="">Pilih Metode</option>
                                                <option value="transfer">Transfer Bank</option>
                                                <option value="va">Virtual Account</option>
                                                <option value="qris">QRIS</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Bukti Pembayaran</label>
                                            <input type="file" name="bukti_bayar" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                            <small class="text-muted">Format: JPG, PNG, PDF. Max: 2MB</small>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-dark">
                                        <i class="fas fa-upload me-1"></i>Upload Bukti Bayar
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif

                        <!-- Status Bukti Bayar -->
                        @if($pembayaran->bukti_bayar)
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Bukti Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <p><strong>Metode:</strong> {{ ucfirst($pembayaran->metode_pembayaran) }}</p>
                                        <p><strong>Tanggal Upload:</strong> {{ $pembayaran->tanggal_bayar?->format('d F Y, H:i') }} WIB</p>
                                        <p><strong>Status:</strong> 
                                            <span class="badge bg-{{ \App\Models\Pembayaran::getStatusColor($pembayaran->status) }}">
                                                {{ \App\Models\Pembayaran::getStatusList()[$pembayaran->status] }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="{{ Storage::url($pembayaran->bukti_bayar) }}" target="_blank" class="btn btn-outline-dark">
                                            <i class="fas fa-eye me-1"></i>Lihat Bukti
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="text-center">
                            <a href="{{ route('pendaftaran.cek') }}" class="btn btn-secondary">
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