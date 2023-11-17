
@extends('main')
@section('content')
    <div class="container mt-3">
        <form method="POST" action="/user" class="bg-white p-3" style="border-radius: 20px;" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="passwor" class="form-label">Roles</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto" required accept="image/*">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">ID Kantin</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn text-white" style="background: #51AADD">Simpan</button>
                <a href="/home" class="btn btn-light px-3">Kembali</a>
            </div>
        </form>
    </div>
@endsection
