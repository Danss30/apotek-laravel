@extends('layout.main')

@section('content')
<div class="container">
    <h3>Edit Customer</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('customer.update', $data->id_customer) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Customer</label>
            <input type="text" name="nama_customer" value="{{ old('nama_customer', $data->nama_customer) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Perusahaan</label>
            <select name="id_perusahaan" class="form-select" required>
                <option value="">-- Pilih Perusahaan --</option>
                @foreach($perusahaan as $p)
                    <option value="{{ $p->id_perusahaan }}" 
                        {{ $p->id_perusahaan == $data->id_perusahaan ? 'selected' : '' }}>
                        {{ $p->nama_perusahaan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ old('alamat', $data->alamat) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('customer.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
