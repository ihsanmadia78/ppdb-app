<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'PPDB SMK BaktiNusantara 666'); ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f0f2f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; font-weight: bold; }
        .header p { margin: 5px 0 0 0; opacity: 0.9; }
        .content { padding: 30px; }
        .footer { background: #f8f9fa; padding: 25px 20px; text-align: center; color: #6c757d; font-size: 13px; }
        .btn { display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 25px; margin: 5px; font-weight: bold; transition: all 0.3s; }
        .btn:hover { background: #0056b3; }
        .success-badge { background: #28a745; color: white; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: bold; display: inline-block; }
        @media only screen and (max-width: 600px) {
            .container { margin: 0; }
            .content { padding: 20px; }
            .header { padding: 20px; }
            .header h1 { font-size: 20px; }
            table { font-size: 14px; }
            .btn { display: block; margin: 10px 0; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SMK BaktiNusantara 666</h1>
            <p>Sistem Penerimaan Peserta Didik Baru</p>
        </div>
        
        <div class="content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        
        <div class="footer">
            <p>&copy; <?php echo e(date('Y')); ?> SMK BaktiNusantara 666. All rights reserved.</p>
            <p>Jl. Percobaan | (021) 123-4567 | info@smkbaktinusantara666.sch.id</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\ppdb-app\resources\views/emails/layout.blade.php ENDPATH**/ ?>