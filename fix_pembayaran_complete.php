<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Pendaftar;
use App\Models\Pembayaran;

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔧 PERBAIKAN LENGKAP PEMBAYARAN PPDB\n";
echo "====================================\n\n";

try {
    DB::beginTransaction();
    
    // 1. Buat record pembayaran untuk pendaftar yang belum memiliki
    echo "1️⃣ Membuat record pembayaran untuk pendaftar tanpa pembayaran...\n";
    $pendaftarTanpaPembayaran = Pendaftar::whereDoesntHave('pembayaran')->get();
    
    $created = 0;
    foreach ($pendaftarTanpaPembayaran as $pendaftar) {
        $biayaDaftar = $pendaftar->gelombang->biaya_daftar ?? 150000;
        
        Pembayaran::create([
            'pendaftar_id' => $pendaftar->id,
            'nominal' => $biayaDaftar,
            'status' => 'pending'
        ]);
        
        $created++;
    }
    echo "   ✅ {$created} record pembayaran dibuat\n\n";
    
    // 2. Perbaiki pembayaran yang ada bukti tapi status masih pending
    echo "2️⃣ Memperbaiki status pembayaran yang ada bukti...\n";
    $pembayaranBermasalah = Pembayaran::whereNotNull('bukti_bayar')
                                     ->where('status', 'pending')
                                     ->get();
    
    $fixed = 0;
    foreach ($pembayaranBermasalah as $pembayaran) {
        $pembayaran->update([
            'status' => 'paid',
            'tanggal_bayar' => $pembayaran->updated_at ?? now()
        ]);
        $fixed++;
    }
    echo "   ✅ {$fixed} status pembayaran diperbaiki\n\n";
    
    // 3. Perbaiki pembayaran yang status paid tapi tidak ada tanggal bayar
    echo "3️⃣ Memperbaiki tanggal bayar yang kosong...\n";
    $tanpaTanggal = Pembayaran::where('status', 'paid')
                             ->whereNull('tanggal_bayar')
                             ->get();
    
    $fixedDate = 0;
    foreach ($tanpaTanggal as $pembayaran) {
        $pembayaran->update([
            'tanggal_bayar' => $pembayaran->updated_at ?? now()
        ]);
        $fixedDate++;
    }
    echo "   ✅ {$fixedDate} tanggal bayar diperbaiki\n\n";
    
    // 4. Tampilkan statistik akhir
    echo "📊 STATISTIK AKHIR:\n";
    echo "==================\n";
    
    $totalPendaftar = Pendaftar::count();
    $totalPembayaran = Pembayaran::count();
    $statusPaid = Pembayaran::where('status', 'paid')->whereNotNull('bukti_bayar')->count();
    $statusVerified = Pembayaran::where('status', 'verified')->count();
    $statusPending = Pembayaran::where('status', 'pending')->count();
    
    echo "Total Pendaftar: {$totalPendaftar}\n";
    echo "Total Record Pembayaran: {$totalPembayaran}\n";
    echo "Status 'paid' dengan bukti: {$statusPaid}\n";
    echo "Status 'verified': {$statusVerified}\n";
    echo "Status 'pending': {$statusPending}\n\n";
    
    // 5. Tampilkan 5 pembayaran terbaru yang menunggu verifikasi
    echo "🕐 5 PEMBAYARAN TERBARU (Menunggu Verifikasi):\n";
    echo "==============================================\n";
    
    $terbaru = Pembayaran::with(['pendaftar.dataSiswa', 'pendaftar.jurusan'])
        ->where('status', 'paid')
        ->whereNotNull('bukti_bayar')
        ->orderBy('tanggal_bayar', 'desc')
        ->take(5)
        ->get();
    
    if ($terbaru->count() > 0) {
        foreach ($terbaru as $p) {
            $nama = $p->pendaftar->dataSiswa->nama ?? 'Nama tidak tersedia';
            $noPendaftaran = $p->pendaftar->no_pendaftaran ?? 'No tidak tersedia';
            $jurusan = $p->pendaftar->jurusan->kode ?? 'Jurusan tidak tersedia';
            $tanggal = $p->tanggal_bayar ? $p->tanggal_bayar->format('d/m/Y H:i') : 'Tanggal tidak tersedia';
            $nominal = number_format($p->nominal, 0, ',', '.');
            
            echo "📋 {$noPendaftaran} | {$nama} | {$jurusan} | Rp {$nominal} | {$tanggal}\n";
        }
    } else {
        echo "❌ Tidak ada pembayaran yang menunggu verifikasi\n";
    }
    
    DB::commit();
    echo "\n🎉 PERBAIKAN SELESAI! Silakan cek dashboard keuangan.\n";
    
} catch (Exception $e) {
    DB::rollback();
    echo "❌ Error: " . $e->getMessage() . "\n";
}