<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Perusahaan::all();
        return view('perusahaan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('perusahaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama_perusahaan' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'fax' => 'required'
        ]);

        Perusahaan::create([
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp ?? '-', // kasih default
            'fax' => $request->fax,
        ]);

        return redirect('/perusahaan')->with('success', 'Data perusahaan berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
       $data = Perusahaan::findOrFail($id);
        return view('perusahaan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
         $request->validate([
            'nama_perusahaan' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'fax' => 'required',
        ]);

        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->update([
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'fax' => $request->fax,
        ]);

        return redirect()->route('perusahaan.index')
                         ->with('success', 'Data perusahaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
{
    $perusahaan = Perusahaan::findOrFail($id);
    $perusahaan->delete();

    return redirect()->route('perusahaan.index')
                     ->with('success', 'Data perusahaan berhasil dihapus!');
}

}
