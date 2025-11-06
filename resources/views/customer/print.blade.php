{{-- @extends('layout.main')

@section('content') --}}
<!DOCTYPE html>
<html>
<head>
    <title>Preview Data Customer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        @media print {
            button { display: none; }
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h3 class="mb-3">Data Customer</h3>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Customer</th>
                <th>Perusahaan</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_customer }}</td>
                <td>{{ $item->perusahaan_cust }}</td>
                <td>{{ $item->alamat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <button class="btn btn-success" onclick="window.print()">Cetak</button>
</div>
</body>
</html>
{{-- @endsection --}}
