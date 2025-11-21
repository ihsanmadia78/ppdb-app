<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Pembayaran;
use App\Models\PendaftarStatus;
use DB;
use Mail;
use App\Mail\StatusUpdate;

class KeuanganController extends Controller
{
    public function dashboard()
    {
        try {
            // Basic stats
            $totalPendaftarSudahBayar = Pembayaran::where('status', 'verified')->count();
            $totalPendaftarBelumBayar = Pendaftar::whereIn('status', ['SUBMIT', 'VERIFIKASI_BERKAS', 'BERKAS_DITOLAK', 'MENUNGGU_PEMBAYARAN', 'PEMBAYARAN_DITOLAK'])->count();
            $totalUangMasukHariIni = Pembayaran::where('status', 'verified')
                                      ->whereDate('verified_at', today())
                                      ->sum('nominal') ?? 0;
            $totalUangMasukKeseluruhan = Pembayaran::where('status', 'verified')->sum('nominal') ?? 0;
        
        // Additional stats
        $menungguVerifikasi = Pembayaran::where('status', 'paid')->count();
        
        // Chart data - Pemasukan per gelombang
        $pemasukanPerGelombang = DB::table('pembayaran')
            ->join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
            ->where('pembayaran.status', 'verified')
            ->select('gelombang.nama', DB::raw('SUM(pembayaran.nominal) as total'))
            ->groupBy('gelombang.id', 'gelombang.nama')
            ->get();
        
        // Chart data - Pemasukan per hari (7 hari terakhir)
        $pemasukanPerHari = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $total = Pembayaran::where('status', 'verified')
                      ->whereDate('verified_at', $date->format('Y-m-d'))
                      ->sum('nominal');
            $pemasukanPerHari[] = [
                'date' => $date->format('d/m'),
                'total' => $total
            ];
        }
        
        // Chart data - Pendaftar yang membayar per jurusan
        $pembayarPerJurusan = DB::table('pembayaran')
            ->join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->where('pembayaran.status', 'verified')
            ->select('jurusan.nama', 'jurusan.kode', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('jurusan.id', 'jurusan.nama', 'jurusan.kode')
            ->get();
        
        $terbaru = Pembayaran::with(['pendaftar.dataSiswa', 'pendaftar.jurusan', 'pendaftar.gelombang'])
                    ->where('status', 'paid')
                    ->whereNotNull('bukti_bayar')
                    ->orderBy('tanggal_bayar', 'desc')
                    ->take(5)
                    ->get();
        
            return view('keuangan.dashboard', compact(
                'totalPendaftarSudahBayar', 
                'totalPendaftarBelumBayar', 
                'totalUangMasukHariIni', 
                'totalUangMasukKeseluruhan',
                'menungguVerifikasi',
                'pemasukanPerGelombang',
                'pemasukanPerHari',
                'pembayarPerJurusan',
                'terbaru'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in KeuanganController dashboard: ' . $e->getMessage());
            
            // Return dashboard with default values if error occurs
            return view('keuangan.dashboard', [
                'totalPendaftarSudahBayar' => 0,
                'totalPendaftarBelumBayar' => 0,
                'totalUangMasukHariIni' => 0,
                'totalUangMasukKeseluruhan' => 0,
                'menungguVerifikasi' => 0,
                'pemasukanPerGelombang' => collect(),
                'pemasukanPerHari' => [],
                'pembayarPerJurusan' => collect(),
                'terbaru' => collect()
            ]);
        }
    }

    public function index(Request $request)
    {
        $query = Pembayaran::with(['pendaftar.dataSiswa', 'pendaftar.jurusan', 'pendaftar.gelombang']);
        
        // Default: tampilkan yang sudah upload bukti (status paid) dan yang sudah diverifikasi
        if (!$request->filled('status')) {
            $query->whereIn('status', ['paid', 'verified', 'rejected']);
        } else {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pendaftar', function($q) use ($search) {
                $q->where('no_pendaftaran', 'like', "%{$search}%")
                  ->orWhereHas('dataSiswa', function($q2) use ($search) {
                      $q2->where('nama', 'like', "%{$search}%");
                  });
            });
        }
        
        $pembayaran = $query->orderBy('created_at', 'desc')->get();
        
        return view('keuangan.pembayaran', compact('pembayaran'));
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::with(['pendaftar.dataSiswa', 'pendaftar.jurusan'])->findOrFail($id);
        return view('keuangan.detail', compact('pembayaran'));
    }

