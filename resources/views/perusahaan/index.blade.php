@extends('layout.main')

@section('content')
<div class="container mt-4">
    <h3>🏢 Data Perusahaan</h3>
    <a href="{{ route('perusahaan.create') }}" class="btn btn-primary mb-3">+ Tambah Perusahaan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Fax</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_perusahaan }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->no_telp }}</td>
                <td>{{ $item->fax }}</td>
                <td>
                    <a href="{{ route('perusahaan.edit', $item->id_perusahaan) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('perusahaan.destroy', $item->id_perusahaan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
