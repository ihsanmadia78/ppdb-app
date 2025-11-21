@extends('emails.layout')

@section('title', 'Konfirmasi Pendaftaran PPDB')

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <h2 style="color: #28a745; margin: 0;">✅ Pendaftaran Berhasil!</h2>
    <p style="color: #6c757d; margin: 5px 0;">Bukti Pendaftaran PPDB SMK BaktiNusantara 666</p>
</div>

<p>Halo <strong>{{ $pendaftar->dataSiswa->nama ?? 'Calon Siswa' }}</strong>,</p>

<p>Selamat! Pendaftaran Anda telah <strong>berhasil diterima</strong> oleh sistem PPDB SMK BaktiNusantara 666. Berikut adalah bukti dan detail pendaftaran Anda:</p>

<div style="background: #f8f9fa; border-radius: 10px; padding: 20px; margin: 20px 0; border-left: 5px solid #28a745;">
    <h3 style="color: #495057; margin-top: 0;">📋 Detail Pendaftaran</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6; width: 40%;"><strong>📄 No. Pendaftaran:</strong></td>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6; color: #007bff; font-weight: bold;">{{ $pendaftar->no_pendaftaran }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;"><strong>👤 Nama Lengkap:</strong></td>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;">{{ $pendaftar->dataSiswa->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;"><strong>🆔 NISN:</strong></td>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;">{{ $pendaftar->dataSiswa->nisn ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;"><strong>📧 Email:</strong></td>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;">{{ $pendaftar->email }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;"><strong>🎓 Jurusan Pilihan:</strong></td>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;">{{ $pendaftar->jurusan->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;"><strong>🌊 Gelombang:</strong></td>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;">{{ $pendaftar->gelombang->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;"><strong>📅 Tanggal Daftar:</strong></td>
            <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;">{{ $pendaftar->created_at->format('d F Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <td style="padding: 10px 0;"><strong>📊 Status:</strong></td>
            <td style="padding: 10px 0;">
                <span style="background: #17a2b8; color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: bold;">✅ BERHASIL DITERIMA</span>
            </td>
        </tr>
    </table>
</div>

<div style="background: #fff3cd; border-radius: 10px; padding: 20px; margin: 20px 0; border-left: 5px solid #ffc107;">
    <h3 style="color: #856404; margin-top: 0;">📝 Langkah Selanjutnya</h3>
    <ol style="color: #856404; line-height: 1.8;">
        <li><strong>Verifikasi Data:</strong> Pastikan semua data yang Anda masukkan sudah benar</li>
        <li><strong>Upload Dokumen:</strong> Siapkan dan upload berkas yang diperlukan (Ijazah, KK, Akta, Foto)</li>
        <li><strong>Tunggu Verifikasi:</strong> Tim admin akan memverifikasi data dan dokumen Anda</li>
        <li><strong>Pembayaran:</strong> Lakukan pembayaran biaya pendaftaran setelah diverifikasi</li>
        <li><strong>Pengumuman:</strong> Pantau status kelulusan melalui portal atau website</li>
    </ol>
</div>

<div style="text-align: center; margin: 30px 0;">
    <p style="margin-bottom: 20px;"><strong>Pantau Status Pendaftaran Anda:</strong></p>
    <a href="{{ url('/pendaftaran/cek') }}" style="display: inline-block; padding: 15px 30px; background: #007bff; color: white; text-decoration: none; border-radius: 25px; margin: 5px; font-weight: bold;">🔍 Cek Status Pendaftaran</a>
    <a href="{{ url('/siswa/login') }}" style="display: inline-block; padding: 15px 30px; background: #28a745; color: white; text-decoration: none; border-radius: 25px; margin: 5px; font-weight: bold;">🚪 Login Portal Siswa</a>
</div>

<div style="background: #e7f3ff; border-radius: 10px; padding: 20px; margin: 20px 0; text-align: center;">
    <h4 style="color: #0066cc; margin-top: 0;">📞 Butuh Bantuan?</h4>
    <p style="margin: 10px 0;">Hubungi kami jika ada pertanyaan:</p>
    <p style="margin: 5px 0;"><strong>📱 Telepon:</strong> (022) 123-4567</p>
    <p style="margin: 5px 0;"><strong>📧 Email:</strong> info@smkbaktinusantara666.sch.id</p>
    <p style="margin: 5px 0;"><strong>🕒 Jam Operasional:</strong> Senin-Jumat 07:00-16:00</p>
</div>

<div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #dee2e6;">
    <p style="color: #28a745; font-weight: bold; margin: 0;">Terima kasih telah memilih SMK BaktiNusantara 666!</p>
    <p style="color: #6c757d; margin: 5px 0;">Tim PPDB SMK BaktiNusantara 666</p>
</div>
@endsection