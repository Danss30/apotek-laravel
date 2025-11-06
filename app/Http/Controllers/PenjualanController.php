<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\FakturModel;
use App\Models\DetailFakturModel;
use App\Models\CustomerModel;
use App\Models\Perusahaan;
use App\Models\ProdukModel;

class PenjualanController extends Controller
{
    // Tampilkan daftar faktur
    public function index()
    {
        $fakturs = FakturModel::with('customer', 'perusahaan', 'user', 'detail.produk')->get();
        return view('penjualan.index', compact('fakturs'));
    }

    // Form tambah faktur
    public function create()
    {
        $customers = CustomerModel::all();
        $perusahaan = Perusahaan::all();
        $produk = ProdukModel::all();
        return view('penjualan.create', compact('customers', 'perusahaan', 'produk'));
    }

    // Simpan faktur baru
    public function store(Request $request)
{
    $request->validate([
        'id_customer' => 'required|exists:customer,id_customer',
        'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
        'tgl_faktur' => 'required|date',
        'due_date' => 'required|date',
        'metode_pembayaran' => 'required|string',
        'produk' => 'required|array',
        'qty' => 'required|array',
        // jika ingin validasi persentase:
        'ppn' => 'nullable|numeric|min:0',
        'dp' => 'nullable|numeric|min:0',
    ]);

    $no_faktur = 'F' . time();

    // Hitung subtotal dari produk & siapkan data detail
    $subtotal = 0;
    $produk_data = [];

    foreach ($request->produk as $i => $id_produk) {
        $produkItem = ProdukModel::find($id_produk);
        if (!$produkItem) {
            return back()->withErrors(["Produk dengan ID {$id_produk} tidak ditemukan."]);
        }

        $qty = (int) ($request->qty[$i] ?? 0);
        if ($qty <= 0) {
            return back()->withErrors(["Qty untuk produk {$produkItem->nama_produk} tidak valid."]);
        }

        // cek stok cukup
        if (isset($produkItem->stock) && $produkItem->stock < $qty) {
            return back()->withErrors(["Stok produk {$produkItem->nama_produk} tidak mencukupi. Tersedia: {$produkItem->stock}"]);
        }

        $subtotal_produk = (float) $produkItem->price * $qty;
        $subtotal += $subtotal_produk;

        // simpan data detail sementara (jangan simpan 'subtotal' kalau kolom tidak ada)
        $produk_data[] = [
            'no_faktur' => $no_faktur,
            'id_produk'  => $id_produk,
            'qty'        => $qty,
            'price'      => $produkItem->price,
            // 'subtotal' => $subtotal_produk, // uncomment jika kolom ada
        ];
    }

    // Hitung nilai PPN & DP berdasarkan persen dari form (form mu memakai persen)
    $ppnPercent = is_numeric($request->ppn) ? (float)$request->ppn : 0; // contoh: 11
    $dpPercent  = is_numeric($request->dp)  ? (float)$request->dp  : 0; // contoh: 30

    $ppnValue = $subtotal * ($ppnPercent / 100);
    $dpValue  = ($subtotal + $ppnValue) * ($dpPercent / 100);

    $grand_total = ($subtotal + $ppnValue) - $dpValue;
    if ($grand_total < 0) $grand_total = 0;

    // Simpan semua dalam transaction agar konsisten
    DB::beginTransaction();
    try {
        $faktur = FakturModel::create([
            'no_faktur' => $no_faktur,
            'tgl_faktur' => $request->tgl_faktur,
            'due_date' => $request->due_date,
            'metode_pembayaran' => $request->metode_pembayaran,
            'ppn' => $ppnValue,
            'dp' => $dpValue,
            'grand_total' => $grand_total,
            'id_user' => auth()->id_user ?? 1,
            'id_customer' => $request->id_customer,
            'id_perusahaan' => $request->id_perusahaan,
        ]);

        // Simpan detail dan kurangi stok
        foreach ($produk_data as $detail) {
            DetailFakturModel::create($detail);

            // kurangi stok dengan cara aman
            $p = ProdukModel::find($detail['id_produk']);
            if ($p) {
                // pastikan kolom stock ada; ganti 'stock' ke 'stok' jika nama kolommu 'stok'
                $p->decrement('stock', $detail['qty']);
            }
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        // log error kalau perlu: \Log::error($e);
        return back()->withErrors(['error' => 'Gagal menyimpan faktur: ' . $e->getMessage()]);
    }

    return redirect()->route('penjualan.index')->with('success', 'Faktur berhasil dibuat!');
}

    // Preview/cetak faktur
    public function show($no_faktur)
    {
        $faktur = FakturModel::with('customer', 'perusahaan', 'user', 'detail.produk')
            ->where('no_faktur', $no_faktur)->firstOrFail();
        return view('penjualan.print', compact('faktur'));
    }

    // Form edit faktur
    public function edit($no_faktur)
    {
        $faktur = FakturModel::with('detail')->where('no_faktur', $no_faktur)->firstOrFail();
        $customers = CustomerModel::all();
        $perusahaan = Perusahaan::all();
        $produk = ProdukModel::all();
        return view('penjualan.edit', compact('faktur', 'customers', 'perusahaan', 'produk'));
    }

    // Update faktur
    public function update(Request $request, $no_faktur)
    {
        $request->validate([
            'id_customer' => 'required',
            'id_perusahaan' => 'required',
            'tgl_faktur' => 'required',
            'due_date' => 'required',
            'metode_pembayaran' => 'required',
            'produk' => 'required|array',
            'qty' => 'required|array',
        ]);

        $faktur = FakturModel::where('no_faktur', $no_faktur)->firstOrFail();

        // hitung grand total baru
        $grand_total = 0;
        foreach ($request->produk as $i => $id_produk) {
            $produkItem = ProdukModel::find($id_produk);
            if (!$produkItem) {
                return back()->withErrors("Produk dengan ID $id_produk tidak ditemukan.");
            }
            $grand_total += $produkItem->price * $request->qty[$i];
        }

        $ppn = round($grand_total * 0.11);
        $dp = $request->dp ?? 0;

        // update faktur
        $faktur->update([
            'tgl_faktur' => $request->tgl_faktur,
            'due_date' => $request->due_date,
            'metode_pembayaran' => $request->metode_pembayaran,
            'ppn' => $ppn,
            'dp' => $dp,
            'grand_total' => $grand_total + $ppn - $dp,
            'id_customer' => $request->id_customer,
            'id_perusahaan' => $request->id_perusahaan,
        ]);

        // hapus detail lama
        $faktur->detail()->delete();

        // simpan detail baru
        foreach ($request->produk as $i => $id_produk) {
            $produkItem = ProdukModel::find($id_produk);
            DetailFakturModel::create([
                'no_faktur' => $no_faktur,
                'id_produk' => $produkItem->id,
                'qty' => $request->qty[$i],
                'price' => $produkItem->price,
                'subtotal' => $produkItem->price * $request->qty[$i],
            ]);
            
        }
        

        return redirect()->route('penjualan.index')->with('success', 'Faktur berhasil diperbarui!');
    }

    // Hapus faktur
    public function destroy($no_faktur)
    {
        $faktur = FakturModel::where('no_faktur', $no_faktur)->firstOrFail();
        $faktur->detail()->delete();
        $faktur->delete();

        return redirect()->route('penjualan.index')->with('success', 'Faktur berhasil dihapus!');
    }
}
