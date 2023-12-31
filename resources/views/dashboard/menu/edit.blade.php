@extends('layout.main')
@section('title', 'Edit Menu')
@section('content')
    <div class="container mt-3">
        <form method="POST" action="/menu/{{ $menu->id_menu }}" class="bg-white p-3" style="border-radius: 20px;"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-2">
                <label for="nama_menu" class="form-label">Menu</label>
                <input type="text" class="form-control" id="nama_menu" name="nama_menu" required
                    value="{{ $menu->nama }}">
            </div>
            <div class="mb-2">
                <label for="harga" class="form-label">Harga Jual</label>
                <input type="number" class="form-control" id="harga" name="harga" required
                    value="{{ $menu->harga }}">
            </div>
            <div class="mb-2">
                <label for="harga" class="form-label">Harga Pokok</label>
                <input type="number" class="form-control" id="harga_pokok" name="harga_pokok" required
                    value="{{ $menu->harga_pokok }}">
            </div>
            <div class="mb-2">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*"
                    value="{{ $menu->foto }}">
            </div>

            <div class="mb-2">
                <label for="stok" class="form-label">Stok</label>
                <select class="form-select" aria-label="Default select example" name="status_stok" required>
                    <option value="ada" {{ $menu->status_stok == 'ada' ? 'selected' : '' }}>Ada</option>
                    <option value="tidak ada"{{ $menu->status_stok == 'tidak ada' ? 'selected' : '' }}>Tidak Ada</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="kantin" class="form-label">Kantin</label>

                <select class="form-select" aria-label="Default select example" name="id_kantin" required>
                    <option value="{{ $menu->id_kantin }}">{{ $menu->Kantin->nama }}</option>
             @foreach ($kantin as $item)
             <option value="{{ $item->id_kantin }}">{{ $item->nama }}</option>
             @endforeach
             
                </select>
            </div>
            <div class="mb-2">
                <label for="kantin" class="form-label">Kategori</label>

                <select class="form-select" aria-label="Default select example" name="kategori" required>
              
  
             <option value="makanan">makanan</option>
             <option value="minuman">minuman</option>
    
             
                </select>
            </div>
            <div class="mb-2">
                <button type="submit" class="btn text-white" style="background: #51AADD">Ubah</button>
                <a href="/menuAll" class="btn btn-light px-3">Kembali</a>
            </div>
        </form>
    </div>
@endsection
