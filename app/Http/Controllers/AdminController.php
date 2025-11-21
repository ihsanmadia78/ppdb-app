<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\PendaftarStatus;
use App\Models\Pembayaran;
use App\Models\VerifikasiBerkas;
use Carbon\Carbon;
use DB;
use Mail;
use App\Mail\StatusUpdate;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class AdminController extends Controller
{
   public function dashboard()
{
    // Statistik utama
    $total = Pendaftar::count();
    $diterima = Pendaftar::where('status', 'LULUS')->count();
    $ditolak = Pendaftar::where('status', 'TIDAK_LULUS')->count();
    $cadangan = Pendaftar::where('status', 'CADANGAN')->count();
    $menunggu = Pendaftar::whereNotIn('status', ['LULUS', 'TIDAK_LULUS', 'CADANGAN'])->count();
    
    // Statistik detail per status
    $statusDetail = [
        'submit' => Pendaftar::where('status', 'SUBMIT')->count(),
        'verifikasi_berkas' => Pendaftar::where('status', 'VERIFIKASI_BERKAS')->count(),
        'berkas_ditolak' => Pendaftar::where('status', 'BERKAS_DITOLAK')->count(),
        'menunggu_pembayaran' => Pendaftar::where('status', 'MENUNGGU_PEMBAYARAN')->count(),
        'pembayaran_ditolak' => Pendaftar::where('status', 'PEMBAYARAN_DITOLAK')->count(),
        'siap_seleksi' => Pendaftar::where('status', 'SIAP_SELEKSI')->count()
    ];
    
    // Statistik verifikasi berkas berdasarkan status pendaftar
    $berkasApproved = Pendaftar::whereIn('status', ['MENUNGGU_PEMBAYARAN', 'PEMBAYARAN_DITOLAK', 'SIAP_SELEKSI', 'LULUS', 'TIDAK_LULUS', 'CADANGAN'])->count();
    $berkasRejected = Pendaftar::where('status', 'BERKAS_DITOLAK')->count();
    $berkasPending = Pendaftar::whereIn('status', ['SUBMIT', 'VERIFIKASI_BERKAS'])->count();
    
    // Statistik pembayaran
    try {
        $totalPembayaran = Pembayaran::where('status', 'verified')->sum('nominal') ?? 0;
        $jumlahSudahBayar = Pembayaran::where('status', 'verified')->count();
        $jumlahMenungguVerifikasi = Pembayaran::where('status', 'paid')->count();
        $jumlahPembayaranDitolak = Pembayaran::where('status', 'rejected')->count();
    } catch (\Exception $e) {
        $totalPembayaran = 0;
        $jumlahSudahBayar = 0;
        $jumlahMenungguVerifikasi = 0;
        $jumlahPembayaranDitolak = 0;
    }
    
    // Statistik per gelombang
    try {
        $perGelombang = \App\Models\Gelombang::withCount([
            'pendaftar',
            'pendaftar as lulus_count' => function($query) {
                $query->where('status', 'LULUS');
            },
            'pendaftar as menunggu_count' => function($query) {
                $query->whereNotIn('status', ['LULUS', 'TIDAK_LULUS', 'CADANGAN']);
            }
        ])->get();
    } catch (\Exception $e) {
        $perGelombang = collect();
    }
    
    // Statistik harian (7 hari terakhir)
    $statistikHarian = [];
    for ($i = 6; $i >= 0; $i--) {
        $tanggal = Carbon::now()->subDays($i);
        $jumlah = Pendaftar::whereDate('created_at', $tanggal->format('Y-m-d'))->count();
        $statistikHarian[] = [
            'tanggal' => $tanggal->format('d/m'),
            'jumlah' => $jumlah
        ];
    }
    
    // Top 5 jurusan dengan pendaftar terbanyak
    try {
        $topJurusan = \App\Models\Jurusan::withCount('pendaftar')
            ->orderBy('pendaftar_count', 'desc')
            ->take(5)
            ->get();
    } catch (\Exception $e) {
        $topJurusan = collect();
    }

    // Statistik per jurusan untuk Chart.js
    $perJurusan = \App\Models\Jurusan::withCount('pendaftar')->get();
    $labels = $perJurusan->pluck('nama');
    $data = $perJurusan->pluck('pendaftar_count');

    // Data untuk grafik terverifikasi per jurusan
    $terverifikasiPerJurusan = \App\Models\Jurusan::withCount([
        'pendaftar as terverifikasi_count' => function($query) {
            $query->whereIn('status', ['SIAP_SELEKSI', 'LULUS']);
        }
    ])->get();
    $terverifikasiData = $terverifikasiPerJurusan->pluck('terverifikasi_count');

    // Data untuk grafik sudah bayar per jurusan
    try {
        $sudahBayarPerJurusan = \App\Models\Jurusan::withCount([
            'pendaftar as sudah_bayar_count' => function($query) {
                $query->whereHas('pembayaran', function($q) {
                    $q->where('status', 'verified');
                });
            }
        ])->get();
        $sudahBayarData = $sudahBayarPerJurusan->pluck('sudah_bayar_count');
    } catch (\Exception $e) {
        $sudahBayarData = collect([]);
    }

    // Statistik asal sekolah
    try {
        $asalSekolah = Pendaftar::join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->selectRaw('COALESCE(nama_sekolah_asal, "Tidak Diisi") as sekolah, COUNT(*) as jumlah')
            ->groupBy('nama_sekolah_asal')
            ->orderBy('jumlah', 'desc')
            ->take(5)
            ->get();
    } catch (\Exception $e) {
        $asalSekolah = collect();
    }

    // Statistik wilayah domisili
    try {
        $wilayahDomisili = Pendaftar::join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
            ->selectRaw('SUBSTRING_INDEX(alamat, ",", -1) as wilayah, COUNT(*) as jumlah')
            ->whereNotNull('alamat')
            ->where('alamat', '!=', '')
            ->groupBy('wilayah')
            ->orderBy('jumlah', 'desc')
            ->take(5)
            ->get();
    } catch (\Exception $e) {
        $wilayahDomisili = collect();
    }

    // Ambil 5 pendaftar terbaru
    $terbaru = Pendaftar::with('dataSiswa', 'jurusan', 'gelombang')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

    return view('admin.dashboard', compact(
        'total', 'diterima', 'ditolak', 'cadangan', 'menunggu', 'statusDetail', 
        'berkasApproved', 'berkasRejected', 'berkasPending',
        'totalPembayaran', 'jumlahSudahBayar', 'jumlahMenungguVerifikasi', 'jumlahPembayaranDitolak',
        'perGelombang', 'statistikHarian', 'topJurusan',
        'labels', 'data', 'terverifikasiData', 'sudahBayarData', 'terbaru', 'asalSekolah', 'wilayahDomisili'
    ));
}

    public function index(Request $request)
    {
        $query = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang']);
        
        // Apply filters if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('dataSiswa', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })->orWhere('no_pendaftaran', 'like', "%{$search}%");
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $pendaftar = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.pendaftar', compact('pendaftar'));
    }

    public function show($id)
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang', 'berkas', 'statusTimeline', 'pembayaran'])->findOrFail($id);

        // Cek persetujuan verifikator (berkas) dan keuangan (pembayaran)
        $verifikatorAccepted = $pendaftar->statusTimeline()->where('status', 'MENUNGGU_PEMBAYARAN')->exists()
            || $pendaftar->status == 'MENUNGGU_PEMBAYARAN';

        $verifikatorRejected = $pendaftar->statusTimeline()->where('status', 'TIDAK_LULUS')->exists()
            || $pendaftar->status == 'TIDAK_LULUS';

        $keuanganAccepted = ($pendaftar->pembayaran && in_array($pendaftar->pembayaran->status, ['verified']))
            || in_array($pendaftar->status, ['TERBAYAR', 'VERIFIKASI_KEUANGAN']);

        $keuanganRejected = ($pendaftar->pembayaran && $pendaftar->pembayaran->status == 'rejected');

        return view('admin.show', compact('pendaftar', 'verifikatorAccepted', 'verifikatorRejected', 'keuanganAccepted', 'keuanganRejected'));
    }

    public function petaPendaftar()
    {
        try {
            $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang'])
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
                
            \Log::info('Peta Pendaftar Query Result', [
                'total_pendaftar' => Pendaftar::count(),
                'pendaftar_with_coordinates' => $pendaftar->count(),
                'sample_data' => $pendaftar->take(2)->map(function($p) {
                    return [
                        'id' => $p->id,
                        'nama' => $p->dataSiswa->nama ?? 'N/A',
                        'lat' => $p->dataSiswa->lat ?? 'N/A',
                        'lng' => $p->dataSiswa->lng ?? 'N/A',
                        'status' => $p->status
                    ];
                })
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in petaPendaftar: ' . $e->getMessage());
            $pendaftar = collect();
        }
        
        return view('admin.peta-pendaftar', compact('pendaftar'));
    }

    public function pembayaran()
    {
        $pembayaran = Pembayaran::with(['pendaftar.dataSiswa', 'pendaftar.jurusan'])->orderBy('created_at', 'desc')->get();
        return view('admin.pembayaran', compact('pembayaran'));
    }



    public function pembayaranVerifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'catatan' => 'nullable|string|max:500'
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pendaftar = $pembayaran->pendaftar;
        $oldStatus = $pendaftar->status;
        
        DB::beginTransaction();
        try {
            $pembayaran->update([
                'status' => $request->status,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'catatan_verifikasi' => $request->catatan
            ]);
            
            if ($request->status == 'verified') {
                $newStatus = 'SIAP_SELEKSI';
                $keterangan = 'Pembayaran telah diverifikasi oleh admin';
            } else {
                $newStatus = 'PEMBAYARAN_DITOLAK';
                $keterangan = 'Pembayaran ditolak: ' . ($request->catatan ?? 'Bukti pembayaran tidak valid');
            }
            
            $pendaftar->updateStatus($newStatus, $keterangan);
            
            // Kirim email notifikasi dengan error handling
            try {
                if ($pendaftar->email) {
                    Mail::to($pendaftar->email)->send(new StatusUpdate($pendaftar, $oldStatus, $newStatus));
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send status update email: ' . $e->getMessage());
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Verifikasi pembayaran berhasil');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal memverifikasi pembayaran: ' . $e->getMessage());
        }
    }

    public function rekapKeuangan()
    {
        $totalPenerimaan = Pembayaran::where('status', 'verified')->sum('nominal');
        
        $perJurusan = Pembayaran::join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
                        ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
                        ->where('pembayaran.status', 'verified')
                        ->selectRaw('jurusan.nama, COUNT(*) as jumlah, SUM(pembayaran.nominal) as total')
                        ->groupBy('jurusan.id', 'jurusan.nama')
                        ->get();
        
        $perGelombang = Pembayaran::join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
                          ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
                          ->where('pembayaran.status', 'verified')
                          ->selectRaw('gelombang.nama, COUNT(*) as jumlah, SUM(pembayaran.nominal) as total')
                          ->groupBy('gelombang.id', 'gelombang.nama')
                          ->get();
        
        return view('admin.rekap-keuangan', compact('totalPenerimaan', 'perJurusan', 'perGelombang'));
    }

    public function exportKeuangan(Request $request)
    {
        $format = $request->get('format', 'excel');
        $pembayaran = Pembayaran::with(['pendaftar.dataSiswa', 'pendaftar.jurusan', 'pendaftar.gelombang'])
                        ->where('status', 'verified')
                        ->get();
        
        if ($format == 'excel') {
            return $this->exportExcel($pembayaran);
        } else {
            return $this->exportPDF($pembayaran);
        }
    }

    private function exportExcel($pembayaran)
    {
        $filename = 'laporan_keuangan_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($pembayaran) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'No Pendaftaran',
                'Nama',
                'Jurusan', 
                'Gelombang',
                'Nominal',
                'Metode Pembayaran',
                'Tanggal Bayar',
                'Tanggal Verifikasi'
            ]);
            
            foreach ($pembayaran as $p) {
                fputcsv($file, [
                    $p->pendaftar->no_pendaftaran ?? '-',
                    $p->pendaftar->dataSiswa->nama ?? '-',
                    $p->pendaftar->jurusan->nama ?? '-',
                    $p->pendaftar->gelombang->nama ?? '-',
                    'Rp ' . number_format($p->nominal, 0, ',', '.'),
                    $p->metode_pembayaran ?? '-',
                    $p->created_at->format('d/m/Y'),
                    $p->verified_at ? $p->verified_at->format('d/m/Y') : '-'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    private function exportPDF($pembayaran)
    {
        $data = [
            'pembayaran' => $pembayaran,
            'total' => $pembayaran->sum('nominal'),
            'tanggal' => date('d/m/Y')
        ];
        
        $pdf = PDF::loadView('admin.laporan-keuangan-pdf', $data);
        return $pdf->download('laporan_keuangan_' . date('Y-m-d') . '.pdf');
    }

    public function jurusan()
    {
        $jurusan = Jurusan::withCount('pendaftar')->orderBy('nama')->get();
        return view('admin.jurusan', compact('jurusan'));
    }

    public function jurusanStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:10|unique:jurusan,kode',
            'kuota' => 'required|integer|min:1|max:100'
        ]);

        Jurusan::create($request->only(['nama', 'kode', 'kuota']));
        return redirect()->back()->with('success', 'Jurusan berhasil ditambahkan');
    }

    public function jurusanUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:10|unique:jurusan,kode,' . $id,
            'kuota' => 'required|integer|min:1|max:100'
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update($request->only(['nama', 'kode', 'kuota']));
        return redirect()->back()->with('success', 'Jurusan berhasil diperbarui');
    }

    public function jurusanDestroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        
        if ($jurusan->pendaftar()->count() > 0) {
            return redirect()->back()->with('error', 'Jurusan tidak dapat dihapus karena masih ada pendaftar');
        }
        
        $jurusan->delete();
        return redirect()->back()->with('success', 'Jurusan berhasil dihapus');
    }

    public function updateStatusAkhir(Request $request, $id)
    {
        // Hanya admin yang bisa mengubah status akhir
        if (auth()->user()->role != 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat menentukan status akhir');
        }
        
        $request->validate([
            'status' => 'required|in:LULUS,TIDAK_LULUS,CADANGAN',
            'keterangan' => 'nullable|string|max:500'
        ]);

        try {
            $pendaftar = Pendaftar::with(['jurusan', 'pembayaran'])->findOrFail($id);
            
            // Validasi bahwa pendaftar sudah melewati verifikasi berkas dan pembayaran
            if (!in_array($pendaftar->status, ['SIAP_SELEKSI'])) {
                return redirect()->back()->with('error', 'Pendaftar belum melewati tahap verifikasi berkas dan pembayaran');
            }
            
            // Validasi berdasarkan status yang dipilih
            if ($request->status == 'LULUS') {
                // Cek apakah sudah bayar dan terverifikasi
                if (!$pendaftar->pembayaran || $pendaftar->pembayaran->status != 'verified') {
                    return redirect()->back()->with('error', 'Pendaftar belum melakukan pembayaran atau belum diverifikasi keuangan');
                }
                
                // Cek kuota jurusan
                $jumlahLulus = Pendaftar::where('jurusan_id', $pendaftar->jurusan_id)
                                      ->where('status', 'LULUS')
                                      ->count();
                
                $kuotaJurusan = $pendaftar->jurusan->kuota ?? 30; // Default 30 jika tidak ada kuota
                
                if ($jumlahLulus >= $kuotaJurusan) {
                    return redirect()->back()->with('error', 'Kuota jurusan ' . $pendaftar->jurusan->nama . ' sudah penuh (' . $kuotaJurusan . ' siswa)');
                }
            }
            
            $oldStatus = $pendaftar->status;
            
            // Update status pendaftar
            $pendaftar->update(['status' => $request->status]);
            
            // Buat keterangan otomatis jika tidak diisi
            $keterangan = $request->keterangan;
            if (!$keterangan) {
                switch ($request->status) {
                    case 'LULUS':
                        $keterangan = 'Selamat! Anda diterima di ' . $pendaftar->jurusan->nama;
                        break;
                    case 'TIDAK_LULUS':
                        $keterangan = 'Mohon maaf, Anda belum dapat diterima pada periode ini';
                        break;
                    case 'CADANGAN':
                        $keterangan = 'Anda masuk dalam daftar cadangan. Menunggu konfirmasi lebih lanjut';
                        break;
                }
            }
            
            // Simpan ke timeline status
            PendaftarStatus::create([
                'pendaftar_id' => $pendaftar->id,
                'status' => $request->status,
                'keterangan' => $keterangan,
                'created_by' => auth()->id()
            ]);
            
            // Kirim email notifikasi
            try {
                if ($pendaftar->email) {
                    Mail::to($pendaftar->email)->send(new StatusUpdate($pendaftar, $oldStatus, $request->status));
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send status update email: ' . $e->getMessage());
            }
            
            return redirect()->back()->with('success', 'Status pendaftar berhasil diperbarui');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    public function cetakBuktiPembayaran($id)
    {
        $pembayaran = Pembayaran::with(['pendaftar.dataSiswa', 'pendaftar.jurusan', 'pendaftar.gelombang'])->findOrFail($id);
        
        $data = [
            'pembayaran' => $pembayaran,
            'tanggal_cetak' => date('d/m/Y H:i')
        ];
        
        $pdf = PDF::loadView('admin.bukti-pembayaran-pdf', $data);
        return $pdf->download('bukti_pembayaran_' . $pembayaran->pendaftar->no_pendaftaran . '.pdf');
    }

    public function diterima()
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang'])
                    ->where('status', 'LULUS')
                    ->orderBy('updated_at', 'desc')
                    ->get();
        
        return view('admin.diterima', compact('pendaftar'));
    }

    public function ditolak()
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang'])
                    ->where('status', 'TIDAK_LULUS')
                    ->orderBy('updated_at', 'desc')
                    ->get();
        
        return view('admin.ditolak', compact('pendaftar'));
    }

    public function cadangan()
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang'])
                    ->where('status', 'CADANGAN')
                    ->orderBy('updated_at', 'desc')
                    ->get();
        
        return view('admin.cadangan', compact('pendaftar'));
    }
}
