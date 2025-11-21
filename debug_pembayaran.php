<?php

require_once 'vendor/autoload.php';

use App\Models\Pendaftar;
use App\Models\Pembayaran;

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔍 DEBUG PEMBAYARAN PPDB\n";
echo "========================\n\n";

// 1. Cek total pendaftar
$totalPendaftar = Pendaftar::count();
echo "📊 Total Pendaftar: {$totalPendaftar}\n";

// 2. Cek total pembayaran
$totalPembayaran = Pembayaran::count();
echo "💳 Total Record Pembayaran: {$totalPembayaran}\n\n";

// 3. Cek pembayaran berdasarkan status
echo "📋 Status Pembayaran:\n";
$statusCounts = Pembayaran::selectRaw('status, COUNT(*) as count')
    ->groupBy('status')
    ->get();

foreach ($statusCounts as $status) {
    echo "   - {$status->status}: {$status->count}\n";
}
echo "\n";

// 4. Cek pembayaran dengan bukti bayar
$denganBukti = Pembayaran::whereNotNull('bukti_bayar')->count();
echo "📎 Pembayaran dengan bukti: {$denganBukti}\n";

// 5. Cek pembayaran status 'paid' dengan bukti
$paidDenganBukti = Pembayaran::where('status', 'paid')
    ->whereNotNull('bukti_bayar')
    ->count();
echo "⏳ Status 'paid' dengan bukti: {$paidDenganBukti}\n\n";

// 6. Tampilkan 5 pembayaran terbaru dengan status 'paid'
echo "🕐 5 Pembayaran Terbaru (Status: paid):\n";
$terbaru = Pembayaran::with(['pendaftar.dataSiswa'])
    ->where('status', 'paid')
    ->whereNotNull('bukti_bayar')
    ->orderBy('tanggal_bayar', 'desc')
    ->take(5)
    ->get();

if ($terbaru->count() > 0) {
    foreach ($terbaru as $p) {
        $nama = $p->pendaftar->dataSiswa->nama ?? 'Nama tidak tersedia';
        $noPendaftaran = $p->pendaftar->no_pendaftaran ?? 'No tidak tersedia';
        $tanggal = $p->tanggal_bayar ? $p->tanggal_bayar->format('d/m/Y H:i') : 'Tanggal tidak tersedia';
        echo "   - {$noPendaftaran} | {$nama} | {$tanggal}\n";
    }
} else {
    echo "   ❌ Tidak ada pembayaran dengan status 'paid'\n";
}

echo "\n";

// 7. Cek pendaftar tanpa record pembayaran
$tanpaPembayaran = Pendaftar::whereDoesntHave('pembayaran')->count();
echo "⚠️  Pendaftar tanpa record pembayaran: {$tanpaPembayaran}\n";

if ($tanpaPembayaran > 0) {
    echo "   Daftar pendaftar tanpa pembayaran:\n";
    $pendaftarTanpaPembayaran = Pendaftar::with('dataSiswa')
        ->whereDoesntHave('pembayaran')
        ->take(5)
        ->get();
    
    foreach ($pendaftarTanpaPembayaran as $p) {
        $nama = $p->dataSiswa->nama ?? 'Nama tidak tersedia';
        echo "   - {$p->no_pendaftaran} | {$nama}\n";
    }
    
    if ($tanpaPembayaran > 5) {
        echo "   ... dan " . ($tanpaPembayaran - 5) . " lainnya\n";
    }
}

echo "\n";

// 8. Cek pembayaran dengan masalah
echo "🔧 Pembayaran dengan Masalah:\n";

$masalah1 = Pembayaran::whereNotNull('bukti_bayar')
    ->where('status', 'pending')
    ->count();
echo "   - Ada bukti tapi status 'pending': {$masalah1}\n";

$masalah2 = Pembayaran::where('status', 'paid')
    ->whereNull('bukti_bayar')
    ->count();
echo "   - Status 'paid' tapi tidak ada bukti: {$masalah2}\n";

$masalah3 = Pembayaran::where('status', 'paid')
    ->whereNull('tanggal_bayar')
    ->count();
echo "   - Status 'paid' tapi tidak ada tanggal bayar: {$masalah3}\n";

echo "\n========================\n";
echo "✅ Debug selesai!\n";