@extends('main')
@section('title', 'Edit Detail Penjualan')
@section('content')
    <div class="container mt-3">
        <form method="POST" action="/detailpenjualan/{{ $data->kode_tr }}/{{ $data->kode_menu }}" class="bg-white p-3"
            style="border-radius: 20px;" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-2">
                <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
                <input type="text" class="form-control" id="tanggal_penjualan" name="tanggal_penjualan" required
                    value="{{ $data->created_at }}" readonly>
            </div>
            <div class="mb-2">
                <label for="id_penjualan" class="form-label">ID Penjualan</label>
                <input type="text" class="form-control" id="id_penjualan" name="id_penjualan" required
                    value="{{ $data->kode_tr }}" readonly>
            </div>
            <div class="mb-2">
                <label for="id_kantin" class="form-label">Nama Kantin</label>
                <input type="text" class="form-control" id="id_kantin" name="id_kantin"
                    value="{{ $data->nama }}"readonly>
            </div>
            <div class="mb-2">
                <label for="id_menu" class="form-label">ID Menu</label>
                <input type="number" class="form-control" id="id_menu" name="id_menu"
                    value="{{ $data->kode_menu }}"readonly>
            </div>
            <div class="mb-2">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $data->QTY }}">
            </div>
            <div class="mb-2">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga"
                    value="{{ $data->subtotal_bayar }}">
            </div>
            <div class="mb-2">
                <label for="diskon" class="form-label">Diskon</label>
                <input type="number" class="form-control" id="diskon" name="diskon" value="{{ $data->diskon }}">
            </div>
            <div class="mb-2">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status"
                    value="{{ $data->status_konfirm }}">
                <select class="form-select" aria-label="Default select example" name="status" required>
                    <option value="menunggu" {{ $data->status_konfirm == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="memasak"{{ $data->status_konfirm == 'memasak' ? 'selected' : '' }}>Memasak</option>
                    <option value="selesai"{{ $data->status_konfirm == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="mb-2">
                <button type="submit" class="btn text-white" style="background: #51AADD">Ubah</button>
                <a href="/detailpenjualan" class="btn btn-light px-3">Kembali</a>
            </div>
        </form>
    </div>
@endsection
