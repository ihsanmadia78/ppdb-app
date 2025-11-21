<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// Check both lat/lng and latitude/longitude columns
$results = DB::select("
    SELECT p.id, p.no_pendaftaran, pds.nama, 
           pds.lat, pds.lng, pds.latitude, pds.longitude 
    FROM pendaftar p 
    JOIN pendaftar_data_siswa pds ON p.id = pds.pendaftar_id 
    ORDER BY p.id DESC
");

echo "Data comparison:\n";
foreach($results as $r) {
    echo "ID: {$r->id}, Nama: {$r->nama}\n";
    echo "  lat/lng: {$r->lat}, {$r->lng}\n";
    echo "  latitude/longitude: {$r->latitude}, {$r->longitude}\n\n";
}
?>