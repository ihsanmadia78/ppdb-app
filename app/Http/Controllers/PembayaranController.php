<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index($pendaftar_id)
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'pembayaran'])->findOrFail($pendaftar_id);
        
        // Cek apakah sudah ada pembayaran
        $pembayaran = $pendaftar->pembayaran;
        
        if (!$pembayaran) {
            // Buat record pembayaran baru
            $pembayaran = Pembayaran::create([
                'pendaftar_id' => $pendaftar->id,
                'nominal' => 5000000, // Biaya pendaftaran default
                'status' => 'pending'
            ]);
        }

        return view('pendaftaran.pembayaran', compact('pendaftar', 'pembayaran'));
    }

    public function uploadBukti(Request $request, $pendaftar_id)
    {
        $request->validate([
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'metode_pembayaran' => 'required|in:transfer,va,qris'
        ]);

        try {
            $pendaftar = Pendaftar::with('gelombang')->findOrFail($pendaftar_id);
            
            if ($request->hasFile('bukti_bayar')) {
                // Upload file
                $file = $request->file('bukti_bayar');
                $filename = 'bukti_bayar_' . $pendaftar->no_pendaftaran . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('pembayaran', $filename, 'public');

                // Hapus pembayaran lama jika ada
                Pembayaran::where('pendaftar_id', $pendaftar->id)->delete();

                // Tentukan nominal biaya
                $nominal = 150000; // Default
                if ($pendaftar->gelombang && $pendaftar->gelombang->biaya_daftar) {
                    $nominal = $pendaftar->gelombang->biaya_daftar;
                }

                // Buat pembayaran baru dengan status 'paid' agar langsung muncul di keuangan
                Pembayaran::create([
                    'pendaftar_id' => $pendaftar->id,
                    'nominal' => $nominal,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'bukti_bayar' => $path,
                    'status' => 'paid',
                    'tanggal_bayar' => now()
                ]);

                // Update status pendaftar
                $pendaftar->update(['status' => 'MENUNGGU_VERIFIKASI_KEUANGAN']);

                return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload. Data Anda sudah masuk ke sistem keuangan untuk diverifikasi.');
            }

            return redirect()->back()->with('error', 'File bukti pembayaran tidak ditemukan.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload bukti pembayaran: ' . $e->getMessage());
        }
    }
}