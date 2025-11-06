@extends('layout.main')

@section('content')
<br>
<br>
<div class="container">
    <h3>Tambah Produk / Obat</h3>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('produk.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Obat</label>
            <input type="text" name="nama_produk" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Harga (Rp)</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jenis Obat</label>
            <select name="jenis" class="form-select" required>
                <option value="">-- Pilih Jenis Obat --</option>
                <option value="Tablet">Tablet</option>
                <option value="Kapsul">Kapsul</option>
                <option value="Sirup">Sirup</option>
                <option value="Salep">Salep</option>
                <option value="Injeksi">Injeksi</option>
                <option value="Obat Tetes">Obat Tetes</option>
                <option value="Serbuk">Serbuk</option>
                <option value="Krim">Krim</option>
                <option value="Gel">Gel</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">💾 Simpan</button>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">↩️ Kembali</a>
    </form>
</div>
@endsection
