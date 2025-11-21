<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wilayah;

class WilayahController extends Controller
{
    public function index()
    {
        $wilayah = Wilayah::orderBy('nama', 'asc')->get();
        return view('admin.wilayah', compact('wilayah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:wilayah,nama',
            'kode' => 'required|string|max:10|unique:wilayah,kode'
        ]);

        Wilayah::create($request->all());
        return redirect()->back()->with('success', 'Wilayah berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:wilayah,nama,' . $id,
            'kode' => 'required|string|max:10|unique:wilayah,kode,' . $id
        ]);

        $wilayah = Wilayah::findOrFail($id);
        $wilayah->update($request->all());
        return redirect()->back()->with('success', 'Wilayah berhasil diupdate');
    }

    public function destroy($id)
    {
        $wilayah = Wilayah::findOrFail($id);
        $wilayah->delete();
        return redirect()->back()->with('success', 'Wilayah berhasil dihapus');
    }
}