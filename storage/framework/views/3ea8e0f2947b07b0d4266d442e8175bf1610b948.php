<?php $__env->startSection('title', 'Update Status Pendaftaran'); ?>

<?php $__env->startSection('content'); ?>
<h2>Status Pendaftaran Anda Telah Diperbarui</h2>

<p>Halo <strong><?php echo e($pendaftar->dataSiswa->nama ?? 'Calon Siswa'); ?></strong>,</p>

<p>Status pendaftaran PPDB Anda telah diperbarui. Berikut detail perubahannya:</p>

<table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
    <tr>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>No. Pendaftaran:</strong></td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><?php echo e($pendaftar->no_pendaftaran); ?></td>
    </tr>
    <tr>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Status Sebelumnya:</strong></td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">
            <span class="status-badge status-<?php echo e(strtolower($oldStatus)); ?>"><?php echo e($oldStatus); ?></span>
        </td>
    </tr>
    <tr>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Status Terbaru:</strong></td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">
            <span class="status-badge status-<?php echo e(strtolower($newStatus)); ?>"><?php echo e($newStatus); ?></span>
        </td>
    </tr>
</table>

<?php if($newStatus == 'MENUNGGU_PEMBAYARAN'): ?>
<div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0;">
    <h4 style="color: #856404; margin: 0 0 10px 0;">⚠️ Pembayaran Diperlukan</h4>
    <p style="margin: 0; color: #856404;">Selamat! Pendaftaran Anda telah diverifikasi. Silakan lakukan pembayaran sebesar <strong>Rp 150.000</strong> untuk melanjutkan proses pendaftaran.</p>
</div>
<?php elseif($newStatus == 'LULUS'): ?>
<div style="background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin: 20px 0;">
    <h4 style="color: #155724; margin: 0 0 10px 0;">🎉 Selamat!</h4>
    <p style="margin: 0; color: #155724;">Anda telah <strong>DITERIMA</strong> di SMK BaktiNusantara 666. Silakan tunggu informasi lebih lanjut mengenai daftar ulang.</p>
</div>
<?php elseif($newStatus == 'TIDAK_LULUS'): ?>
<div style="background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px; margin: 20px 0;">
    <h4 style="color: #721c24; margin: 0 0 10px 0;">😔 Mohon Maaf</h4>
    <p style="margin: 0; color: #721c24;">Mohon maaf, pendaftaran Anda <strong>belum berhasil</strong> pada periode ini. Terima kasih atas partisipasi Anda.</p>
</div>
<?php elseif($newStatus == 'CADANGAN'): ?>
<div style="background: #e2e3e5; border: 1px solid #d6d8db; padding: 15px; border-radius: 5px; margin: 20px 0;">
    <h4 style="color: #383d41; margin: 0 0 10px 0;">📋 Status Cadangan</h4>
    <p style="margin: 0; color: #383d41;">Anda masuk dalam daftar <strong>CADANGAN</strong>. Kami akan menghubungi Anda jika ada slot yang tersedia.</p>
</div>
<?php endif; ?>

<p>Untuk informasi lebih detail, silakan login ke portal siswa atau cek status pendaftaran Anda.</p>

<a href="<?php echo e(url('/siswa/login')); ?>" class="btn">Login Portal Siswa</a>
<a href="<?php echo e(url('/pendaftaran/cek')); ?>" class="btn" style="background: #6c757d;">Cek Status</a>

<p>Jika ada pertanyaan, silakan hubungi kami di (021) 123-4567 atau email info@smkbaktinusantara666.sch.id</p>

<p>Terima kasih,<br>
<strong>Tim PPDB SMK BaktiNusantara 666</strong></p>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('emails.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/emails/status-update.blade.php ENDPATH**/ ?>