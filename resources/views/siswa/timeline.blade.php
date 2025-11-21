@extends('siswa.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-timeline me-2"></i>Timeline Status Pendaftaran</h4>
                </div>
                <div class="card-body">
                    @if($pendaftar)
                        <!-- Status Current -->
                        <div class="alert alert-info mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="mb-1"><i class="fas fa-info-circle me-2"></i>Status Saat Ini</h6>
                                    <p class="mb-0">
                                        <strong>{{ $pendaftar->no_pendaftaran }}</strong> - 
                                        <span class="badge badge-{{ $pendaftar->status == 'LULUS' ? 'success' : ($pendaftar->status == 'TIDAK_LULUS' ? 'danger' : 'warning') }}">
                                            {{ $pendaftar->status }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <small class="text-muted">Terakhir update: {{ $pendaftar->updated_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline Detail -->
                        <div class="timeline">
                            <!-- Step 1: Pendaftaran -->
                            <div class="timeline-item {{ in_array($pendaftar->status, ['SUBMIT', 'MENUNGGU_PEMBAYARAN', 'VERIFIKASI_PEMBAYARAN', 'SIAP_SELEKSI', 'LULUS', 'TIDAK_LULUS', 'CADANGAN']) ? 'completed' : 'pending' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">1. Pendaftaran Berhasil</h6>
                                    <p class="timeline-description">
                                        Data pendaftaran telah disubmit dan tersimpan dalam sistem PPDB. 
                                        Anda telah terdaftar untuk jurusan <strong>{{ $pendaftar->jurusan->nama ?? '-' }}</strong> 
                                        pada <strong>{{ $pendaftar->gelombang->nama ?? '-' }}</strong>.
                                    </p>
                                    <div class="timeline-details">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>{{ $pendaftar->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Pembayaran -->
                            @php
                                $paymentStatus = 'pending';
                                if($pendaftar->pembayaran) {
                                    if($pendaftar->pembayaran->status == 'verified') {
                                        $paymentStatus = 'completed';
                                    } elseif(in_array($pendaftar->pembayaran->status, ['paid', 'rejected'])) {
                                        $paymentStatus = 'current';
                                    }
                                } elseif($pendaftar->status == 'MENUNGGU_PEMBAYARAN') {
                                    $paymentStatus = 'current';
                                }
                            @endphp
                            <div class="timeline-item {{ $paymentStatus }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">2. Pembayaran Pendaftaran</h6>
                                    @if($pendaftar->pembayaran)
                                        @php
                                            $statusConfig = [
                                                'pending' => ['color' => 'secondary', 'text' => 'Menunggu Pembayaran'],
                                                'paid' => ['color' => 'info', 'text' => 'Menunggu Verifikasi'],
                                                'verified' => ['color' => 'success', 'text' => 'Pembayaran Terverifikasi'],
                                                'rejected' => ['color' => 'danger', 'text' => 'Pembayaran Ditolak']
                                            ];
                                            $config = $statusConfig[$pendaftar->pembayaran->status] ?? ['color' => 'secondary', 'text' => 'Status Tidak Diketahui'];
                                        @endphp
                                        <p class="timeline-description">
                                            Bukti pembayaran sebesar <strong>Rp {{ number_format($pendaftar->pembayaran->nominal, 0, ',', '.') }}</strong> 
                                            telah diupload melalui {{ strtoupper($pendaftar->pembayaran->metode_pembayaran) }}.
                                        </p>
                                        <div class="mb-2">
                                            <span class="badge bg-{{ $config['color'] }} px-3 py-2">
                                                <i class="fas fa-{{ $pendaftar->pembayaran->status == 'verified' ? 'check-circle' : ($pendaftar->pembayaran->status == 'rejected' ? 'times-circle' : 'clock') }} me-1"></i>
                                                {{ $config['text'] }}
                                            </span>
                                        </div>
                                        @if($pendaftar->pembayaran->catatan_verifikasi)
                                            <div class="alert alert-{{ $pendaftar->pembayaran->status == 'rejected' ? 'danger' : 'info' }} alert-sm mt-2 mb-2">
                                                <small>
                                                    <strong>Catatan Tim Keuangan:</strong><br>
                                                    {{ $pendaftar->pembayaran->catatan_verifikasi }}
                                                </small>
                                            </div>
                                        @endif
                                        <div class="timeline-details">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>Upload: {{ $pendaftar->pembayaran->created_at->format('d M Y, H:i') }}
                                                @if($pendaftar->pembayaran->verified_at)
                                                    | Verifikasi: {{ $pendaftar->pembayaran->verified_at->format('d M Y, H:i') }}
                                                @endif
                                            </small>
                                        </div>
                                        @if($pendaftar->pembayaran->status == 'rejected')
                                            <div class="timeline-details mt-2">
                                                <a href="{{ route('siswa.pembayaran') }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-upload me-1"></i>Upload Ulang Pembayaran
                                                </a>
                                            </div>
                                        @endif
                                    @else
                                        <p class="timeline-description text-warning">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Silakan upload bukti pembayaran untuk melanjutkan proses pendaftaran.
                                        </p>
                                        <div class="timeline-details">
                                            <a href="{{ route('siswa.pembayaran') }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-upload me-1"></i>Upload Pembayaran
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 3: Verifikasi -->
                            @php
                                $verificationStatus = 'pending';
                                if($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'verified') {
                                    $verificationStatus = 'completed';
                                } elseif($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'paid' || $pendaftar->status == 'VERIFIKASI_PEMBAYARAN') {
                                    $verificationStatus = 'current';
                                }
                            @endphp
                            <div class="timeline-item {{ $verificationStatus }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">3. Verifikasi Pembayaran</h6>
                                    @if($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'verified')
                                        <p class="timeline-description text-success">
                                            <i class="fas fa-check me-1"></i>
                                            Pembayaran telah diverifikasi dan diterima oleh tim keuangan. 
                                            Anda dapat melanjutkan ke tahap seleksi.
                                        </p>
                                        @if($pendaftar->pembayaran->verifiedBy)
                                            <div class="timeline-details">
                                                <small class="text-muted">
                                                    <i class="fas fa-user me-1"></i>Diverifikasi oleh: {{ $pendaftar->pembayaran->verifiedBy->name }}
                                                </small>
                                            </div>
                                        @endif
                                    @elseif($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'paid')
                                        <p class="timeline-description text-warning">
                                            <i class="fas fa-clock me-1"></i>
                                            Pembayaran sedang dalam proses verifikasi oleh tim keuangan. 
                                            Mohon tunggu 1-2 hari kerja.
                                        </p>
                                    @elseif($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'rejected')
                                        <p class="timeline-description text-danger">
                                            <i class="fas fa-times me-1"></i>
                                            Pembayaran ditolak oleh tim keuangan. 
                                            Silakan upload ulang bukti pembayaran yang sesuai.
                                        </p>
                                    @else
                                        <p class="timeline-description text-muted">
                                            Menunggu verifikasi pembayaran dari tim keuangan.
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 4: Seleksi -->
                            <div class="timeline-item {{ in_array($pendaftar->status, ['LULUS', 'TIDAK_LULUS', 'CADANGAN']) ? 'completed' : 'pending' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">4. Proses Seleksi</h6>
                                    @if(in_array($pendaftar->status, ['LULUS', 'TIDAK_LULUS', 'CADANGAN']))
                                        <p class="timeline-description">
                                            Proses seleksi dan penilaian telah selesai dilakukan oleh tim akademik.
                                            Hasil seleksi telah diumumkan.
                                        </p>
                                    @else
                                        <p class="timeline-description text-muted">
                                            Menunggu proses seleksi dan penilaian dari tim akademik.
                                            Proses ini akan dimulai setelah pembayaran terverifikasi.
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 5: Pengumuman -->
                            <div class="timeline-item {{ in_array($pendaftar->status, ['LULUS', 'TIDAK_LULUS', 'CADANGAN']) ? 'completed' : 'pending' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">5. Pengumuman Hasil</h6>
                                    @if($pendaftar->status == 'LULUS')
                                        <div class="alert alert-success mb-0">
                                            <h6 class="text-success mb-2">
                                                <i class="fas fa-trophy me-2"></i>Selamat! Anda DITERIMA
                                            </h6>
                                            <p class="mb-2">
                                                Anda telah diterima di <strong>{{ $pendaftar->jurusan->nama }}</strong>. 
                                                Silakan cetak kartu peserta dan ikuti instruksi selanjutnya.
                                            </p>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>{{ $pendaftar->updated_at->format('d M Y, H:i') }}
                                            </small>
                                        </div>
                                    @elseif($pendaftar->status == 'TIDAK_LULUS')
                                        <div class="alert alert-danger mb-0">
                                            <h6 class="text-danger mb-2">
                                                <i class="fas fa-times-circle me-2"></i>Hasil Seleksi
                                            </h6>
                                            <p class="mb-2">
                                                Mohon maaf, Anda belum berhasil pada seleksi kali ini. 
                                                Terima kasih atas partisipasi Anda.
                                            </p>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>{{ $pendaftar->updated_at->format('d M Y, H:i') }}
                                            </small>
                                        </div>
                                    @elseif($pendaftar->status == 'CADANGAN')
                                        <div class="alert alert-warning mb-0">
                                            <h6 class="text-warning mb-2">
                                                <i class="fas fa-clock me-2"></i>Daftar Cadangan
                                            </h6>
                                            <p class="mb-2">
                                                Anda masuk dalam daftar cadangan. Mohon tunggu pengumuman lebih lanjut 
                                                jika ada slot yang tersedia.
                                            </p>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>{{ $pendaftar->updated_at->format('d M Y, H:i') }}
                                            </small>
                                        </div>
                                    @else
                                        <p class="timeline-description text-muted">
                                            Menunggu pengumuman hasil seleksi. Pengumuman akan disampaikan 
                                            setelah proses seleksi selesai.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @if(in_array($pendaftar->status, ['LULUS', 'CADANGAN']))
                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <a href="{{ route('siswa.cetak-kartu') }}" class="btn btn-success btn-lg" target="_blank">
                                    <i class="fas fa-print me-2"></i>Cetak Kartu Peserta
                                </a>
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="alert alert-warning">
                            <h5>Data Pendaftaran Tidak Ditemukan</h5>
                            <p>Silakan hubungi admin untuk informasi lebih lanjut.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Timeline Styles */
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e0e0e0;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    padding-left: 80px;
}

.timeline-marker {
    position: absolute;
    left: 15px;
    top: 5px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    z-index: 1;
}

.timeline-item.completed .timeline-marker {
    background-color: #28a745;
    color: white;
    border: 3px solid #ffffff;
    box-shadow: 0 0 0 3px #28a745;
}

.timeline-item.current .timeline-marker {
    background-color: #ffc107;
    color: #333;
    border: 3px solid #ffffff;
    box-shadow: 0 0 0 3px #ffc107;
    animation: pulse 2s infinite;
}

.timeline-item.pending .timeline-marker {
    background-color: #e0e0e0;
    color: #666;
    border: 3px solid #ffffff;
}

.timeline-content {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-title {
    margin: 0 0 10px 0;
    font-weight: 600;
    color: #333;
}

.timeline-description {
    margin: 0 0 10px 0;
    color: #666;
    line-height: 1.5;
}

.timeline-details {
    margin-top: 10px;
}

.timeline-item.completed .timeline-content {
    border-left: 4px solid #28a745;
}

.timeline-item.current .timeline-content {
    border-left: 4px solid #ffc107;
    background: #fffbf0;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 3px #ffc107;
    }
    50% {
        box-shadow: 0 0 0 6px rgba(255, 193, 7, 0.5);
    }
    100% {
        box-shadow: 0 0 0 3px #ffc107;
    }
}

.alert-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .timeline-item {
        padding-left: 60px;
    }
    
    .timeline::before {
        left: 20px;
    }
    
    .timeline-marker {
        left: 5px;
        width: 25px;
        height: 25px;
        font-size: 12px;
    }
}
</style>
@endsection