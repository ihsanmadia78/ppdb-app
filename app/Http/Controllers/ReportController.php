<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\PendaftarStatus;
use Carbon\Carbon;
use DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReportController extends Controller
{
    public function exportExcel(Request $request)
    {
        try {
            // Increase memory limit and execution time
            ini_set('memory_limit', '512M');
            ini_set('max_execution_time', '300');
            
            $query = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang']);
            
            // Apply filters
            if ($request->jurusan_id) {
                $query->where('jurusan_id', $request->jurusan_id);
            }
            
            if ($request->status) {
                $query->where('status', $request->status);
            }
            
            if ($request->date_from) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            
            if ($request->date_to) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            
            $pendaftar = $query->orderBy('created_at', 'desc')->get();
            
            if ($pendaftar->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data untuk di-export');
            }
            
            // Create new Spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set document properties
            $spreadsheet->getProperties()
                ->setCreator('PPDB SMK BaktiNusantara 666')
                ->setTitle('Data Pendaftar PPDB')
                ->setSubject('Export Data Pendaftar')
                ->setDescription('Data pendaftar PPDB SMK BaktiNusantara 666');
            
            // Header row
            $headers = [
                'A1' => 'No',
                'B1' => 'No Pendaftaran',
                'C1' => 'NIK',
                'D1' => 'NISN',
                'E1' => 'Nama Lengkap',
                'F1' => 'Jenis Kelamin',
                'G1' => 'Tempat Lahir',
                'H1' => 'Tanggal Lahir',
                'I1' => 'Alamat',
                'J1' => 'No HP',
                'K1' => 'Email',
                'L1' => 'Jurusan Pilihan',
                'M1' => 'Gelombang',
                'N1' => 'Status',
                'O1' => 'Tanggal Daftar'
            ];
            
            // Set headers
            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }
            
            // Style header row
            $sheet->getStyle('A1:O1')->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ]);
            
            // Auto-size columns
            foreach (range('A', 'O') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Fill data
            $row = 2;
            foreach ($pendaftar as $index => $p) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $p->no_pendaftaran ?? '-');
                $sheet->setCellValue('C' . $row, $p->dataSiswa->nik ?? '-');
                $sheet->setCellValue('D' . $row, $p->dataSiswa->nisn ?? '-');
                $sheet->setCellValue('E' . $row, $p->dataSiswa->nama ?? '-');
                $sheet->setCellValue('F' . $row, $p->dataSiswa->jenis_kelamin ?? '-');
                $sheet->setCellValue('G' . $row, $p->dataSiswa->tempat_lahir ?? '-');
                $sheet->setCellValue('H' . $row, $p->dataSiswa->tanggal_lahir ? \Carbon\Carbon::parse($p->dataSiswa->tanggal_lahir)->format('d/m/Y') : '-');
                $sheet->setCellValue('I' . $row, $p->dataSiswa->alamat ?? '-');
                $sheet->setCellValue('J' . $row, $p->dataSiswa->no_hp ?? '-');
                $sheet->setCellValue('K' . $row, $p->email ?? '-');
                $sheet->setCellValue('L' . $row, $p->jurusan->nama ?? '-');
                $sheet->setCellValue('M' . $row, $p->gelombang->nama ?? '-');
                $sheet->setCellValue('N' . $row, $p->status ?? '-');
                $sheet->setCellValue('O' . $row, $p->created_at->format('d/m/Y H:i'));
                $row++;
            }
            
            // Create Excel file
            $writer = new Xlsx($spreadsheet);
            $filename = 'Data_Pendaftar_PPDB_' . date('Y-m-d_H-i-s') . '.xlsx';
            
            // Use Laravel response for proper download
            return response()->streamDownload(function() use ($writer) {
                $writer->save('php://output');
            }, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Cache-Control' => 'max-age=0',
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Export Excel Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Gagal export data: ' . $e->getMessage());
        }
    }
    
    public function generateReport(Request $request)
    {
        $type = $request->get('type', 'summary');
        
        switch ($type) {
            case 'summary':
                return $this->summaryReport($request);
            case 'detailed':
                return $this->detailedReport($request);
            case 'analytics':
                return $this->analyticsReport($request);
            default:
                return $this->summaryReport($request);
        }
    }
    
    private function summaryReport($request)
    {
        $data = [
            'total_pendaftar' => Pendaftar::count(),
            'per_status' => Pendaftar::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')->get(),
            'per_jurusan' => Jurusan::withCount('pendaftar')->get(),
            'trend_harian' => $this->getTrendHarian(7),
            'generated_at' => now()
        ];
        
        return response()->json($data);
    }
    
    private function detailedReport($request)
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'statusTimeline'])
            ->when($request->jurusan_id, function($q) use ($request) {
                return $q->where('jurusan_id', $request->jurusan_id);
            })
            ->when($request->status, function($q) use ($request) {
                return $q->where('status', $request->status);
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json([
            'data' => $pendaftar,
            'total' => $pendaftar->count(),
            'generated_at' => now()
        ]);
    }
    
    private function analyticsReport($request)
    {
        $data = [
            'conversion_rate' => $this->getConversionRate(),
            'completion_rate' => $this->getCompletionRate(),
            'peak_hours' => $this->getPeakHours(),
            'geographic_distribution' => $this->getGeographicDistribution(),
            'generated_at' => now()
        ];
        
        return response()->json($data);
    }
    
    private function getTrendHarian($days = 7)
    {
        $trend = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = Pendaftar::whereDate('created_at', $date)->count();
            $trend[] = [
                'date' => $date->format('Y-m-d'),
                'count' => $count
            ];
        }
        return $trend;
    }
    
    private function getConversionRate()
    {
        $total = Pendaftar::count();
        $completed = Pendaftar::whereIn('status', ['LULUS', 'TIDAK_LULUS', 'CADANGAN'])->count();
        
        return $total > 0 ? round(($completed / $total) * 100, 2) : 0;
    }
    
    private function getCompletionRate()
    {
        $total = Pendaftar::count();
        $withDocuments = Pendaftar::whereHas('berkas')->count();
        
        return $total > 0 ? round(($withDocuments / $total) * 100, 2) : 0;
    }
    
    private function getPeakHours()
    {
        return Pendaftar::select(DB::raw('HOUR(created_at) as hour'), DB::raw('count(*) as total'))
            ->groupBy('hour')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
    }
    
    private function getGeographicDistribution()
    {
        // Simulasi data geografis
        return [
            ['wilayah' => 'Jakarta Pusat', 'count' => rand(20, 50)],
            ['wilayah' => 'Jakarta Selatan', 'count' => rand(15, 40)],
            ['wilayah' => 'Jakarta Timur', 'count' => rand(10, 35)],
            ['wilayah' => 'Jakarta Barat', 'count' => rand(8, 30)],
            ['wilayah' => 'Jakarta Utara', 'count' => rand(5, 25)]
        ];
    }
}