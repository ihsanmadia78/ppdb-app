<?php

require_once 'vendor/autoload.php';

use App\Models\Pendaftar;
use App\Models\Pembayaran;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🧪 MEMBUAT DATA TEST PEMBAYARAN\n";
echo "===============================\n\n";

// Ambil pendaftar pertama
$pendaftar = Pendaftar::with('gelombang')->first();

if (!$pendaftar) {
    echo "❌ Tidak ada pendaftar. Buat pendaftar dulu.\n";
    exit;
}

// Hapus pembayaran lama jika ada
Pembayaran::where('pendaftar_id', $pendaftar->id)->delete();

// Buat pembayaran baru dengan status 'paid'
$pembayaran = Pembayaran::create([
    'pendaftar_id' => $pendaftar->id,
    'nominal' => $pendaftar->gelombang->biaya_daftar ?? 150000,
    'metode_pembayaran' => 'transfer',
    'bukti_bayar' => 'pembayaran/test_bukti.jpg',
    'status' => 'paid',
    'tanggal_bayar' => now()
]);

echo "✅ Data test pembayaran berhasil dibuat:\n";
echo "   - Pendaftar: {$pendaftar->no_pendaftaran}\n";
echo "   - Status: {$pembayaran->status}\n";
echo "   - Nominal: Rp " . number_format($pembayaran->nominal, 0, ',', '.') . "\n";
echo "   - Tanggal: {$pembayaran->tanggal_bayar}\n\n";

echo "🔍 Cek dashboard keuangan sekarang!\n";