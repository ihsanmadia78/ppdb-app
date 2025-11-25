<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan PPDB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMK BaktiNusantara 666</h1>
        <h2>LAPORAN KEUANGAN PPDB</h2>
        <p>Periode: {{ $tanggal }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="20%"><strong>Tanggal Cetak</strong></td>
                <td width="2%">:</td>
                <td>{{ $tanggal }}</td>
                <td width="20%"><strong>Total Penerimaan</strong></td>
                <td width="2%">:</td>
                <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td><strong>Jumlah Transaksi</strong></td>
                <td>:</td>
                <td>{{ $pembayaran->count() }} transaksi</td>
                <td><strong>Status</strong></td>
                <td>:</td>
                <td>Terverifikasi</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">No. Pendaftaran</th>
                <th width="20%">Nama Siswa</th>
                <th width="15%">Jurusan</th>
                <th width="10%">Gelombang</th>
                <th width="15%">Nominal</th>
                <th width="10%">Tgl Bayar</th>
                <th width="10%">Tgl Verifikasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayaran as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $p->pendaftar->no_pendaftaran ?? '-' }}</td>
                <td>{{ $p->pendaftar->dataSiswa->nama ?? '-' }}</td>
                <td>{{ $p->pendaftar->jurusan->nama ?? '-' }}</td>
                <td>{{ $p->pendaftar->gelombang->nama ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>
                <td class="text-center">{{ $p->verified_at ? $p->verified_at->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5" class="text-center"><strong>TOTAL PENERIMAAN</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <p>{{ date('d F Y') }}</p>
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>Kepala Sekolah</strong></p>
        <p>SMK BaktiNusantara 666</p>
    </div>

    <div class="footer">
        <small>
            Laporan ini digenerate otomatis oleh Sistem PPDB SMK BaktiNusantara 666<br>
            Dicetak pada: {{ date('d/m/Y H:i:s') }}
        </small>
    </div>
</body>
</html>
