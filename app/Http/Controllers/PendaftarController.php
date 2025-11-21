<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;
use App\Models\PendaftarStatus;
use App\Models\Jurusan;
use App\Models\Gelombang;
use Illuminate\Support\Str;
use DB;
use Auth;
use Mail;
use App\Mail\PendaftaranConfirmation;

class PendaftarController extends Controller
{
    public function create(Request $request)
    {
        // Get verified email from session or request
        $email = $request->input('email') ?? session('registration_email');
        
        $jurusan = Jurusan::all();
        $wilayah = \App\Models\Wilayah::orderBy('nama', 'asc')->get();
        
        // Buat gelombang default jika belum ada
        $gelombang = Gelombang::first();
        if (!$gelombang) {
            $gelombang = Gelombang::create([
                'nama' => 'Gelombang 1',
                'tahun' => date('Y'),
                'tgl_mulai' => date('Y-01-01'),
                'tgl_selesai' => date('Y-12-31'),
                'biaya_daftar' => 150000
            ]);
        }
        
        $gelombang = Gelombang::all();
        return view('pendaftaran.create', compact('jurusan', 'gelombang', 'wilayah', 'email'));
    }

   public function store(Request $r)
{
    $r->validate([
        'nama' => 'required|string|max:120',
        'nik' => 'required|string|size:16|unique:pendaftar_data_siswa,nik',
        'nisn' => 'required|string|max:20|unique:pendaftar_data_siswa,nisn',
        'jk' => 'required|in:L,P',
        'tmp_lahir' => 'required|string|max:100',
        'tgl_lahir' => 'required|date',
        'agama' => 'nullable|string|max:50',
        'alamat' => 'required|string|max:500',
        'provinsi' => 'required|string|max:100',
        'kabupaten' => 'required|string|max:100',
        'kecamatan' => 'required|string|max:100',
        'kelurahan' => 'required|string|max:100',
        'kode_pos' => 'nullable|string|max:5',
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
        'email' => 'required|email|max:255',
        'npsn_sekolah' => 'nullable|string|size:8',
        'nama_sekolah_asal' => 'required|string|max:255',
        'kabupaten_sekolah' => 'required|string|max:255',
        'nilai_rata_rata' => 'required|numeric|min:0|max:100',
        'jurusan_id' => 'required|exists:jurusan,id',
        'gelombang_id' => 'required|exists:gelombang,id',
        'ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'akta' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'foto' => 'required|file|mimes:jpg,jpeg,png|max:5120',
    ], [
        'nik.unique' => 'NIK sudah terdaftar. Siswa dengan NIK ini sudah pernah mendaftar.',
        'nik.size' => 'NIK harus 16 digit.',
        'nisn.unique' => 'NISN sudah terdaftar. Siswa dengan NISN ini sudah pernah mendaftar.',
        'nisn.required' => 'NISN wajib diisi.',
        'tmp_lahir.required' => 'Tempat lahir wajib diisi.',
        'tgl_lahir.required' => 'Tanggal lahir wajib diisi.',
        'provinsi.required' => 'Provinsi wajib diisi.',
        'kabupaten.required' => 'Kabupaten/Kota wajib diisi.',
        'kecamatan.required' => 'Kecamatan wajib diisi.',
        'kelurahan.required' => 'Kelurahan/Desa wajib diisi.',
    ]);

    try {
        DB::beginTransaction();
        
        // Debug: Log koordinat yang diterima
        \Log::info('Koordinat diterima dari form', [
            'latitude' => $r->latitude,
            'longitude' => $r->longitude,
            'has_latitude' => $r->has('latitude'),
            'has_longitude' => $r->has('longitude')
        ]);

        // Buat nomor pendaftaran unik
        $no = 'PPDB' . date('YmdHis') . strtoupper(Str::random(3));

        // Get verified user
        $user = \App\Models\User::where('email', $r->email)->where('email_verified', true)->first();
        if (!$user) {
            return back()->with('error', 'Email belum diverifikasi. Silakan verifikasi email terlebih dahulu.');
        }

        // Simpan data utama pendaftar
        $pendaftar = Pendaftar::create([
            'user_id' => $user->id,
            'no_pendaftaran' => $no,
            'email' => $r->email,
            'gelombang_id' => $r->gelombang_id,
            'jurusan_id' => $r->jurusan_id,
            'status' => 'SUBMIT',
        ]);

        // Simpan data siswa
        PendaftarDataSiswa::create([
            'pendaftar_id' => $pendaftar->id,
            'nama' => $r->nama,
            'nik' => $r->nik,
            'nisn' => $r->nisn,
            'jk' => $r->jk,
            'tmp_lahir' => $r->tmp_lahir,
            'tgl_lahir' => $r->tgl_lahir,
            'agama' => $r->agama,
            'alamat' => $r->alamat,
            'provinsi' => $r->provinsi,
            'kabupaten' => $r->kabupaten,
            'kecamatan' => $r->kecamatan,
            'kelurahan' => $r->kelurahan,
            'kode_pos' => $r->kode_pos,
            'lat' => $r->latitude,
            'lng' => $r->longitude,
            'nama_ayah' => $r->nama_ayah,
            'pekerjaan_ayah' => $r->pekerjaan_ayah,
            'hp_ayah' => $r->hp_ayah,
            'nama_ibu' => $r->nama_ibu,
            'pekerjaan_ibu' => $r->pekerjaan_ibu,
            'hp_ibu' => $r->hp_ibu,
            'npsn_sekolah' => $r->npsn_sekolah,
            'nama_sekolah_asal' => $r->nama_sekolah_asal,
            'kabupaten_sekolah' => $r->kabupaten_sekolah,
            'nilai_rata_rata' => $r->nilai_rata_rata,
        ]);

        // Upload dan simpan berkas
        $berkasTypes = ['ijazah', 'kk', 'akta', 'foto'];
        foreach ($berkasTypes as $type) {
            if ($r->hasFile($type)) {
                $file = $r->file($type);
                $filename = $pendaftar->no_pendaftaran . '_' . $type . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('berkas', $filename, 'public');
                
                \App\Models\PendaftarBerkas::create([
                    'pendaftar_id' => $pendaftar->id,
                    'jenis_berkas' => strtoupper($type),
                    'nama_berkas' => $filename,
                    'file_path' => $path,
                    'ukuran_file' => $file->getSize(),
                    'uploaded_by' => 'System'
                ]);
            }
        }

        // Tambahkan status timeline
        PendaftarStatus::create([
            'pendaftar_id' => $pendaftar->id,
            'status' => 'SUBMIT',
            'keterangan' => 'Pendaftaran berhasil dikirim',
            'updated_by' => 'System'
        ]);
        
        // Create notification for admin
        \App\Models\Notification::createNotification(
            'new_registration',
            'Pendaftar Baru',
            "Pendaftar baru: {$r->nama} telah mendaftar",
            'admin',
            null,
            ['pendaftar_id' => $pendaftar->id]
        );

        DB::commit();
        
        // Create notification for verifikator
        \App\Models\Notification::createNotification(
            'document_verification',
            'Berkas Baru',
            "Berkas dari {$r->nama} siap untuk diverifikasi",
            'verifikator',
            null,
            ['pendaftar_id' => $pendaftar->id]
        );

        // Kirim email konfirmasi
        try {
            Mail::to($r->email)->send(new PendaftaranConfirmation($pendaftar));
        } catch (\Exception $e) {
            \Log::error('Failed to send confirmation email: ' . $e->getMessage());
        }

        return redirect()->route('pendaftaran.status')->with('success', 'Pendaftaran berhasil disimpan!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
public function status()
{
    $pendaftar = \App\Models\Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang'])
        ->orderBy('id', 'desc')
        ->first();

    return view('pendaftaran.status', compact('pendaftar'));
}

public function cekStatus()
{
    return view('pendaftaran.cek-status');
}

public function cekStatusResult(Request $request)
{
    $request->validate([
        'no_pendaftaran' => 'required|string'
    ]);

    $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang', 'statusTimeline'])
        ->where('no_pendaftaran', $request->no_pendaftaran)
        ->first();

    if (!$pendaftar) {
        return back()->with('error', 'Nomor pendaftaran tidak ditemukan. Pastikan nomor yang Anda masukkan benar.');
    }

    return view('pendaftaran.cek-status', compact('pendaftar'));
}

public function edit($id)
{
    $pendaftar = Pendaftar::with(['dataSiswa'])->findOrFail($id);
    
    // Hanya bisa edit jika status masih SUBMIT
    if ($pendaftar->status !== 'SUBMIT') {
        return redirect()->route('pendaftaran.cek')->with('error', 'Data tidak dapat diubah karena sudah diverifikasi.');
    }

    $jurusan = Jurusan::all();
    $gelombang = Gelombang::all();
    
    return view('pendaftaran.edit', compact('pendaftar', 'jurusan', 'gelombang'));
}

public function update(Request $request, $id)
{
    $pendaftar = Pendaftar::with(['dataSiswa'])->findOrFail($id);
    
    // Hanya bisa update jika status masih SUBMIT
    if ($pendaftar->status !== 'SUBMIT') {
        return redirect()->route('pendaftaran.cek')->with('error', 'Data tidak dapat diubah karena sudah diverifikasi.');
    }

    $request->validate([
        'nama' => 'required|string|max:120',
        'nisn' => 'required|string|max:20|unique:pendaftar_data_siswa,nisn,' . $pendaftar->dataSiswa->id,
        'jurusan_id' => 'required|exists:jurusan,id',
        'gelombang_id' => 'required|exists:gelombang,id',
    ], [
        'nisn.unique' => 'NISN sudah terdaftar oleh siswa lain.',
        'nisn.required' => 'NISN wajib diisi.',
    ]);

    try {
        DB::beginTransaction();

        // Update data pendaftar
        $pendaftar->update([
            'gelombang_id' => $request->gelombang_id,
            'jurusan_id' => $request->jurusan_id,
        ]);

        // Update data siswa
        $pendaftar->dataSiswa->update([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'jk' => $request->jk,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
            'nama_ayah' => $request->nama_ayah,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'hp_ayah' => $request->hp_ayah,
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'hp_ibu' => $request->hp_ibu,
        ]);

        DB::commit();

        return redirect()->route('pendaftaran.cek.result', ['no_pendaftaran' => $pendaftar->no_pendaftaran])
            ->with('success', 'Data berhasil diperbarui!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

}
