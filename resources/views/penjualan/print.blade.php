<!DOCTYPE html>
<html>
<head>
    <title>Faktur {{ $faktur->no_faktur }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h3>Faktur Penjualan</h3>
    <p><strong>No Faktur:</strong> {{ $faktur->no_faktur }}</p>
    <p><strong>Tanggal:</strong> {{ $faktur->tgl_faktur }}</p>
    <p><strong>Customer:</strong> {{ $faktur->customer->nama_customer }}</p>
    <p><strong>Perusahaan:</strong> {{ $faktur->perusahaan->nama_perusahaan }}</p>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faktur->detail as $d)
            <tr>
                <td>{{ $d->produk->nama_produk }}</td>
                <td>{{ $d->qty }}</td>
                <td>{{ number_format($d->price) }}</td>
                <td>{{ number_format($d->qty * $d->price) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>PPN:</strong> {{ number_format($faktur->ppn) }}</p>
    <p><strong>DP:</strong> {{ number_format($faktur->dp) }}</p>
    <p><strong>Grand Total:</strong> {{ number_format($faktur->grand_total) }}</p>
</div>
</body>
</html>
