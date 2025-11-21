<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gelombang;

class GelombangController extends Controller
{
    public function index()
    {
        $gelombang = Gelombang::orderBy('created_at', 'desc')->get();
        return view('admin.gelombang', compact('gelombang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'kuota' => 'required|integer|min:1',
            'biaya_daftar' => 'required|integer|min:0',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        Gelombang::create([
            'nama' => $request->nama,
            'tahun' => date('Y'),
            'tgl_mulai' => $request->tanggal_mulai,
            'tgl_selesai' => $request->tanggal_selesai,
            'kuota' => $request->kuota,
            'biaya_daftar' => $request->biaya_daftar,
            'status' => $request->status
        ]);
        return redirect()->back()->with('success', 'Gelombang berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'kuota' => 'required|integer|min:1',
            'biaya_daftar' => 'required|integer|min:0',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        try {
            \DB::table('gelombang')
                ->where('id', $id)
                ->update([
                    'nama' => $request->nama,
                    'tahun' => date('Y'),
                    'tgl_mulai' => $request->tanggal_mulai,
                    'tgl_selesai' => $request->tanggal_selesai,
                    'kuota' => $request->kuota,
                    'biaya_daftar' => $request->biaya_daftar,
                    'status' => $request->status,
                    'updated_at' => now()
                ]);
            
            return redirect()->back()->with('success', 'Gelombang berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $gelombang = Gelombang::findOrFail($id);
        $gelombang->delete();
        return redirect()->back()->with('success', 'Gelombang berhasil dihapus');
    }
}