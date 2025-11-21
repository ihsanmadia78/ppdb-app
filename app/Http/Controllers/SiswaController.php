<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SiswaController extends Controller
{
    public function showLogin()
    {
        return view('siswa.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek apakah email ada di tabel pendaftar
        $pendaftar = Pendaftar::where('email', $request->email)->first();
        
        if (!$pendaftar) {
            return back()->with('error', 'Email tidak terdaftar sebagai calon siswa.');
        }

        // Cek apakah ada user dengan email ini dan role siswa
        $user = User::where('email', $request->email)->where('role', 'siswa')->first();
        
        if (!$user) {
            // Buat user siswa otomatis jika belum ada
            $user = User::create([
                'name' => $pendaftar->dataSiswa->nama ?? $pendaftar->email,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'siswa'
            ]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('siswa.profil');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('siswa.login');
    }



    public function profil()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang', 'pembayaran'])
                             ->where('email', $user->email)
                             ->first();
        
        return view('siswa.profil', compact('pendaftar'));
    }

    public function timeline()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang', 'pembayaran'])
                             ->where('email', $user->email)
                             ->first();
        
        return view('siswa.timeline', compact('pendaftar'));
    }

    public function biodata()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang'])
                             ->where('email', $user->email)
                             ->first();
        
        return view('siswa.biodata', compact('pendaftar'));
    }

    public function cetakKartu()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang'])
                             ->where('email', $user->email)
                             ->first();
        
        if (!$pendaftar) {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $pdf = \PDF::loadView('siswa.kartu-peserta', compact('pendaftar'));
        return $pdf->download('kartu-peserta-' . $pendaftar->no_pendaftaran . '.pdf');
    }

    public function pembayaran()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang', 'pembayaran'])
                             ->where('email', $user->email)
                             ->first();
        
        if (!$pendaftar) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        return view('siswa.pembayaran', compact('pendaftar'));
    }

    public function uploadPembayaran(Request $request)
    {
        $request->validate([
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'metode_pembayaran' => 'required|in:transfer,va,qris'
        ]);

        try {
            $user = Auth::user();
            $pendaftar = Pendaftar::with('gelombang')->where('email', $user->email)->first();
            
            if (!$pendaftar) {
                return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan.');
            }

            if ($request->hasFile('bukti_bayar')) {
                // Upload file
                $file = $request->file('bukti_bayar');
                $filename = 'bukti_bayar_' . $pendaftar->no_pendaftaran . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('pembayaran', $filename, 'public');

                // Hapus pembayaran lama jika ada
                Pembayaran::where('pendaftar_id', $pendaftar->id)->delete();

                // Tentukan nominal biaya
                $nominal = $pendaftar->gelombang->biaya_daftar ?? 150000;

                // Buat pembayaran baru
                $pembayaran = Pembayaran::create([
                    'pendaftar_id' => $pendaftar->id,
                    'nominal' => $nominal,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'bukti_bayar' => $path,
                    'status' => 'paid',
                    'tanggal_bayar' => now()
                ]);

                // Update status pendaftar
                $pendaftar->update(['status' => 'VERIFIKASI_PEMBAYARAN']);

                // Kirim notifikasi ke keuangan (opsional)
                try {
                    \DB::table('notifications')->insert([
                        'title' => 'Pembayaran Baru dari Portal Siswa',
                        'message' => 'Pembayaran dari ' . $pendaftar->nama . ' (' . $pendaftar->no_pendaftaran . ') telah diupload dan menunggu verifikasi.',
                        'type' => 'payment',
                        'data' => json_encode([
                            'pendaftar_id' => $pendaftar->id,
                            'pembayaran_id' => $pembayaran->id,
                            'nominal' => $nominal,
                            'metode' => $request->metode_pembayaran
                        ]),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } catch (\Exception $e) {
                    // Ignore notification error
                }

                return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload! Status: Menunggu Verifikasi Pembayaran. Tim keuangan akan memproses dalam 1-2 hari kerja.');
            }

            return redirect()->back()->with('error', 'File bukti pembayaran tidak ditemukan.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload bukti pembayaran: ' . $e->getMessage());
        }
    }
    
    public function cetakBuktiPembayaran()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang', 'pembayaran'])
                             ->where('email', $user->email)
                             ->first();
        
        if (!$pendaftar || !$pendaftar->pembayaran) {
            return redirect()->route('siswa.pembayaran')->with('error', 'Data pembayaran tidak ditemukan');
        }
        
        $data = [
            'pembayaran' => $pendaftar->pembayaran,
            'tanggal_cetak' => date('d/m/Y H:i')
        ];
        
        $pdf = \PDF::loadView('admin.bukti-pembayaran-pdf', $data);
        return $pdf->download('bukti_pembayaran_' . $pendaftar->no_pendaftaran . '.pdf');
    }

    public function perbaikanBerkas()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with(['dataSiswa', 'berkas'])
                             ->where('email', $user->email)
                             ->first();
        
        if (!$pendaftar) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        return view('siswa.perbaikan-berkas', compact('pendaftar'));
    }

    public function perbaikanBerkasStore(Request $request)
    {
        $request->validate([
            'ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'akta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);

        try {
            $user = Auth::user();
            $pendaftar = Pendaftar::where('email', $user->email)->first();
            
            if (!$pendaftar || $pendaftar->status != 'BERKAS_DITOLAK') {
                return redirect()->back()->with('error', 'Perbaikan berkas hanya untuk status BERKAS_DITOLAK.');
            }

            $berkasTypes = ['ijazah', 'kk', 'akta', 'foto'];
            $updated = false;

            foreach ($berkasTypes as $type) {
                if ($request->hasFile($type)) {
                    $file = $request->file($type);
                    $filename = $pendaftar->no_pendaftaran . '_' . $type . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('berkas', $filename, 'public');
                    
                    // Update atau create berkas
                    \App\Models\PendaftarBerkas::updateOrCreate(
                        [
                            'pendaftar_id' => $pendaftar->id,
                            'jenis_berkas' => strtoupper($type)
                        ],
                        [
                            'nama_berkas' => $filename,
                            'file_path' => $path,
                            'ukuran_file' => $file->getSize(),
                            'uploaded_by' => 'Siswa'
                        ]
                    );
                    $updated = true;
                }
            }

            if ($updated) {
                // Update status kembali ke SUBMIT untuk diverifikasi ulang
                $pendaftar->update(['status' => 'SUBMIT']);
                
                // Tambah timeline
                \App\Models\PendaftarStatus::create([
                    'pendaftar_id' => $pendaftar->id,
                    'status' => 'SUBMIT',
                    'keterangan' => 'Berkas diperbaiki oleh siswa, menunggu verifikasi ulang',
                    'updated_by' => 'Siswa'
                ]);

                return redirect()->route('siswa.dashboard')->with('success', 'Berkas berhasil diperbaiki! Status dikembalikan ke SUBMIT untuk verifikasi ulang.');
            }

            return redirect()->back()->with('error', 'Tidak ada berkas yang diupload.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbaiki berkas: ' . $e->getMessage());
        }
    }
}