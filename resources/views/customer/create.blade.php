@extends('layout.main')

@section('content')
<br>
<br>
<div class="container mt-4" >
    <h3>Tambah Customer</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Customer</label>
            <input type="text" name="nama_customer" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Perusahaan</label>
            <select name="id_perusahaan" class="form-select" required>
                <option value="id_perusahaan">-- Pilih Perusahaan --</option>
                @foreach ($perusahaan as $p)
                    <option value="{{ $p->id_perusahaan }}">{{ $p->nama_perusahaan }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('customer.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
