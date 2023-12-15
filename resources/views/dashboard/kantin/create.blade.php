@extends('layout.main')
@section('title', 'Tambah Kantin')
@section('content')
    <div class="container mt-3">

        <form action="" method="post">
            @method('post')
            @csrf
            <div class="mb-2">
                <div class="form-group">
                    <strong>Nama Kantin</strong>
                    {!! Form::text('nama', null, ['placeholder' => 'Nama', 'class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="mb-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="/kantin" class="btn btn-light px-3">Kembali</a>
            </div>
        </form>
    @endsection
