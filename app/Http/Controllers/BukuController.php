<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('judul')) {
            $buku = Buku::where('judul', 'like', '%' . $request->input('judul') . '%')->get();
        } else {
            $buku = Buku::all();
        }
        return response()->json($buku);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima
    $validatedData = $request->validate([
        'judul' => 'required|string|min:1',
        'penulis' => 'required|string|max:255',
        'harga' => 'required|numeric|min:1000',
        'stok' => 'required|integer|min:0',
        'kategori_id' => 'required|exists:kategoris,id',
    ]);

    // Menyimpan data ke dalam database
    $buku = Buku::create($validatedData);

    // Mengembalikan respons dengan data buku yang baru dibuat
    return response()->json([
        'message' => 'Buku berhasil ditambahkan',
        'data' => $buku
],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);
        return response()->json($buku);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       // Validasi data yang diterima
       $validatedData = $request->validate([
        'judul' => 'sometimes|required|string|max:255',
        'penulis' => 'sometimes|required|string|max:255',
        'harga' => 'sometimes|required|numeric|min:1000',
        'stok' => 'sometimes|required|integer|min:0',
        'kategori_id' => 'sometimes|required|exists:kategoris,id',
    ]);

    // Mencari data buku berdasarkan ID
    $buku = Buku::findOrFail($id);

    // Mengupdate data buku
    $buku->update($validatedData);

    // Mengembalikan respons dengan data buku yang baru diupdate
    return response()->json([
        'message' => 'Buku berhasil diupdate',
        'data' => $buku
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mencari data buku berdasarkan ID
        $buku = Buku::findOrFail($id);

        // Menghapus data buku
        $buku->delete();

        // Mengembalikan respons bahwa buku telah dihapus
        return response()->json([
            'message' => 'Buku berhasil dihapus'
        ]);
    }

}
