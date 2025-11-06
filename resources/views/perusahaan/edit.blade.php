@extends('layout.main')

@section('content')
<div class="container">
    <h3>Edit Data Perusahaan</h3>

    {{-- Menampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('perusahaan.update', $data->id_perusahaan) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="form-control"
                   value="{{ old('nama_perusahaan', $data->nama_perusahaan) }}" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ old('alamat', $data->alamat) }}</textarea>
        </div>

        <div class="mb-3">
            <label>No. Telepon</label>
            <input type="text" name="no_telp" class="form-control"
                   value="{{ old('no_telp', $data->no_telp) }}" required>
        </div>

        <div class="mb-3">
            <label>Fax</label>
            <input type="text" name="fax" class="form-control"
                   value="{{ old('fax', $data->fax) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('perusahaan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
