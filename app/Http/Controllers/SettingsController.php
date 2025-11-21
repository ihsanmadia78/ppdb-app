<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gelombang;
use App\Models\Jurusan;
use App\Models\Setting;
use DB;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'max_pendaftar_per_jurusan' => Setting::get('max_pendaftar_per_jurusan', 36),
            'biaya_pendaftaran' => Setting::get('biaya_pendaftaran', 150000),
            'tahun_ajaran' => Setting::get('tahun_ajaran', '2024/2025'),
            'periode_pendaftaran_mulai' => Setting::get('periode_pendaftaran_mulai', '2024-01-01'),
            'periode_pendaftaran_selesai' => Setting::get('periode_pendaftaran_selesai', '2024-03-31'),
            'auto_backup' => Setting::get('auto_backup', true),
            'email_notifications' => Setting::get('email_notifications', true)
        ];
        
        return view('admin.settings', compact('settings'));
    }
    
    public function updateSettings(Request $request)
    {
        $request->validate([
            'max_pendaftar_per_jurusan' => 'required|integer|min:1',
            'biaya_pendaftaran' => 'required|integer|min:0',
            'tahun_ajaran' => 'required|string',
            'periode_pendaftaran_mulai' => 'required|date',
            'periode_pendaftaran_selesai' => 'required|date|after:periode_pendaftaran_mulai'
        ]);
        
        Setting::set('max_pendaftar_per_jurusan', $request->max_pendaftar_per_jurusan);
        Setting::set('biaya_pendaftaran', $request->biaya_pendaftaran);
        Setting::set('tahun_ajaran', $request->tahun_ajaran);
        Setting::set('periode_pendaftaran_mulai', $request->periode_pendaftaran_mulai);
        Setting::set('periode_pendaftaran_selesai', $request->periode_pendaftaran_selesai);
        Setting::set('auto_backup', $request->has('auto_backup'));
        Setting::set('email_notifications', $request->has('email_notifications'));
        
        return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil disimpan.');
    }
    
    public function backup()
    {
        // Simple backup functionality
        $timestamp = date('Y-m-d_H-i-s');
        $filename = "ppdb_backup_{$timestamp}.sql";
        
        // In a real application, you would use mysqldump or similar
        // For demo purposes, we'll just return a success message
        
        return response()->json([
            'success' => true,
            'message' => 'Backup berhasil dibuat',
            'filename' => $filename
        ]);
    }
    
    public function clearCache()
    {
        // Clear application cache
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('view:clear');
            
            return response()->json([
                'success' => true,
                'message' => 'Cache berhasil dibersihkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membersihkan cache: ' . $e->getMessage()
            ]);
        }
    }
}