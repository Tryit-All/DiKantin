@extends('main')
@section('title', 'Tambah Menu')
@section('content')
    <div class="container-fluid mt-3">
        <form method="POST" action="/menuCreate" class="bg-white p-3" style="border-radius: 20px;"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-2">
                <label for="nama_menu" class="form-label">Menu</label>
                <input type="text" class="form-control" id="nama_menu" name="nama" required>
            </div>
            <div class="mb-2">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="mb-2">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
            </div>
            <div class="mb-2">
                <label for="stok" class="form-label">Stok</label>
                <select class="form-select" aria-label="Default select example" name="status_stok" required>
                    <option value="">Stok</option>
                    <option value="ada">Ada</option>
                    <option value="tidak ada">tidak ada</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="kantin" class="form-label">Kantin</label>
                <select class="form-select" aria-label="Default select example" name="id_kantin" required>
                    <option value="">Pilih Kantin</option>
                    <option value="1">Kantin 1</option>
                    <option value="2">Kantin 2</option>
                    <option value="3">Kantin 3</option>
                    <option value="4">Kantin 4</option>
                    <option value="5">Kantin 5</option>
                    <option value="6">Kantin 6</option>
                    <option value="7">Kantin 7</option>
                    <option value="8">Kantin 8</option>
                    <option value="9">Kantin 9</option>
                </select>
            </div>
            <div class="mb-2">
                <button type="submit" class="btn btn-dark text-white">Simpan</button>
                <a href="/menuAll" class="btn btn-light px-3">Kembali</a>
            </div>
        </form>
    </div>
@endsection
