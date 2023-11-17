@extends('main')
@section('title', 'Edit Customer')
@section('content')
    <div class="container mt-3">
        <form class="bg-white p-4" style="border-radius: 20px;" method="POST" action="/customer/{{ $data->id }}">
            @method('PUT')
            @csrf
            <div class="mb-2">
                <label for="id_customer" class="form-label">ID Customer</label>
                <input type="text" class="form-control" id="id_customer" name="id_customer" required
                    value="{{ $data->id_customer }}">
            </div>
            <div class="mb-2">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required
                    value="{{ $data->nama }}">
            </div>
            <div class="mb-2">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required
                    value="{{ $data->alamat }}">
            </div>
            <div class="mb-2">
                <label for="no_telepon" class="form-label">No Telepon</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon" required
                    value="{{ $data->no_telepon }}">
            </div>
            <button type="submit" class="btn text-white" style="background: #51AADD">Ubah</button>
            <a href="/customer" class="btn btn-light px-3">Kembali</a>
        </form>
    </div>
@endsection
