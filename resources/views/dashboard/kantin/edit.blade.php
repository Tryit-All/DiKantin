@extends('layout.main')
@section('title', 'Edit Customer')
@section('content')
    <div class="container mt-3">
        <form class="bg-white p-4" style="border-radius: 20px;" method="POST" action="">
            @method('PUT')
            @csrf
            <div class="mb-2">
                <label for="id_customer" class="form-label">ID Customer</label>
                <input type="text" class="form-control" id="id_customer" name="id" required
                    value="{{ $kantin->id_kantin }}"readonly>
            </div>
            <div class="mb-2">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required
                    value="{{ $kantin->nama }}">
            </div>
            <button type="submit" class="btn text-white" style="background: #51AADD">Ubah</button>
            <a href="/kantin" class="btn btn-light px-3">Kembali</a>
        </form>
    </div>
@endsection
