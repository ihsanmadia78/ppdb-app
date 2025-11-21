<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\PendaftarStatus;
use DB;
use Mail;
use App\Mail\StatusUpdate;

class VerifikatorController extends Controller
{
    public function dashboard()
    {
        $total = Pendaftar::count();
        $menunggu = Pendaftar::where('status', 'SUBMIT')->count();
        $diverifikasi = Pendaftar::where('status', 'VERIFIKASI_BERKAS')->count();
        $lulus = Pendaftar::where('status', 'LULUS')->count();
        
        $terbaru = Pendaftar::with('dataSiswa', 'jurusan')
                    ->where('status', 'SUBMIT')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
        
        return view('verifikator.dashboard', compact('total', 'menunggu', 'diverifikasi', 'lulus', 'terbaru'));
    }

    public function index(Request $request)
    {
        $query = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang', 'berkas']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }
        
        if ($request->filled('gelombang_id')) {
            $query->where('gelombang_id', $request->gelombang_id);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('dataSiswa', function($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%");
                })->orWhere('no_pendaftaran', 'like', "%{$search}%");
            });
        }
        
        $pendaftar = $query->orderBy('created_at', 'desc')->get();
        $jurusan = Jurusan::all();
        $gelombang = \App\Models\Gelombang::all();
        
        return view('verifikator.pendaftar', compact('pendaftar', 'jurusan', 'gelombang'));
    }

    public function show($id)
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang', 'berkas', 'statusTimeline.createdBy'])->findOrFail($id);
        return view('verifikator.detail', compact('pendaftar'));
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:BERKAS_DITOLAK,MENUNGGU_PEMBAYARAN,TIDAK_LULUS',
            'catatan' => 'required_if:status,BERKAS_DITOLAK,TIDAK_LULUS|nullable|string|max:500'
        ], [
            'catatan.required_if' => 'Catatan wajib diisi untuk status perbaikan atau penolakan'
        ]);

        $pendaftar = Pendaftar::findOrFail($id);
        $oldStatus = $pendaftar->status;
        
        DB::beginTransaction();
        try {
            $pendaftar->update(['status' => $request->status]);
            
            // Generate appropriate message based on status
            $keterangan = $request->catatan;
            if (!$keterangan) {
                switch ($request->status) {
                    case 'MENUNGGU_PEMBAYARAN':
                        $keterangan = 'Lulus verifikasi administrasi, silakan lanjut ke pembayaran';
                        break;
                    case 'BERKAS_DITOLAK':
                        $keterangan = 'Berkas perlu diperbaiki';
                        break;
                    case 'TIDAK_LULUS':
                        $keterangan = 'Tidak lulus verifikasi administrasi';
                        break;
                }
            }
            
            PendaftarStatus::create([
                'pendaftar_id' => $id,
                'status' => $request->status,
                'keterangan' => $keterangan,
                'created_by' => auth()->id()
            ]);
            
            // Kirim email notifikasi
            if ($pendaftar->email) {
                Mail::to($pendaftar->email)->send(new StatusUpdate($pendaftar, $oldStatus, $request->status));
            }
            
            DB::commit();
            
            $successMessage = match($request->status) {
                'MENUNGGU_PEMBAYARAN' => 'Siswa berhasil lulus verifikasi administrasi',
                'BERKAS_DITOLAK' => 'Berkas siswa ditolak, perlu perbaikan',
                'TIDAK_LULUS' => 'Siswa ditolak dari verifikasi administrasi',
                default => 'Status berhasil diperbarui'
            };
            
            return redirect()->back()->with('success', $successMessage);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    public function riwayat()
    {
        $riwayat = PendaftarStatus::with(['pendaftar.dataSiswa', 'createdBy'])
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('verifikator.riwayat', compact('riwayat'));
    }

    public function deleteRiwayat($id)
    {
        try {
            $status = PendaftarStatus::findOrFail($id);
            $status->delete();
            
            return redirect()->back()->with('success', 'Riwayat berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus riwayat: ' . $e->getMessage());
        }
    }
}