<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\PendaftarBerkas;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    public function index($pendaftar_id)
    {
        $pendaftar = Pendaftar::with(['dataSiswa', 'berkas'])->findOrFail($pendaftar_id);
        
        if ($pendaftar->status !== 'SUBMIT') {
            return redirect()->route('pendaftaran.cek')->with('error', 'Berkas tidak dapat diubah karena sudah diverifikasi.');
        }

        return view('pendaftaran.berkas', compact('pendaftar'));
    }

    public function store(Request $request, $pendaftar_id)
    {
        $pendaftar = Pendaftar::findOrFail($pendaftar_id);
        
        if ($pendaftar->status !== 'SUBMIT') {
            return back()->with('error', 'Berkas tidak dapat diubah karena sudah diverifikasi.');
        }

        $request->validate([
            'jenis_berkas' => 'required|in:ijazah,rapor,kip_kks,akta_kelahiran,kartu_keluarga',
            'file_berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $file = $request->file('file_berkas');
        $fileName = time() . '_' . $request->jenis_berkas . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('berkas/' . $pendaftar_id, $fileName, 'public');

        PendaftarBerkas::create([
            'pendaftar_id' => $pendaftar_id,
            'nama_berkas' => $this->getNamaBerkas($request->jenis_berkas),
            'jenis_berkas' => $request->jenis_berkas,
            'file_path' => $filePath,
            'ukuran_file' => $file->getSize()
        ]);

        return back()->with('success', 'Berkas berhasil diupload!');
    }

    public function destroy($id)
    {
        $berkas = PendaftarBerkas::findOrFail($id);
        
        if ($berkas->pendaftar->status !== 'SUBMIT') {
            return back()->with('error', 'Berkas tidak dapat dihapus karena sudah diverifikasi.');
        }

        Storage::disk('public')->delete($berkas->file_path);
        $berkas->delete();

        return back()->with('success', 'Berkas berhasil dihapus!');
    }

    private function getNamaBerkas($jenis)
    {
        $nama = [
            'ijazah' => 'Ijazah/SKHUN',
            'rapor' => 'Rapor Semester Terakhir',
            'kip_kks' => 'KIP/KKS',
            'akta_kelahiran' => 'Akta Kelahiran',
            'kartu_keluarga' => 'Kartu Keluarga'
        ];

        return $nama[$jenis] ?? $jenis;
    }
}