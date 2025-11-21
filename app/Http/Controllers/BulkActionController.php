<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\PendaftarStatus;
use DB;
use Mail;
use App\Mail\StatusUpdate;

class BulkActionController extends Controller
{
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'pendaftar_ids' => 'required|array',
            'pendaftar_ids.*' => 'exists:pendaftar,id',
            'new_status' => 'required|string'
        ]);
        
        $pendaftarIds = $request->pendaftar_ids;
        $newStatus = $request->new_status;
        
        DB::beginTransaction();
        
        try {
            foreach ($pendaftarIds as $id) {
                $pendaftar = Pendaftar::find($id);
                $oldStatus = $pendaftar->status;
                
                // Update status
                $pendaftar->update(['status' => $newStatus]);
                
                // Create status timeline entry
                PendaftarStatus::create([
                    'pendaftar_id' => $id,
                    'status' => $newStatus,
                    'keterangan' => 'Bulk update oleh admin',
                    'created_by' => auth()->id()
                ]);
                
                // Kirim email notifikasi
                try {
                    if ($pendaftar->email && $oldStatus !== $newStatus) {
                        Mail::to($pendaftar->email)
                            ->send(new StatusUpdate($pendaftar, $oldStatus, $newStatus));
                    }
                } catch (\Exception $e) {
                    \Log::error('Failed to send bulk status update email: ' . $e->getMessage());
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => count($pendaftarIds) . ' pendaftar berhasil diupdate'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan bulk update: ' . $e->getMessage()
            ]);
        }
    }
    
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'pendaftar_ids' => 'required|array',
            'pendaftar_ids.*' => 'exists:pendaftar,id'
        ]);
        
        $pendaftarIds = $request->pendaftar_ids;
        
        DB::beginTransaction();
        
        try {
            // Delete related records first
            PendaftarStatus::whereIn('pendaftar_id', $pendaftarIds)->delete();
            
            // Delete pendaftar
            Pendaftar::whereIn('id', $pendaftarIds)->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => count($pendaftarIds) . ' pendaftar berhasil dihapus'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus pendaftar: ' . $e->getMessage()
            ]);
        }
    }
    
    public function bulkExport(Request $request)
    {
        $request->validate([
            'pendaftar_ids' => 'required|array',
            'pendaftar_ids.*' => 'exists:pendaftar,id'
        ]);
        
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan'])
            ->whereIn('id', $request->pendaftar_ids)
            ->get();
        
        $filename = 'selected_pendaftar_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($pendaftar) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'No Pendaftaran',
                'Nama',
                'Jurusan',
                'Status',
                'Tanggal Daftar'
            ]);
            
            // Data
            foreach ($pendaftar as $p) {
                fputcsv($file, [
                    $p->no_pendaftaran,
                    $p->dataSiswa?->nama ?? '',
                    $p->jurusan?->nama ?? '',
                    $p->status,
                    $p->created_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}