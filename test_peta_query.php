<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Pendaftar;

$pendaftar = Pendaftar::with(['dataSiswa', 'jurusan'])
    ->whereHas('dataSiswa', function($query) {
        $query->whereNotNull('lat')
              ->whereNotNull('lng')
              ->where('lat', '!=', '')
              ->where('lng', '!=', '')
              ->where('lat', '!=', 0)
              ->where('lng', '!=', 0);
    })
    ->orderBy('created_at', 'desc')
    ->get();

echo "Query result: " . $pendaftar->count() . " pendaftar\n\n";

foreach($pendaftar as $p) {
    echo "ID: {$p->id}\n";
    echo "Nama: " . ($p->dataSiswa->nama ?? 'N/A') . "\n";
    echo "Lat: " . ($p->dataSiswa->lat ?? 'NULL') . "\n";
    echo "Lng: " . ($p->dataSiswa->lng ?? 'NULL') . "\n";
    echo "Status: {$p->status}\n";
    echo "---\n";
}
?>