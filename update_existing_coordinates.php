<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PendaftarDataSiswa;

// Update koordinat untuk pendaftar yang sudah ada
$updates = [
    ['id' => 8, 'lat' => -6.917464, 'lng' => 107.619123], // Bandung
    ['id' => 9, 'lat' => -6.208763, 'lng' => 106.845599], // Jakarta
    ['id' => 10, 'lat' => -7.257472, 'lng' => 112.752090] // Surabaya
];

foreach($updates as $update) {
    $pendaftar = App\Models\Pendaftar::find($update['id']);
    if($pendaftar && $pendaftar->dataSiswa) {
        $pendaftar->dataSiswa->update([
            'lat' => $update['lat'],
            'lng' => $update['lng']
        ]);
        echo "Updated pendaftar ID {$update['id']} with coordinates {$update['lat']}, {$update['lng']}\n";
    }
}

echo "Coordinate update completed\n";
?>