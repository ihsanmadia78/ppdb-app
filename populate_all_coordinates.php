<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Pendaftar;
use Illuminate\Support\Facades\DB;

// Sample coordinates untuk berbagai kota
$coordinates = [
    ['lat' => -6.917464, 'lng' => 107.619123, 'kota' => 'Bandung'],
    ['lat' => -6.208763, 'lng' => 106.845599, 'kota' => 'Jakarta'],
    ['lat' => -7.257472, 'lng' => 112.752090, 'kota' => 'Surabaya'],
    ['lat' => -7.797068, 'lng' => 110.370529, 'kota' => 'Yogyakarta'],
    ['lat' => -6.914744, 'lng' => 107.609810, 'kota' => 'Bandung 2'],
];

$pendaftar = Pendaftar::with('dataSiswa')->get();
$index = 0;

foreach($pendaftar as $p) {
    if($p->dataSiswa) {
        $coord = $coordinates[$index % count($coordinates)];
        
        DB::statement("UPDATE pendaftar_data_siswa SET lat = ?, lng = ? WHERE pendaftar_id = ?", 
            [$coord['lat'], $coord['lng'], $p->id]);
        
        echo "Updated ID {$p->id} ({$p->dataSiswa->nama}) -> {$coord['kota']} ({$coord['lat']}, {$coord['lng']})\n";
        $index++;
    }
}

echo "\nTotal updated: {$index} pendaftar\n";
echo "Sekarang cek di: http://127.0.0.1:8000/admin/peta-pendaftar\n";
?>