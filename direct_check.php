<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// Direct SQL check
$results = DB::select("
    SELECT p.id, p.no_pendaftaran, pds.nama, pds.lat, pds.lng 
    FROM pendaftar p 
    LEFT JOIN pendaftar_data_siswa pds ON p.id = pds.pendaftar_id 
    ORDER BY p.id DESC
");

echo "Direct SQL results:\n";
foreach($results as $r) {
    echo "ID: {$r->id}, Nama: {$r->nama}, Lat: {$r->lat}, Lng: {$r->lng}\n";
}

// Count with coordinates
$count = DB::select("
    SELECT COUNT(*) as total 
    FROM pendaftar p 
    JOIN pendaftar_data_siswa pds ON p.id = pds.pendaftar_id 
    WHERE pds.lat IS NOT NULL AND pds.lng IS NOT NULL 
    AND pds.lat != 0 AND pds.lng != 0
")[0]->total;

echo "\nTotal with coordinates: {$count}\n";
?>