<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\PendaftarStatus;
use Carbon\Carbon;
use DB;

class EksekutifController extends Controller
{
    public function dashboard()
    {
        // KPI Utama
        $totalPendaftar = Pendaftar::count();
        $pendaftarHariIni = Pendaftar::whereDate('created_at', Carbon::today())->count();
        $totalKuota = 180; // 5 jurusan x 36 siswa
        $persentaseKuota = $totalKuota > 0 ? round(($totalPendaftar / $totalKuota) * 100, 1) : 0;
        
        // Status-based Statistics
        $lulusVerifikasiAdmin = Pendaftar::whereIn('status', ['MENUNGGU_PEMBAYARAN', 'TERBAYAR', 'VERIFIKASI_KEUANGAN', 'LULUS', 'TIDAK_LULUS', 'CADANGAN'])->count();
        $sudahBayar = Pendaftar::whereIn('status', ['TERBAYAR', 'VERIFIKASI_KEUANGAN', 'LULUS', 'TIDAK_LULUS', 'CADANGAN'])->count();
        $diterima = Pendaftar::where('status', 'LULUS')->count();
        $cadangan = Pendaftar::where('status', 'CADANGAN')->count();
        $tidakLulus = Pendaftar::where('status', 'TIDAK_LULUS')->count();
        
        // Status Distribution
        $statusDistribution = Pendaftar::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Tren Harian - Multiple periods
        $trenMingguan = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = Pendaftar::whereDate('created_at', $date->format('Y-m-d'))->count();
            $trenMingguan[] = [
                'date' => $date->format('d/m'),
                'count' => $count,
                'full_date' => $date->format('Y-m-d')
            ];
        }
        
        $trenBulanan = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = Pendaftar::whereDate('created_at', $date->format('Y-m-d'))->count();
            $trenBulanan[] = [
                'date' => $date->format('d/m'),
                'count' => $count,
                'full_date' => $date->format('Y-m-d')
            ];
        }
        
        // Seluruh periode PPDB
        $firstRegistration = Pendaftar::orderBy('created_at')->first();
        $trenSeluruhPeriode = [];
        if ($firstRegistration) {
            $startDate = Carbon::parse($firstRegistration->created_at)->startOfDay();
            $endDate = Carbon::now();
            $currentDate = $startDate->copy();
            
            while ($currentDate <= $endDate) {
                $count = Pendaftar::whereDate('created_at', $currentDate->format('Y-m-d'))->count();
                $trenSeluruhPeriode[] = [
                    'date' => $currentDate->format('d/m'),
                    'count' => $count,
                    'full_date' => $currentDate->format('Y-m-d')
                ];
                $currentDate->addDay();
            }
        }
        
        // Backward compatibility
        $trenHarian = $trenMingguan;

        // Pendaftar per Jurusan vs Kuota
        $jurusanStats = Jurusan::withCount('pendaftar')->get()->map(function($jurusan) {
            $kuota = 36; // Default kuota per jurusan
            return [
                'nama' => $jurusan->nama,
                'kode' => $jurusan->kode,
                'pendaftar' => $jurusan->pendaftar_count,
                'kuota' => $kuota,
                'persentase' => $kuota > 0 ? round(($jurusan->pendaftar_count / $kuota) * 100, 1) : 0,
                'sisa' => $kuota - $jurusan->pendaftar_count
            ];
        });

        // Rasio Terverifikasi
        $totalSubmit = Pendaftar::where('status', 'SUBMIT')->count();
        $totalVerifikasi = Pendaftar::whereIn('status', ['VERIFIKASI_ADMIN', 'MENUNGGU_PEMBAYARAN', 'TERBAYAR', 'VERIFIKASI_KEUANGAN', 'LULUS', 'TIDAK_LULUS', 'CADANGAN'])->count();
        $rasioVerifikasi = $totalPendaftar > 0 ? round(($totalVerifikasi / $totalPendaftar) * 100, 1) : 0;
        
        // KPI Indicators
        $kpiData = [
            'target_pendaftar' => $totalKuota,
            'realisasi_pendaftar' => $totalPendaftar,
            'persentase_realisasi' => $persentaseKuota,
            'target_verifikasi' => 80, // Target 80% terverifikasi
            'realisasi_verifikasi' => $rasioVerifikasi,
            'status_kpi' => $persentaseKuota >= 80 ? 'excellent' : ($persentaseKuota >= 60 ? 'good' : 'needs_improvement')
        ];

        // Top 5 Asal Sekolah (data real dari database)
        try {
            $asalSekolah = Pendaftar::join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
                ->selectRaw('COALESCE(asal_sekolah, "Tidak Diisi") as nama, COUNT(*) as jumlah')
                ->groupBy('asal_sekolah')
                ->orderBy('jumlah', 'desc')
                ->take(5)
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            // Fallback jika kolom asal_sekolah belum ada
            $asalSekolah = [
                ['nama' => 'Data belum tersedia', 'jumlah' => $totalPendaftar]
            ];
        }

        // Distribusi Wilayah (berdasarkan pilihan dropdown wilayah)
        try {
            $distribusiWilayah = Pendaftar::join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
                ->join('wilayah', 'pendaftar_data_siswa.wilayah_id', '=', 'wilayah.id')
                ->selectRaw('wilayah.nama as wilayah, COUNT(*) as jumlah')
                ->groupBy('wilayah.id', 'wilayah.nama')
                ->orderBy('jumlah', 'desc')
                ->take(5)
                ->get()
                ->toArray();
                
            // Jika tidak ada data dari dropdown, fallback ke parsing alamat
            if (empty($distribusiWilayah)) {
                $distribusiWilayah = Pendaftar::join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
                    ->selectRaw('SUBSTRING_INDEX(alamat, ",", -1) as wilayah, COUNT(*) as jumlah')
                    ->whereNotNull('alamat')
                    ->where('alamat', '!=', '')
                    ->groupBy('wilayah')
                    ->orderBy('jumlah', 'desc')
                    ->take(5)
                    ->get()
                    ->map(function($item) {
                        return [
                            'wilayah' => trim($item->wilayah),
                            'jumlah' => $item->jumlah
                        ];
                    })
                    ->toArray();
            }
                
            // Jika masih tidak ada data
            if (empty($distribusiWilayah)) {
                $distribusiWilayah = [
                    ['wilayah' => 'Belum ada data', 'jumlah' => 0]
                ];
            }
        } catch (\Exception $e) {
            // Fallback jika tabel belum ada
            $distribusiWilayah = [
                ['wilayah' => 'Data belum tersedia', 'jumlah' => 0]
            ];
        }

        // Pendaftar Terbaru (5 terakhir)
        $pendaftarTerbaru = Pendaftar::with(['dataSiswa', 'jurusan'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('eksekutif.dashboard', compact(
            'totalPendaftar', 'pendaftarHariIni', 'totalKuota', 'persentaseKuota',
            'lulusVerifikasiAdmin', 'sudahBayar', 'diterima', 'cadangan', 'tidakLulus',
            'statusDistribution', 'trenHarian', 'trenMingguan', 'trenBulanan', 'trenSeluruhPeriode',
            'jurusanStats', 'rasioVerifikasi', 'asalSekolah', 'distribusiWilayah',
            'pendaftarTerbaru', 'kpiData'
        ));
    }
}