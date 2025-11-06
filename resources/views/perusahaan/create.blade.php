@extends('layout.main')

@section('content')

<div class="container mt-4">
    <h3>Tambah Data Perusahaan</h3>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('perusahaan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>
       <div class="mb-3">
        <label>No. Telepon</label>
         <input type="text" name="no_telp" class="form-control">
        </div>

        <div class="mb-3">
            <label>Fax</label>
            <input type="text" name="fax" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('perusahaan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
