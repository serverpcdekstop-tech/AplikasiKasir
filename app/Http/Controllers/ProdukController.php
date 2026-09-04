<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Produk::with('kategori')->latest()->get();
        $kategori = Kategori::latest()->get();

        return view('pages.produk', compact('data', 'kategori'));
    }

    public function customer()
    {
        $data = Produk::with('kategori')
            ->where('status', 1)
            ->where('stok', '>', 0)
            ->latest()
            ->get();

        $kategori = Kategori::latest()->get();

        return view('pages.customer', compact('data', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Kategori::latest()->get();
        return view('detail.add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'kategori_id' => 'required',
            'kode' => 'required|unique:produks,kode',
            'nama' => 'required',
            'gambar' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'status' => 'required',
        ], [
            'kategori_id.required' => 'Harap masukan kategori',
            'kode.required' => 'Kode produk di perlukan untuk analisa',
            'nama.required' => 'Harap masukan nama produk',
            'gambar.required' => 'Gambar di butuhkan untuk keperluan pelanggan',
            'harga.required' => 'Masukan harga produk',
            'stok.required' => 'Masukan jumlah stok minimum(1)',
            'deskripsi.required' => 'Masukan deskripsi produk (-)',
            'status.required' => 'Masukan Status'
        ]);

        //upload gambar
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('gambar', 'public');

            $validated['gambar'] = basename($gambar);
        }

        Produk::create($validated);
        return redirect()->route('pages.produk')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'kategori_id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'deskripsi' => 'nullable',
            'status' => 'required',
        ]);

        $produk->update([
            'kategori_id' => $request->kategori_id,
            'kode' => $request->kode,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);
        return redirect()
            ->route('pages.produk')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('pages.produk')->with('success', 'kategori berhasil di hapus');
    }
}
