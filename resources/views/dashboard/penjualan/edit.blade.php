@extends('main')
@section('title', 'Edit Penjualan')
@section('content')
    <div class="container mt-3">
        <form method="POST" action="/penjualan/{{ $data->id }}" class="bg-white p-3" style="border-radius: 20px;"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-2">
                <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
                <input type="date" class="form-control" id="tanggal_penjualan" name="tanggal_penjualan" required
                    value="{{ $data->tanggal_penjualan }}">
            </div>
            <div class="mb-2">
                <label for="nomer_penjualan" class="form-label">No Penjualan</label>
                <input type="number" class="form-control" id="nomer_penjualan" name="nomer_penjualan" required
                    value="{{ $data->nomer_penjualan }}">
            </div>
            <div class="mb-2">
                <label for="id_customer" class="form-label">ID Customer</label>
                <input type="number" class="form-control" id="id_customer" name="id_customer" accept="image/*"
                    value="{{ $data->id_customer }}">
            </div>
            <div class="mb-2">
                <label for="id_kasir" class="form-label">ID Kasir</label>
                <input type="number" class="form-control" id="id_kasir" name="id_kasir" value="{{ $data->id_kasir }}">
            </div>
            <div class="mb-2">
                <label for="subtotal" class="form-label">Subtotal</label>
                <input type="number" class="form-control" id="subtotal" name="subtotal" value="{{ $data->subtotal }}">
            </div>
            <div class="mb-2">
                <label for="diskon" class="form-label">Diskon</label>
                <input type="number" class="form-control" id="diskon" name="diskon" value="{{ $data->diskon }}">
            </div>
            <div class="mb-2">
                <label for="total" class="form-label">Total</label>
                <input type="number" class="form-control" id="total" name="total" value="{{ $data->total }}">
            </div>
            <div class="mb-2">
                <label for="bayar" class="form-label">Bayar</label>
                <input type="number" class="form-control" id="bayar" name="bayar" value="{{ $data->bayar }}">
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
