<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\PendaftarStatus;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function updateStatus(Request $request, $pendaftar_id)
    {
        $request->validate([
            'status' => 'required|in:DRAFT,SUBMIT,VERIFIKASI_ADMIN,MENUNGGU_PEMBAYARAN,TERBAYAR,VERIFIKASI_KEUANGAN,LULUS,TIDAK_LULUS,CADANGAN',
            'keterangan' => 'nullable|string|max:255'
        ]);

        $pendaftar = Pendaftar::findOrFail($pendaftar_id);
        
        // Update status utama di tabel pendaftar
        $pendaftar->update(['status' => $request->status]);

        // Tambahkan ke timeline status
        PendaftarStatus::create([
            'pendaftar_id' => $pendaftar_id,
            'status' => $request->status,
            'keterangan' => $request->keterangan ?? $this->getDefaultKeterangan($request->status),
            'updated_by' => Auth::user()->name
        ]);

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    private function getDefaultKeterangan($status)
    {
        $keterangan = [
            'DRAFT' => 'Status dikembalikan ke draft',
            'SUBMIT' => 'Pendaftaran dikirim',
            'VERIFIKASI_ADMIN' => 'Sedang dalam proses verifikasi administrasi',
            'MENUNGGU_PEMBAYARAN' => 'Menunggu pembayaran biaya pendaftaran',
            'TERBAYAR' => 'Pembayaran telah diterima',
            'VERIFIKASI_KEUANGAN' => 'Sedang dalam proses verifikasi keuangan',
            'LULUS' => 'Selamat! Anda diterima',
            'TIDAK_LULUS' => 'Mohon maaf, Anda belum berhasil kali ini',
            'CADANGAN' => 'Anda masuk dalam daftar cadangan'
        ];

        return $keterangan[$status] ?? 'Status diperbarui';
    }

    public function terimaPendaftar($pendaftar_id)
    {
        $pendaftar = Pendaftar::findOrFail($pendaftar_id);
        
        // Update status utama
        $pendaftar->update(['status' => 'LULUS']);

        // Tambahkan ke timeline
        PendaftarStatus::create([
            'pendaftar_id' => $pendaftar_id,
            'status' => 'LULUS',
            'keterangan' => 'Pendaftar diterima oleh admin',
            'updated_by' => Auth::user()->name
        ]);

        return back()->with('success', 'Pendaftar berhasil diterima!');
    }

    public function tolakPendaftar($pendaftar_id)
    {
        $pendaftar = Pendaftar::findOrFail($pendaftar_id);
        
        // Update status utama
        $pendaftar->update(['status' => 'TIDAK_LULUS']);

        // Tambahkan ke timeline
        PendaftarStatus::create([
            'pendaftar_id' => $pendaftar_id,
            'status' => 'TIDAK_LULUS',
            'keterangan' => 'Pendaftar ditolak oleh admin',
            'updated_by' => Auth::user()->name
        ]);

        return back()->with('success', 'Pendaftar berhasil ditolak!');
    }
}