<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangans = Lapangan::all(); 
        return view('admin.lapangan.index', compact('lapangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga_per_jam' => 'required|numeric',
            'kapasitas' => 'required|integer',
            'gambar' => 'required|image|mimes:jpg,png,jpeg|max:2048', 
        ]);

        $gambarPath = $request->file('gambar')->store('images/lapangan', 'public');

        $data = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga_per_jam' => $request->harga_per_jam,
            'kapasitas' => $request->kapasitas,
            'gambar' => $gambarPath, 
        ];


        Lapangan::create($data);

        return redirect()->route('lapangan-page')->with('success', 'Lapangan created successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga_per_jam' => 'required|numeric',
            'kapasitas' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', 
        ]);

        $lapangan = Lapangan::findOrFail($id);

        $lapangan->nama = $request->nama;
        $lapangan->deskripsi = $request->deskripsi;
        $lapangan->harga_per_jam = $request->harga_per_jam;
        $lapangan->kapasitas = $request->kapasitas;

        if ($request->hasFile('gambar')) {
            if ($lapangan->gambar && file_exists(storage_path('app/public/' . $lapangan->gambar))) {
                unlink(storage_path('app/public/' . $lapangan->gambar));
            }

            $gambarPath = $request->file('gambar')->store('images/lapangan', 'public');
            $lapangan->gambar= $gambarPath;
        }


        $lapangan->save();
        return redirect()->route('lapangan-page')->with('success', 'Lapangan updated successfully!');
    }

    public function destroy($id)
    {
        try {
            $lapangan = Lapangan::findOrFail($id);
            if ($lapangan->gambar && file_exists(storage_path('app/public/' . $lapangan->gambar))) {
                unlink(storage_path('app/public/' . $lapangan->gambar));
            }
            $lapangan->delete();
            return redirect()->route('lapangan-page');
        } catch (\Exception $e) {
            return redirect()->route('lapangan-page');
        }
    }
}
