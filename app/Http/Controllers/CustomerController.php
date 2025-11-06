<?php

namespace App\Http\Controllers;


use App\Models\CustomerModel;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $customers = CustomerModel::with('perusahaan')->get();
    return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perusahaan = Perusahaan::all();
        return view('customer.create', compact('perusahaan'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama_customer' => 'required',
            'alamat' => 'required'
        ]);

        CustomerModel::create([
            'nama_customer' => $request->nama_customer,
            'id_perusahaan' => $request->id_perusahaan,
            'alamat' => $request->alamat, // kasih default

        ]);

        return redirect('/customer')->with('success', 'Data Customer berhasil ditambahkan!');
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
     public function edit($id)
    {
        $data = CustomerModel::findOrFail($id);
        $perusahaan = Perusahaan::all();
        return view('customer.edit', compact('data', 'perusahaan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_customer' => 'required',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
            'alamat' => 'required',
        ]);

        $data = CustomerModel::findOrFail($id);
        $data->update([
            'nama_customer' => $request->nama_customer,
            'id_perusahaan' => $request->id_perusahaan,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('customer.index')->with('success', 'Customer berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = CustomerModel::findOrFail($id);
        $customer->delete();

        return redirect()->route('customer.index')
            ->with('success', 'Data perusahaan berhasil dihapus!');
    }
    public function print()
    {
        $data = CustomerModel::all();
        return view('customer.print', compact('data'));
    }
}
