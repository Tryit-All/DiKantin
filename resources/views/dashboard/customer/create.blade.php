@extends('layout.main')
@section('title', 'Tambah Customer')
@section('content')
    <div class="container mt-3">
        <form class="bg-white p-4" method="POST" action="/prosesCustomer" style="border-radius: 20px;">
            @csrf
            <div class="mb-2">
                <label for="id_customer" class="form-label">ID Customer</label>
                <input type="text" class="form-control" id="id_customer" name="id_customer"readonly value="{{ $newId }}" required>
            </div>
            <div class="mb-2">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-2">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>
            <div class="mb-2">
                <label for="no_telepon" class="form-label">No Telepon</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
            </div>
            <button type="submit" class="btn text-white" style="background: #51AADD; " onClick="store()">Simpan</button>
            <a href="/pelanggan" class="btn btn-light px-3">Kembali</a>
        </form>
    </div>
@endsection
