@extends('layout.main')

@section('content')
<div class="container mt-4">
    <h3>Data Customer</h3>
    <a href="{{ route('customer.create') }}" class="btn btn-primary mb-3">Tambah Customer</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Customer</th>
                <th>Perusahaan</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $c)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $c->nama_customer }}</td>
                <td>{{ $c->perusahaan ? $c->perusahaan->nama_perusahaan : '-' }}</td>
                <td>{{ $c->alamat }}</td>
                <td>
                    <a href="{{ route('customer.edit', $c->id_customer) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('customer.destroy', $c->id_customer) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
