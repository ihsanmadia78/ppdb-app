<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::all();
        return view('admin.jurusan', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|max:10|unique:jurusan,kode',
        ]);

        Jurusan::create([
            'nama' => $request->nama,
            'kode' => strtoupper($request->kode),
        ]);

        return redirect()->route('admin.jurusan')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|max:10|unique:jurusan,kode,'.$jurusan->id,
        ]);

        $jurusan->update([
            'nama' => $request->nama,
            'kode' => strtoupper($request->kode),
        ]);

        return redirect()->route('admin.jurusan')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Jurusan::findOrFail($id)->delete();
        return redirect()->route('admin.jurusan')->with('success', 'Jurusan berhasil dihapus.');
    }
}
