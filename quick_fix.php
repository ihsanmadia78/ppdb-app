<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

DB::statement("UPDATE pendaftar_data_siswa SET lat = -6.917464, lng = 107.619123 WHERE pendaftar_id = 11");
DB::statement("UPDATE pendaftar_data_siswa SET lat = -7.797068, lng = 110.370529 WHERE pendaftar_id = 12");
echo "Done";
?>