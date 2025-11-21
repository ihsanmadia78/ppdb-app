@extends('emails.layout')

@section('title', 'Reminder Pembayaran PPDB')

@section('content')
<h2>Reminder Pembayaran Pendaftaran</h2>

<p>Halo <strong>{{ $pendaftar->dataSiswa->nama ?? 'Calon Siswa' }}</strong>,</p>

<p>Ini adalah pengingat bahwa pembayaran pendaftaran PPDB Anda masih menunggu untuk diselesaikan.</p>

<table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
    <tr>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>No. Pendaftaran:</strong></td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $pendaftar->no_pendaftaran }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Nama:</strong></td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $pendaftar->dataSiswa->nama ?? '-' }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Jurusan:</strong></td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $pendaftar->jurusan->nama ?? '-' }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Biaya Pendaftaran:</strong></td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Rp 150.000</strong></td>
    </tr>
</table>

<div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0;">
    <h4 style="color: #856404; margin: 0 0 10px 0;">⏰ Segera Lakukan Pembayaran</h4>
    <p style="margin: 0; color: #856404;">Untuk melanjutkan proses pendaftaran, silakan lakukan pembayaran sesuai dengan metode yang tersedia.</p>
</div>

<p><strong>Metode Pembayaran:</strong></p>
<ul>
    <li><strong>Transfer Bank:</strong> BCA 1234567890 a.n SMK BaktiNusantara 666</li>
    <li><strong>Virtual Account:</strong> Tersedia di portal siswa</li>
    <li><strong>QRIS:</strong> Scan QR Code di portal siswa</li>
</ul>

<p><strong>Cara Upload Bukti Pembayaran:</strong></p>
<ol>
    <li>Login ke portal siswa</li>
    <li>Pilih menu "Pembayaran"</li>
    <li>Upload foto/scan bukti transfer</li>
    <li>Tunggu verifikasi dari admin</li>
</ol>

<a href="{{ url('/siswa/login') }}" class="btn">Login Portal Siswa</a>

<p><strong>Penting:</strong> Pastikan Anda menyertakan nomor pendaftaran <strong>{{ $pendaftar->no_pendaftaran }}</strong> sebagai keterangan transfer.</p>

<p>Jika sudah melakukan pembayaran, silakan abaikan email ini. Jika ada pertanyaan, hubungi kami di (021) 123-4567.</p>

<p>Terima kasih,<br>
<strong>Tim PPDB SMK BaktiNusantara 666</strong></p>
@endsection