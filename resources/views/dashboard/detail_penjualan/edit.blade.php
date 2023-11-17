@extends('main')
@section('title', 'Edit Detail Penjualan')
@section('content')
    <div class="container mt-3">
        <form method="POST" action="/detailpenjualan/{{ $data->id }}" class="bg-white p-3" style="border-radius: 20px;"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-2">
                <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
                <input type="date" class="form-control" id="tanggal_penjualan" name="tanggal_penjualan" required
                    value="{{ $data->tanggal_penjualan }}">
            </div>
            <div class="mb-2">
                <label for="id_penjualan" class="form-label">ID Penjualan</label>
                <input type="number" class="form-control" id="id_penjualan" name="id_penjualan" required
                    value="{{ $data->id_penjualan }}">
            </div>
            <div class="mb-2">
                <label for="id_kantin" class="form-label">ID Kantin</label>
                <input type="number" class="form-control" id="id_kantin" name="id_kantin" value="{{ $data->id_kantin }}">
            </div>
            <div class="mb-2">
                <label for="id_menu" class="form-label">ID Menu</label>
                <input type="number" class="form-control" id="id_menu" name="id_menu" value="{{ $data->id_menu }}">
            </div>
            <div class="mb-2">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $data->jumlah }}">
            </div>
            <div class="mb-2">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" value="{{ $data->harga }}">
            </div>
            <div class="mb-2">
                <label for="diskon" class="form-label">Diskon</label>
                <input type="number" class="form-control" id="diskon" name="diskon" value="{{ $data->diskon }}">
            </div>
            <div class="mb-2">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" value="{{ $data->status }}">
                <select class="form-select" aria-label="Default select example" name="status" required>
                    <option value="proses" {{ $data->status == 'proses' ? 'selected' : '' }}>proses</option>
                    <option value="selesai"{{ $data->status == 'selesai' ? 'selected' : '' }}>selesai</option>
                </select>
            </div>
            <div class="mb-2">
                <button type="submit" class="btn text-white" style="background: #51AADD">Ubah</button>
                <a href="/detailpenjualan" class="btn btn-light px-3">Kembali</a>
            </div>
        </form>
    </div>
@endsection
