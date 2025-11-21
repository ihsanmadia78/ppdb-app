<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biaya;

class BiayaController extends Controller
{
    public function index()
    {
        // Ambil data dari database atau buat default jika belum ada
        $biayaData = Biaya::pluck('nominal', 'jenis')->toArray();
        
        $biaya = [
            'pendaftaran' => $biayaData['pendaftaran'] ?? 150000,
            'spp' => $biayaData['spp'] ?? 500000,
            'seragam' => $biayaData['seragam'] ?? 300000,
            'buku' => $biayaData['buku'] ?? 200000
        ];
        
        return view('admin.biaya', compact('biaya'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'pendaftaran' => 'required|numeric|min:0',
            'spp' => 'required|numeric|min:0',
            'seragam' => 'required|numeric|min:0',
            'buku' => 'required|numeric|min:0'
        ]);

        // Update atau buat data biaya
        $jenisBiaya = ['pendaftaran', 'spp', 'seragam', 'buku'];
        
        foreach ($jenisBiaya as $jenis) {
            Biaya::updateOrCreate(
                ['jenis' => $jenis],
                ['nominal' => $request->input($jenis)]
            );
        }
        
        return redirect()->back()->with('success', 'Biaya berhasil diupdate');
    }
}