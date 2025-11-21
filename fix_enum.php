<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::statement("ALTER TABLE `pendaftar` MODIFY `status` ENUM('DRAFT','SUBMIT','VERIFIKASI_BERKAS','BERKAS_DITOLAK','MENUNGGU_PEMBAYARAN','VERIFIKASI_PEMBAYARAN','PEMBAYARAN_DITOLAK','SIAP_SELEKSI','LULUS','TIDAK_LULUS','CADANGAN') NOT NULL DEFAULT 'SUBMIT'");
    echo "Enum updated successfully\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>