<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pembayaran PPDB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 10px;
        }
        .school-name {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
        }
        .school-address {
            font-size: 10px;
            color: #666;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            text-decoration: underline;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px;
            vertical-align: top;
        }
        .label {
            width: 150px;
            font-weight: bold;
        }
        .colon {
            width: 10px;
        }
        .payment-box {
            border: 2px solid #333;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .amount {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            font-weight: bold;
            color: white;
        }
        .status.verified {
            background-color: #28a745;
        }
        .status.pending {
            background-color: #ffc107;
            color: #333;
        }
        .status.rejected {
            background-color: #dc3545;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            color: rgba(0,0,0,0.1);
            z-index: -1;
        }
    </style>
</head>
<body>
    @if($pembayaran->status == 'verified')
    <div class="watermark">LUNAS</div>
    @endif

    <div class="header">
        <div class="school-name">SMK BAKTINUSANTARA 666</div>
        <div class="school-address">
            Jl. Raya Percobaan No.65, Cileunyi Kulon, Kec. Cileunyi<br>
            Kabupaten Bandung, Jawa Barat 40622<br>
            Telp: (022) 123-4567 | Email: info@smkbaktinusantara666.sch.id
        </div>
    </div>

    <div class="title">BUKTI PEMBAYARAN PPDB</div>

    <table class="info-table">
        <tr>
            <td class="label">No. Pendaftaran</td>
            <td class="colon">:</td>
            <td>{{ $pembayaran->pendaftar->no_pendaftaran }}</td>
        </tr>
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="colon">:</td>
            <td>{{ $pembayaran->pendaftar->dataSiswa->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jurusan</td>
            <td class="colon">:</td>
            <td>{{ $pembayaran->pendaftar->jurusan->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Gelombang</td>
            <td class="colon">:</td>
            <td>{{ $pembayaran->pendaftar->gelombang->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td class="colon">:</td>
            <td>{{ $pembayaran->pendaftar->email }}</td>
        </tr>
    </table>

    <div class="payment-box">
        <div style="font-size: 14px; margin-bottom: 10px;">NOMINAL PEMBAYARAN</div>
        <div class="amount">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</div>
        <div style="margin-top: 10px;">
            <span class="status {{ $pembayaran->status == 'verified' ? 'verified' : ($pembayaran->status == 'pending' ? 'pending' : 'rejected') }}">
                @if($pembayaran->status == 'verified')
                    TERVERIFIKASI
                @elseif($pembayaran->status == 'pending')
                    MENUNGGU VERIFIKASI
                @else
                    DITOLAK
                @endif
            </span>
        </div>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Metode Pembayaran</td>
            <td class="colon">:</td>
            <td>{{ $pembayaran->metode_pembayaran ?? 'Transfer Bank' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Pembayaran</td>
            <td class="colon">:</td>
            <td>{{ $pembayaran->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @if($pembayaran->verified_at)
        <tr>
            <td class="label">Tanggal Verifikasi</td>
            <td class="colon">:</td>
            <td>{{ $pembayaran->verified_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endif
        @if($pembayaran->catatan_verifikasi)
        <tr>
            <td class="label">Catatan</td>
            <td class="colon">:</td>
            <td>{{ $pembayaran->catatan_verifikasi }}</td>
        </tr>
        @endif
    </table>

    <div class="footer">
        <div>Dicetak pada: {{ $tanggal_cetak }}</div>
        <div class="signature">
            <div style="margin-bottom: 60px;">Bandung, {{ date('d F Y') }}</div>
            <div>
                <strong>Petugas Keuangan</strong><br>
                SMK BaktiNusantara 666
            </div>
        </div>
    </div>

    <div style="margin-top: 30px; font-size: 10px; color: #666; text-align: center;">
        Dokumen ini dicetak secara otomatis dari Sistem PPDB SMK BaktiNusantara 666<br>
        Untuk verifikasi keaslian dokumen, silakan hubungi bagian keuangan sekolah
    </div>
</body>
</html>