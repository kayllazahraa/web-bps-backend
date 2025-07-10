<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublikasiController extends Controller
{
    public function index()
    {
        return Publikasi::all();
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'releaseDate' => 'required|date',
            'description' => 'nullable|string',
            'coverUrl' => 'nullable|url',
        ]);
        $publikasi = Publikasi::create($validated);
        return response()->json($publikasi, 201);
    }

    //menampilkan detail publikasi
    public function detail($id) {
        $publikasi = Publikasi::find($id);

        if (!$publikasi) {
            return response()->json(['message'=> 'Publikasi tidak ditemukan'],404);
        }
        return response()->json($publikasi, 200);
    }

    //mengedit data publikasi
    public function edit(Request $request, $id) {
        $publikasi = Publikasi::find($id);

        if (!$publikasi) {
            return response()->json(['message'=> 'Publikasi tidak ditemukan'],404);
        }

        //validasi input sama seperti saat menambahkan
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'releaseDate' => 'required|date',
            'description' => 'nullable|string',
            'coverUrl' => 'nullable|url',
        ]);

        $publikasi->update($validated);
        return response()->json($publikasi, 200);
    }

    //menghapus publikasi
    public function hapus($id) {
        $publikasi = Publikasi::find($id);
        if (!$publikasi) {
            return response()->json(['message'=> 'Publikasi tidak ditemukan'],404);
        }
        $publikasi->delete();
        return response()->json(['massage' => 'Publikasi berhasil dihapus'], 200);
    }
}