    public function verifikasi(Request $request, $id)
    {
        \Log::info('KeuanganController verifikasi called', [
            'id' => $id,
            'request_data' => $request->all(),
            'user' => auth()->user()->name ?? 'unknown'
        ]);
        
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'catatan' => 'nullable|string|max:500'
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pendaftar = $pembayaran->pendaftar;
        $oldStatus = $pendaftar->status;
        
        DB::beginTransaction();
        try {
            // Update status pembayaran
            $pembayaran->update([
                'status' => $request->status,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'catatan_verifikasi' => $request->catatan
            ]);
            
            // Update status pendaftar
            if ($request->status == 'verified') {
                $newStatus = 'SIAP_SELEKSI';
                $keterangan = 'Pembayaran telah diverifikasi dan diterima oleh petugas keuangan';
            } else {
                $newStatus = 'PEMBAYARAN_DITOLAK';
                $keterangan = 'Pembayaran ditolak: ' . ($request->catatan ?? 'Bukti pembayaran tidak valid');
            }
            
            $pendaftar->update(['status' => $newStatus]);
            
            PendaftarStatus::create([
                'pendaftar_id' => $pendaftar->id,
                'status' => $newStatus,
                'keterangan' => $keterangan,
                'created_by' => auth()->id() ?? 1
            ]);
            
            // Kirim email notifikasi dengan error handling
            try {
                if ($pendaftar->email) {
                    Mail::to($pendaftar->email)->send(new StatusUpdate($pendaftar, $oldStatus, $newStatus));
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send status update email: ' . $e->getMessage());
            }
            
            DB::commit();
            \Log::info('Verifikasi pembayaran berhasil', ['id' => $id, 'status' => $request->status]);
            return redirect()->route('keuangan.pembayaran')->with('success', 'Verifikasi pembayaran berhasil');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Gagal memverifikasi pembayaran', ['id' => $id, 'error' => $e->getMessage()]);
            return redirect()->route('keuangan.pembayaran')->with('error', 'Gagal memverifikasi pembayaran: ' . $e->getMessage());
        }
    }

    public function manualPayment()
    {
        return view('keuangan.manual-payment');
    }

    public function storeManualPayment(Request $request)
    {
        $request->validate([
            'pendaftar_id' => 'required|exists:pendaftar,id',
            'nominal' => 'required|numeric|min:1',
            'tanggal_bayar' => 'required|date',
            'metode_pembayaran' => 'required|in:tunai,transfer,qris',
            'catatan' => 'nullable|string|max:500',
            'bukti_pembayaran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        DB::beginTransaction();
        try {
            $pendaftar = Pendaftar::findOrFail($request->pendaftar_id);
            
            // Check if payment already exists
            $existingPayment = Pembayaran::where('pendaftar_id', $pendaftar->id)->first();
            if ($existingPayment) {
                return back()->withErrors(['pendaftar_id' => 'Pendaftar ini sudah memiliki data pembayaran.']);
            }

            $buktiPath = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $filename = 'manual_' . $pendaftar->no_pendaftaran . '_' . time() . '.' . $file->getClientOriginalExtension();
                $buktiPath = $file->storeAs('pembayaran', $filename, 'public');
            }

            // Create payment record
            $pembayaran = Pembayaran::create([
                'pendaftar_id' => $pendaftar->id,
                'nominal' => $request->nominal,
                'metode_pembayaran' => $request->metode_pembayaran,
                'tanggal_bayar' => $request->tanggal_bayar,
                'bukti_bayar' => $buktiPath,
                'status' => 'verified', // Manual payment is auto-verified
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'catatan' => $request->catatan,
                'catatan_verifikasi' => 'Pembayaran manual oleh ' . auth()->user()->name
            ]);

            // Update pendaftar status
            $pendaftar->update(['status' => 'SIAP_SELEKSI']);

            // Add status timeline
            PendaftarStatus::create([
                'pendaftar_id' => $pendaftar->id,
                'status' => 'SIAP_SELEKSI',
                'keterangan' => 'Pembayaran manual ' . strtoupper($request->metode_pembayaran) . ' - Rp ' . number_format($request->nominal, 0, ',', '.'),
                'created_by' => auth()->id()
            ]);

            DB::commit();
            return redirect()->route('keuangan.pembayaran')->with('success', 'Pembayaran manual berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menambahkan pembayaran: ' . $e->getMessage());
        }
    }

    public function searchPendaftar(Request $request)
    {
        $query = $request->get('q');
        
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan'])
            ->where(function($q) use ($query) {
                $q->where('no_pendaftaran', 'like', "%{$query}%")
                  ->orWhereHas('dataSiswa', function($q2) use ($query) {
                      $q2->where('nama', 'like', "%{$query}%");
                  });
            })
            ->whereDoesntHave('pembayaran') // Only show students without payment
            ->limit(10)
            ->get()
            ->map(function($p) {
                return [
                    'id' => $p->id,
                    'no_pendaftaran' => $p->no_pendaftaran,
                    'nama' => $p->dataSiswa->nama ?? 'Nama tidak tersedia',
                    'jurusan' => $p->jurusan->nama ?? 'Jurusan tidak tersedia',
                    'status' => $p->status
                ];
            });

        return response()->json($pendaftar);
    }

    public function histori(Request $request)
    {
        $query = Pembayaran::with(['pendaftar.dataSiswa', 'pendaftar.jurusan', 'verifiedBy'])
                    ->where('status', 'verified')
                    ->orderBy('verified_at', 'desc');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pendaftar', function($q) use ($search) {
                $q->where('no_pendaftaran', 'like', "%{$search}%")
                  ->orWhereHas('dataSiswa', function($q2) use ($search) {
                      $q2->where('nama', 'like', "%{$search}%");
                  });
            });
        }
        
