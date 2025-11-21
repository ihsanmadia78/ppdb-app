<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Peserta PPDB</title>
    <style>
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
            margin: 20px;
            text-align: center;
            line-height: 150px;
            background-color: #f9f9f9;
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
        <img src="{{ public_path('img/smk.png') }}" alt="Logo" class="logo">
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

    <h2 class="card-title">KARTU PESERTA PENDAFTARAN SISWA BARU</h2>

    <div class="photo-box">
        FOTO<br>
        3x4
    </div>

    <table class="student-info">
        <tr>
            <td class="label">No. Pendaftaran</td>
            <td>{{ $pendaftar->no_pendaftaran }}</td>
        </tr>
        <tr>
            <td class="label">Nama Lengkap</td>
            <td>{{ $pendaftar->dataSiswa->nama_lengkap ?? $pendaftar->nama }}</td>
        </tr>
        <tr>
            <td class="label">NISN</td>
            <td>{{ $pendaftar->dataSiswa->nisn ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tempat, Tanggal Lahir</td>
            <td>
                {{ $pendaftar->dataSiswa->tempat_lahir ?? '-' }}, 
                {{ $pendaftar->dataSiswa->tanggal_lahir ? \Carbon\Carbon::parse($pendaftar->dataSiswa->tanggal_lahir)->format('d F Y') : '-' }}
            </td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td>{{ $pendaftar->dataSiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td>{{ $pendaftar->dataSiswa->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">No. HP</td>
            <td>{{ $pendaftar->dataSiswa->no_hp ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td>{{ $pendaftar->email }}</td>
        </tr>
        <tr>
            <td class="label">Asal Sekolah</td>
            <td>{{ $pendaftar->dataSiswa->asal_sekolah ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jurusan Pilihan</td>
            <td>{{ $pendaftar->jurusan->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Gelombang</td>
            <td>{{ $pendaftar->gelombang->nama ?? '-' }} ({{ $pendaftar->gelombang->tahun ?? '-' }})</td>
        </tr>
        <tr>
            <td class="label">Status Pendaftaran</td>
            <td><strong>{{ $pendaftar->status }}</strong></td>
        </tr>
    </table>

    <div class="clear"></div>

    <div class="qr-code">
        {!! QrCode::size(100)->generate($pendaftar->no_pendaftaran) !!}
        <br><small>Scan QR Code untuk verifikasi</small>
    </div>

    <div class="footer">
        <p>Bandung, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
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
            <li>Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</li>
        </ul>
    </div>
</body>
</html>