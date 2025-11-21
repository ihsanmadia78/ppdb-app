<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PendaftarDataSiswa;

// Update koordinat untuk data yang sudah ada
$updates = [
    ['nama' => 'Ahmad Siswa Test', 'lat' => -6.917464, 'lng' => 107.619123],
    ['nama' => 'Siti Siswa Test', 'lat' => -6.208763, 'lng' => 106.845599], 
    ['nama' => 'Budi Siswa Test', 'lat' => -7.257472, 'lng' => 112.752090]
];

foreach ($updates as $update) {
    PendaftarDataSiswa::where('nama', $update['nama'])
        ->update(['lat' => $update['lat'], 'lng' => $update['lng']]);
    echo "Updated " . $update['nama'] . " coordinates\n";
}

echo "Done updating coordinates\n";
?>