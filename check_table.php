<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// Check table structure
$columns = DB::select("DESCRIBE pendaftar_data_siswa");
echo "Table structure:\n";
foreach($columns as $col) {
    echo "- {$col->Field} ({$col->Type})\n";
}

// Try direct SQL update
try {
    DB::statement("UPDATE pendaftar_data_siswa SET lat = -6.917464, lng = 107.619123 WHERE pendaftar_id = 8");
    DB::statement("UPDATE pendaftar_data_siswa SET lat = -6.208763, lng = 106.845599 WHERE pendaftar_id = 9");
    DB::statement("UPDATE pendaftar_data_siswa SET lat = -7.257472, lng = 112.752090 WHERE pendaftar_id = 10");
    echo "\nDirect SQL update completed\n";
} catch(Exception $e) {
    echo "\nError: " . $e->getMessage() . "\n";
}
?>