<?php $__env->startSection('content'); ?>
<div style="text-align: center; padding: 40px 20px;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 10px; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 28px;">Kode Verifikasi OTP</h1>
        <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">PPDB SMK BaktiNusantara 666</p>
    </div>

    <div style="background: #f8f9fa; padding: 30px; border-radius: 10px; margin-bottom: 30px;">
        <p style="font-size: 18px; color: #333; margin-bottom: 20px;">
            Terima kasih telah mendaftar! Gunakan kode OTP berikut untuk memverifikasi email Anda:
        </p>
        
        <div style="background: white; border: 3px dashed #667eea; padding: 20px; border-radius: 10px; margin: 20px 0;">
            <div style="font-size: 36px; font-weight: bold; color: #667eea; letter-spacing: 8px; font-family: 'Courier New', monospace;">
                <?php echo e($otp_code); ?>

            </div>
        </div>

        <p style="color: #666; font-size: 14px; margin-top: 20px;">
            <i class="fas fa-clock"></i> Kode ini berlaku selama <strong>10 menit</strong>
        </p>
    </div>

    <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <p style="color: #856404; margin: 0; font-size: 14px;">
            <strong>Penting:</strong> Jangan bagikan kode ini kepada siapa pun. Tim kami tidak akan pernah meminta kode OTP melalui telepon atau pesan.
        </p>
    </div>

    <p style="color: #666; font-size: 14px; line-height: 1.6;">
        Jika Anda tidak melakukan pendaftaran ini, abaikan email ini atau hubungi kami di 
        <a href="mailto:info@smkbaktinusantara666.sch.id" style="color: #667eea;">info@smkbaktinusantara666.sch.id</a>
    </p>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('emails.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\ppdb-app\resources\views/emails/otp-verification.blade.php ENDPATH**/ ?>