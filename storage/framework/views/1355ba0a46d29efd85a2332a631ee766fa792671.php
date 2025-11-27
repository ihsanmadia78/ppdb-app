<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Peserta PPDB</title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo {
            width: 80px;
            height: 80px;
            float: left;
            margin-right: 20px;
        }
        .school-info {
            margin-left: 100px;
        }
        .school-name {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        .school-address {
            font-size: 12px;
            margin: 5px 0;
        }
        .card-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
            text-decoration: underline;
        }
        .student-info {
            width: 100%;
            border-collapse: collapse;
        }
        .student-info td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .student-info .label {
            width: 30%;
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .photo-box {
            width: 120px;
            height: 150px;
            border: 2px solid #000;
            float: right;
            margin: 0 0 20px 20px;
            text-align: center;
            line-height: 150px;
            background-color: #f9f9f9;
            font-size: 10px;
            color: #999;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
        }
        .clear {
            clear: both;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="<?php echo e(public_path('img/smk.png')); ?>" alt="Logo" class="logo">
        <div class="school-info">
            <h1 class="school-name">SMK BAKTINUSANTARA 666</h1>
            <p class="school-address">
                Jl. Raya Percobaan No.65, Cileunyi Kulon<br>
                Kec. Cileunyi, Kabupaten Bandung, Jawa Barat 40622<br>
                Telp: (022) 123-4567 | Email: info@smkbaktinusantara666.sch.id
            </p>
        </div>
        <div class="clear"></div>
    </div>

    <h2 class="card-title">KARTU PESERTA PENDAFTARAN SISWA BARU<br>TAHUN AJARAN <?php echo e($pendaftar->gelombang->tahun ?? date('Y')); ?></h2>

    <div class="photo-box">
        FOTO<br>
        3x4 cm
    </div>

    <table class="student-info">
        <tr>
            <td class="label">No. Pendaftaran</td>
            <td><?php echo e($pendaftar->no_pendaftaran); ?></td>
        </tr>
        <tr>
            <td class="label">Nama Lengkap</td>
            <td><?php echo e($pendaftar->dataSiswa->nama ?? $pendaftar->nama ?? '-'); ?></td>
        </tr>
        <tr>
            <td class="label">NISN</td>
            <td><?php echo e($pendaftar->dataSiswa->nisn ?? '-'); ?></td>
        </tr>
        <tr>
            <td class="label">Tempat, Tanggal Lahir</td>
            <td>
                <?php echo e($pendaftar->dataSiswa->tempat_lahir ?? '-'); ?>, 
                <?php echo e($pendaftar->dataSiswa->tanggal_lahir ? \Carbon\Carbon::parse($pendaftar->dataSiswa->tanggal_lahir)->format('d F Y') : '-'); ?>

            </td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td><?php echo e(isset($pendaftar->dataSiswa->jenis_kelamin) ? ($pendaftar->dataSiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') : '-'); ?></td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td><?php echo e($pendaftar->dataSiswa->alamat ?? '-'); ?></td>
        </tr>
        <tr>
            <td class="label">No. HP</td>
            <td><?php echo e($pendaftar->dataSiswa->no_hp ?? '-'); ?></td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td><?php echo e($pendaftar->email); ?></td>
        </tr>
        <tr>
            <td class="label">Asal Sekolah</td>
            <td><?php echo e($pendaftar->dataSiswa->asal_sekolah ?? '-'); ?></td>
        </tr>
        <tr>
            <td class="label">Jurusan Pilihan</td>
            <td><?php echo e($pendaftar->jurusan->nama ?? '-'); ?></td>
        </tr>
        <tr>
            <td class="label">Gelombang</td>
            <td><?php echo e($pendaftar->gelombang->nama ?? '-'); ?> (<?php echo e($pendaftar->gelombang->tahun ?? '-'); ?>)</td>
        </tr>
        <tr>
            <td class="label">Status Pendaftaran</td>
            <td><strong><?php echo e($pendaftar->status); ?></strong></td>
        </tr>
        <tr>
            <td class="label">Nama Orang Tua/Wali</td>
            <td><?php echo e($pendaftar->dataSiswa->nama_ayah ?? '-'); ?></td>
        </tr>
        <tr>
            <td class="label">Pekerjaan Orang Tua</td>
            <td><?php echo e($pendaftar->dataSiswa->pekerjaan_ayah ?? '-'); ?></td>
        </tr>
        <tr>
            <td class="label">No. HP Orang Tua</td>
            <td><?php echo e($pendaftar->dataSiswa->no_hp_ortu ?? '-'); ?></td>
        </tr>
    </table>

    <div class="clear"></div>

    <div class="qr-code">
        <div style="border: 2px solid #000; width: 100px; height: 100px; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 10px;">
            <?php echo e($pendaftar->no_pendaftaran); ?>

        </div>
        <br><small>Kode Verifikasi: <?php echo e($pendaftar->no_pendaftaran); ?></small>
    </div>

    <div class="footer">
        <p>Bandung, <?php echo e(\Carbon\Carbon::now()->format('d F Y')); ?></p>
        <div class="signature">
            <p>Kepala Sekolah</p>
            <br><br><br>
            <p><strong>Drs. H. Ahmad Suryadi, M.Pd</strong><br>
            NIP. 196505151990031003</p>
        </div>
    </div>

    <div style="margin-top: 30px; border-top: 1px dashed #000; padding-top: 10px; font-size: 10px;">
        <strong>Catatan:</strong>
        <ul style="margin: 5px 0; padding-left: 20px;">
            <li>Kartu ini wajib dibawa saat mengikuti tes seleksi</li>
            <li>Kartu ini tidak dapat dipindahtangankan</li>
            <li>Jika kartu hilang, segera lapor ke panitia PPDB</li>
            <li>Dicetak pada: <?php echo e(\Carbon\Carbon::now()->format('d/m/Y H:i:s')); ?></li>
        </ul>
    </div>
</body>
</html><?php /**PATH C:\xampp\ppdb-app\resources\views/siswa/kartu-peserta.blade.php ENDPATH**/ ?>