        $histori = $query->paginate(20);
        
        return view('keuangan.histori', compact('histori'));
    }

    public function deleteHistori($id)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($id);
            $pendaftar = $pembayaran->pendaftar;
            
            DB::beginTransaction();
            
            // Delete payment record
            $pembayaran->delete();
            
            // Update pendaftar status back to waiting payment
            $pendaftar->update(['status' => 'MENUNGGU_PEMBAYARAN']);
            
            // Add status timeline
            PendaftarStatus::create([
                'pendaftar_id' => $pendaftar->id,
                'status' => 'MENUNGGU_PEMBAYARAN',
                'keterangan' => 'Pembayaran dihapus dari histori oleh ' . auth()->user()->name,
                'created_by' => auth()->id()
            ]);
            
            DB::commit();
            return redirect()->back()->with('success', 'Histori pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menghapus histori: ' . $e->getMessage());
        }
    }

    public function laporan(Request $request)
    {
        // Filter parameters
        $dateFrom = $request->get('date_from', date('Y-m-01'));
        $dateTo = $request->get('date_to', date('Y-m-d'));
        $jurusanId = $request->get('jurusan_id');
        $gelombangId = $request->get('gelombang_id');
        
        // Base query for verified payments
        $baseQuery = Pembayaran::where('status', 'verified')
                      ->whereBetween('verified_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);
        
        // Apply filters
        if ($jurusanId) {
            $baseQuery->whereHas('pendaftar', function($q) use ($jurusanId) {
                $q->where('jurusan_id', $jurusanId);
            });
        }
        
        if ($gelombangId) {
            $baseQuery->whereHas('pendaftar', function($q) use ($gelombangId) {
                $q->where('gelombang_id', $gelombangId);
            });
        }
        
        // Summary statistics
        $totalPeriode = $baseQuery->sum('nominal');
        $totalTransaksi = $baseQuery->count();
        
        // Students payment status
        $pendaftarQuery = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang']);
        
        if ($jurusanId) {
            $pendaftarQuery->where('jurusan_id', $jurusanId);
        }
        
        if ($gelombangId) {
            $pendaftarQuery->where('gelombang_id', $gelombangId);
        }
        
        $totalPendaftar = $pendaftarQuery->count();
        $jumlahSudahBayar = $baseQuery->distinct('pendaftar_id')->count('pendaftar_id');
        $jumlahBelumBayar = $totalPendaftar - $jumlahSudahBayar;
        
        // Revenue per major
        $pemasukanPerJurusan = DB::table('pembayaran')
            ->join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->where('pembayaran.status', 'verified')
            ->whereBetween('pembayaran.verified_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->when($jurusanId, function($q) use ($jurusanId) {
                return $q->where('jurusan.id', $jurusanId);
            })
            ->when($gelombangId, function($q) use ($gelombangId) {
                return $q->where('pendaftar.gelombang_id', $gelombangId);
            })
            ->select('jurusan.nama', 'jurusan.kode', DB::raw('SUM(pembayaran.nominal) as total'))
            ->groupBy('jurusan.id', 'jurusan.nama', 'jurusan.kode')
            ->orderBy('total', 'desc')
            ->get();
        
        // Revenue per wave
        $pemasukanPerGelombang = DB::table('pembayaran')
            ->join('pendaftar', 'pembayaran.pendaftar_id', '=', 'pendaftar.id')
            ->join('gelombang', 'pendaftar.gelombang_id', '=', 'gelombang.id')
            ->where('pembayaran.status', 'verified')
            ->whereBetween('pembayaran.verified_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->when($jurusanId, function($q) use ($jurusanId) {
                return $q->where('pendaftar.jurusan_id', $jurusanId);
            })
            ->when($gelombangId, function($q) use ($gelombangId) {
                return $q->where('gelombang.id', $gelombangId);
            })
            ->select('gelombang.nama', DB::raw('SUM(pembayaran.nominal) as total'))
            ->groupBy('gelombang.id', 'gelombang.nama')
            ->orderBy('total', 'desc')
            ->get();
        
        // Students who have paid
        $siswasSudahBayar = Pembayaran::with(['pendaftar.dataSiswa', 'pendaftar.jurusan', 'pendaftar.gelombang'])
            ->where('status', 'verified')
            ->whereBetween('verified_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->when($jurusanId, function($q) use ($jurusanId) {
                return $q->whereHas('pendaftar', function($q2) use ($jurusanId) {
                    $q2->where('jurusan_id', $jurusanId);
                });
            })
            ->when($gelombangId, function($q) use ($gelombangId) {
                return $q->whereHas('pendaftar', function($q2) use ($gelombangId) {
                    $q2->where('gelombang_id', $gelombangId);
                });
            })
            ->orderBy('verified_at', 'desc')
            ->get();
        
        // Students who haven't paid
        $siswasBelumBayar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang'])
            ->whereNotIn('id', $siswasSudahBayar->pluck('pendaftar_id'))
            ->when($jurusanId, function($q) use ($jurusanId) {
                return $q->where('jurusan_id', $jurusanId);
            })
            ->when($gelombangId, function($q) use ($gelombangId) {
                return $q->where('gelombang_id', $gelombangId);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('keuangan.laporan', compact(
            'totalPeriode',
            'totalTransaksi', 
            'totalPendaftar',
            'jumlahSudahBayar',
            'jumlahBelumBayar',
            'pemasukanPerJurusan',
            'pemasukanPerGelombang',
            'siswasSudahBayar',
            'siswasBelumBayar'
        ));
    }
}