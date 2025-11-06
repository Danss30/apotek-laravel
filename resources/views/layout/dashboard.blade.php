@extends('layout.main')

@section('content')
<div class="container">
    <br>
    <h3>Selamat Datang di <b>Aplikasi Apotek</b></h3>
    <p>Gunakan menu di sisi kiri untuk mengelola data apotek Anda.</p>

    <div class="row mt-4">
        {{-- Perusahaan / Supplier --}}
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h5>
                        <i class="bi bi-building fs-3 text-primary"></i>
                        <br>Perusahaan / Supplier
                    </h5>
                    <p>Kelola data perusahaan pemasok obat</p>
                    <a href="{{ url('/perusahaan') }}" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>

        {{-- Customer / Pasien --}}
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h5>
                        <i class="bi bi-people fs-3 text-success"></i>
                        <br>Customer / Pasien
                    </h5>
                    <p>Kelola data pelanggan atau pasien apotek</p>
                    <a href="{{ url('/customer') }}" class="btn btn-success btn-sm">Kelola</a>
                </div>
            </div>
        </div>

        {{-- Produk / Obat --}}
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h5>
                        <i class="bi bi-capsule fs-3 text-warning"></i>
                        <br>Produk / Obat
                    </h5>
                    <p>Kelola daftar obat dan produk apotek</p>
                    <a href="{{ url('/produk') }}" class="btn btn-warning btn-sm text-white">Kelola</a>
                </div>
            </div>
        </div>

        {{-- Penjualan --}}
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h5>
                        <i class="bi bi-cash-stack fs-3 text-danger"></i>
                        <br>Penjualan
                    </h5>
                    <p>Catat dan kelola transaksi penjualan obat</p>
                    <a href="{{ url('/penjualan') }}" class="btn btn-danger btn-sm">Kelola</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
