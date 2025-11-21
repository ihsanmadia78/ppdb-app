<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/pendaftar-map-data', function () {
    return \App\Models\Pendaftar::with(['dataSiswa', 'jurusan'])
        ->whereHas('dataSiswa', function($query) {
            $query->whereNotNull('lat')
                  ->whereNotNull('lng')
                  ->where('lat', '!=', '')
                  ->where('lng', '!=', '')
                  ->where('lat', '!=', 0)
                  ->where('lng', '!=', 0);
        })
        ->get()
        ->map(function($p) {
            return [
                'lat' => floatval($p->dataSiswa->lat ?? 0),
                'lng' => floatval($p->dataSiswa->lng ?? 0),
                'nama' => $p->dataSiswa->nama ?? '-',
                'jurusan' => $p->jurusan->nama ?? '-',
                'status' => $p->status ?? 'SUBMIT',
                'kecamatan' => $p->dataSiswa->kecamatan ?? 'Tidak diketahui',
                'alamat' => $p->dataSiswa->alamat ?? '-'
            ];
        });
});
