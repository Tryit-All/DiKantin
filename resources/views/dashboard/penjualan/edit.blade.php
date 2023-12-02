@extends('main')
@section('title', 'Edit Penjualan')
@section('content')
    <div class="container mt-3">
        <form method="POST" action="/penjualan/{{ $data->kode_tr }}" class="bg-white p-3" style="border-radius: 20px;"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-2">
                <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
                <input type="text" class="form-control" id="tanggal_penjualan" name="tanggal_penjualan" required
                    value="{{ $data->created_at }}"readonly>
            </div>
            <div class="mb-2">
                <label for="nomer_penjualan" class="form-label">No Penjualan</label>
                <input type="text" class="form-control" id="nomer_penjualan" name="nomer_penjualan" required
                    value="{{ $data->kode_tr }}"readonly>
            </div>
            <div class="mb-2">
                <label for="id_customer" class="form-label">ID Customer</label>
                <input type="text" class="form-control" id="id_customer" name="id_customer" accept="image/*"
                    value="{{ $data->id_customer }}"readonly>
            </div>
            <div class="mb-2">
                <label for="id_kasir" class="form-label">ID Kasir</label>
                <input type="text" class="form-control" id="id_kasir" name="id_kasir"
                    value="{{ $data->id_kasir }}"readonly>
            </div>
            <div class="mb-2">
                <label for="id_kurir" class="form-label">ID Kurir</label>
                <input type="text" class="form-control" id="id_kurir" name="id_kurir"
                    value="{{ $data->id_kurir }}"readonly>
            </div>
            <div class="mb-2">
                <label for="subtotal" class="form-label">Subtotal</label>
                <input type="number" class="form-control" id="subtotal" name="subtotal" value="{{ $data->total_harga }}">
            </div>
            <div class="mb-2">
                <label for="diskon" class="form-label">Diskon</label>
                <input type="number" class="form-control" id="diskon" name="diskon" value="{{ $data->diskon }}">
            </div>
            <div class="mb-2">
                <label for="kembalian" class="form-label">Kembalian</label>
                <input type="number" class="form-control" id="kembalian" name="kembalian" value="{{ $data->kembalian }}">
            </div>
            <div class="mb-2">
                <label for="total_bayar" class="form-label">Bayar</label>
                <input type="number" class="form-control" id="total_bayar" name="total_bayar"
                    value="{{ $data->total_bayar }}">
            </div>
            <div class="mb-2">
                <label for="model_pembayaran" class="form-label">Model Pembayaran</label>
                <input type="text" class="form-control" id="model_pembayaran" name="model_pembayaran"
                    value="{{ $data->model_pembayaran }}">
            </div>
            <div class="mb-2">
                <label for="no_meja" class="form-label">No Meja</label>
                <input type="number" class="form-control" id="no_meja" name="no_meja" value="{{ $data->no_meja }}">
            </div>
            <div class="mb-2">
                <button type="submit" class="btn text-white" style="background: #51AADD">Ubah</button>
                <a href="/penjualan" class="btn btn-light px-3">Kembali</a>
            </div>
        </form>
    </div>
@endsection
