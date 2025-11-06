@extends('layout.main')

@section('content')

<br>
<br>
<div class="container">
    
    <h3>📄 Daftar Faktur Penjualan</h3>
    <a href="{{ route('penjualan.create') }}" class="btn btn-primary mb-3">+ Tambah Faktur</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No Faktur</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Perusahaan</th>
                <th>Grand Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fakturs as $faktur)
            <tr>
                <td>{{ $faktur->no_faktur }}</td>
                <td>{{ $faktur->tgl_faktur }}</td>
                <td>{{ $faktur->customer->nama_customer ?? '-' }}</td>
                <td>{{ $faktur->perusahaan->nama_perusahaan }}</td>
                <td>{{ number_format($faktur->grand_total) }}</td>
                <td>
                    <a href="{{ route('penjualan.show',$faktur->no_faktur) }}" class="btn btn-success btn-sm">Preview</a>
                    <form action="{{ route('penjualan.destroy',$faktur->no_faktur) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
