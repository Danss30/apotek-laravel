<?php

namespace App\Http\Controllers;

use App\Models\ProdukModel;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $jenisMobil = ['Sedan', 'SUV', 'MPV', 'Hatchback', 'Truck', 'Coupe', 'Convertible'];

    public function index()
    {
        $data = ProdukModel::all();
        return view('produk.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenis = $this->jenisMobil;
        return view('produk.create', compact('jenis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'price' => 'required|numeric',
            'jenis' => 'required',
            'stock' => 'required|integer',
        ]);

        ProdukModel::create($request->all());

        return redirect()->route('produk.index')->with('success', 'Mobil berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ProdukModel::findOrFail($id);
        $jenis = $this->jenisMobil;
        return view('produk.edit', compact('data', 'jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'price' => 'required|numeric',
            'jenis' => 'required',
            'stock' => 'required|integer',
        ]);

        $produk = ProdukModel::findOrFail($id);
        $produk->update($request->all());

        return redirect()->route('produk.index')->with('success', 'Mobil berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = ProdukModel::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Mobil berhasil dihapus!');
    }
}
