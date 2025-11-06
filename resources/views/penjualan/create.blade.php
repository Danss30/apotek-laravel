@extends('layout.main')

@section('content')
<div class="container mt-4">
    <h3>➕ Tambah Faktur Penjualan Obat</h3>

    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf

        {{-- Customer & Perusahaan --}}
        <div class="mb-3">
            <label>Customer</label>
            <select name="id_customer" class="form-control" required>
                <option value="">-- Pilih Customer --</option>
                @foreach($customers as $c)
                    <option value="{{ $c->id_customer }}">{{ $c->nama_customer }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Perusahaan</label>
            <select name="id_perusahaan" class="form-control" required>
                <option value="">-- Pilih Perusahaan --</option>
                @foreach($perusahaan as $p)
                    <option value="{{ $p->id_perusahaan }}">{{ $p->nama_perusahaan }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal --}}
        <div class="mb-3">
            <label>Tanggal Faktur</label>
            <input type="date" name="tgl_faktur" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>

        {{-- Metode Pembayaran --}}
        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="">-- Pilih Metode --</option>
                <option value="Cash">Cash</option>
                <option value="Transfer">Transfer</option>
                <option value="Kredit">Kredit</option>
            </select>
        </div>

        <hr>
        <h5>Produk</h5>
        <table class="table table-bordered" id="produk-table">
            <thead>
                <tr>
                    <th>Produk Mobil</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="produk[]" class="form-control produk-select" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produk as $pr)
                                <option value="{{ $pr->id_produk }}" data-price="{{ $pr->price }}">
                                    {{ $pr->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="qty[]" class="form-control qty-input" value="1" min="1" required></td>
                    <td class="price">0</td>
                    <td class="subtotal">0</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-secondary btn-sm" id="add-row">Tambah Produk</button>

        {{-- PPN & DP --}}
        <div class="mb-3 mt-3">
            <label>PPN (%)</label>
            <input type="number" name="ppn" id="ppn" class="form-control" value="11">
        </div>

        <div class="mb-3">
            <label>DP (%)</label>
            <input type="number" name="dp" id="dp" class="form-control" value="30">
        </div>

        <div class="mb-3">
            <label>Grand Total:</label>
            <p id="grand-total">0</p>
        </div>

        <div class="mb-3">
            <label>DP (Rp):</label>
            <p id="dp-total">0</p>
        </div>

        <div class="mb-3">
            <label>Sisa Bayar (Rp):</label>
            <p id="sisa-bayar">0</p>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Faktur</button>
    </form>
</div>

<script>
    function updateTotals(){
        let grandTotal = 0;
        document.querySelectorAll('#produk-table tbody tr').forEach(row => {
            let price = parseInt(row.querySelector('.produk-select').selectedOptions[0]?.dataset.price || 0);
            let qty = parseInt(row.querySelector('.qty-input').value || 0);
            let subtotal = price * qty;
            row.querySelector('.price').innerText = price.toLocaleString();
            row.querySelector('.subtotal').innerText = subtotal.toLocaleString();
            grandTotal += subtotal;
        });

        // PPN
        let ppn = parseFloat(document.getElementById('ppn').value || 0);
        let totalWithPpn = grandTotal + (grandTotal * ppn / 100);
        document.getElementById('grand-total').innerText = totalWithPpn.toLocaleString();

        // DP
        let dpPercent = parseFloat(document.getElementById('dp').value || 0);
        let dpTotal = totalWithPpn * dpPercent / 100;
        document.getElementById('dp-total').innerText = dpTotal.toLocaleString();

        // Sisa Bayar
        let sisa = totalWithPpn - dpTotal;
        document.getElementById('sisa-bayar').innerText = sisa.toLocaleString();
    }

    // Event listeners
    document.getElementById('add-row').addEventListener('click', function(){
        let table = document.getElementById('produk-table').getElementsByTagName('tbody')[0];
        let newRow = table.rows[0].cloneNode(true);
        newRow.querySelectorAll('select').forEach(el => el.selectedIndex = 0);
        newRow.querySelectorAll('input').forEach(el => el.value = 1);
        newRow.querySelector('.price').innerText = '0';
        newRow.querySelector('.subtotal').innerText = '0';
        table.appendChild(newRow);
        updateTotals();
    });

    document.addEventListener('change', function(e){
        if(e.target.classList.contains('produk-select') || e.target.classList.contains('qty-input') || e.target.id === 'ppn' || e.target.id === 'dp'){
            updateTotals();
        }
    });

    document.addEventListener('click', function(e){
        if(e.target.classList.contains('remove-row')){
            e.target.closest('tr').remove();
            updateTotals();
        }
    });

    // Inisialisasi totals
    updateTotals();
</script>
@endsection
