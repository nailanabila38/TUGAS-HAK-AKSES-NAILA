<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::all();
        $total = Ruangan::count();
        $aktif = Ruangan::where('status', 'Aktif')->count();
        $proyektor = Ruangan::where('proyektor', 'Tersedia')->count();
        $pc = Ruangan::where('pc', 'Tersedia')->count();

        return view('rooms', compact('ruangan', 'total', 'aktif', 'proyektor', 'pc'));
    }

    public function create()
    {
        return view('tambah-ruang');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gedung' => 'required|max:50',
            'nomor_ruang' => 'required|max:20',
            'kapasitas' => 'required|integer|min:1',
            'proyektor' => 'required|in:Tersedia,Tidak Ada',
            'pc' => 'required|in:Tersedia,Tidak Ada',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        Ruangan::create([
            'gedung' => $request->gedung,
            'nomor_ruang' => $request->nomor_ruang,
            'kapasitas' => $request->kapasitas,
            'proyektor' => $request->proyektor,
            'pc' => $request->pc,
            'status' => $request->status,
        ]);

        return redirect('/rooms');
    }

    // Menampilkan form edit berdasarkan ID
    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('edit-ruang', compact('ruangan'));
    }

    // Memproses update data ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'gedung' => 'required|max:50',
            'nomor_ruang' => 'required|max:20',
            'kapasitas' => 'required|integer|min:1',
            'proyektor' => 'required|in:Tersedia,Tidak Ada',
            'pc' => 'required|in:Tersedia,Tidak Ada',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $ruangan = Ruangan::findOrFail($id);
        $ruangan->update([
            'gedung' => $request->gedung,
            'nomor_ruang' => $request->nomor_ruang,
            'kapasitas' => $request->kapasitas,
            'proyektor' => $request->proyektor,
            'pc' => $request->pc,
            'status' => $request->status,
        ]);

        return redirect('/rooms');
    }

    // Menghapus data ruangan
    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        return redirect('/rooms');
    }
}