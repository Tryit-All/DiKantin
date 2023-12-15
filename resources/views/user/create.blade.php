@extends('main')
@section('title', 'Tambah User')
@section('content')
    <div class="container mt-3">
        {!! Form::open([
            'route' => 'users.store',
            'method' => 'POST',
            'enctype' => 'multipart/form-data',
            'class' => 'bg-white p-3',
            'style' => 'border-radius: 20px;',
        ]) !!}

        {{ csrf_field() }}
        <div class="mb-2">
            <div class="form-group">
                <strong>Nama</strong>
                {!! Form::text('name', null, ['placeholder' => 'Nama', 'class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="mb-2">
            <div class="form-group">
                <strong>Username</strong>
                {!! Form::text('username', null, ['placeholder' => 'Username', 'class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="mb-2">
            <div class="form-group">
                <strong>Email</strong>
                {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="mb-2">
            <div class="form-group">
                <strong>Password</strong>
                {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="mb-2">
            <div class="form-group">
                <strong>Konfirmasi Password</b></strong>
                {!! Form::password('confirm-password', [
                    'placeholder' => 'Konfirmasi Password',
                    'class' => 'form-control',
                    'required' => true,
                ]) !!}
            </div>
        </div>
        <div class="mb-2">
            <div class="form-group">
                <strong>Role</strong>

                {!! Form::select('roles[]', $roles, [], ['class' => 'form-control', 'multiple', 'required' => true]) !!}
            </div>
        </div>

        <div class="mb-2">
            <div class="form-group">
                <strong>Foto</strong>
                {!! Form::file('foto', null, ['placeholder' => 'Foto', 'class' => 'form-control mt-2', 'accept' => 'image/*']) !!}
            </div>
        </div>
        <div class="mb-2">
            <div class="form-group">


                <label for="exampleFormControlSelect1">Pilih Kantin</label>
                <select class="form-control" id="exampleFormControlSelect1"name="id_kantin">
                    <option value=""></option>
                    @foreach ($kantin as $item)
                    <option value="{{ $item->id_kantin }}">{{ $item->nama }}</option>
                    @endforeach
              

                </select>

            </div>
        </div>
        <div class="mb-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/users" class="btn btn-light px-3">Kembali</a>
        </div>
        {{-- <div class="mb-1">
            <button type="submit" class="btn text-white" style="background: #51AADD">Simpan</button>
            <a href="{{ route('users.index') }}" class="btn btn-light px-1">Kembali</a>
        </div> --}}

        {{-- {!! Form::open(['route' => 'users.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

        <div class="mb-1">
            <div class="form-group">
                <strong>Name:</strong>
                {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="mb-1">
            <div class="form-group">
                <strong>Email:</strong>
                {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="mb-1">
            <div class="form-group">
                <strong>Password:</strong>
                {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="mb-1">
            <div class="form-group">
                <strong>Confirm Password:</strong>
                {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="mb-3">
            <div class="form-group">
                <strong>Role:</strong>
                {!! Form::select('roles[]', $roles, [], ['class' => 'form-control', 'multiple']) !!}
            </div>
        </div>

        <div class="mb-3">
            <div class="form-group">
                <strong>Foto:</strong>
                {!! Form::file('foto', null, ['placeholder' => 'Foto', 'class' => 'form-control', ' accept' => 'image/*']) !!}
            </div>
        </div>
        <div class="mb-3">
            <div class="form-group">
                <strong>ID Kantin:</strong>
                {!! Form::number('id_kantin', null, ['placeholder' => 'ID Kantin', 'class' => 'form-control', 'min' => 0]) !!}
            </div>
        </div>

        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

    </div>
    {!! Form::close() !!} --}}
        {!! Form::close() !!}
    @endsection
