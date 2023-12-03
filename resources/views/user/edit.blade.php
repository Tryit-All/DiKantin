@extends('main')
@section('title', 'Edit User')
@section('content')
    <div class="container mt-3 bg-white p-3" style="border-radius: 20px">
        {!! Form::model($user, [
            'method' => 'PATCH',
            'route' => ['users.update', $user->id_user],
            'enctype' => 'multipart/form-data',
        ]) !!}
        {{-- {{ csrf_field() }} --}}
        @csrf
        <div class="row">
            <div class="mb-2">
                <div class="form-group">
                    <strong>Nama</strong>
                    {!! Form::text('username', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="mb-2">
                <div class="form-group">
                    <strong>Email</strong>
                    {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="mb-2">
                <div class="form-group">
                    <strong>Password <small>( Masukkan Ulang Password )</small></strong>
                    {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="mb-2">
                <div class="form-group">
                    <strong>Konfirmasi Password <small>( Masukkan Ulang Password )</small></strong>
                    {!! Form::password('confirm-password', [
                        'placeholder' => 'Konfirmasi Password',
                        'class' => 'form-control',
                        'required' => true,
                    ]) !!}
                </div>
            </div>
            <div class="mb-2">
                <div class="form-group">
                    <strong>Foto</strong>
                    {!! Form::file('foto', null, ['placeholder' => 'Foto', 'class' => 'form-control-file', ' accept' => 'image/*']) !!}
                    {{-- {!! Form::file('foto', ['class' => 'form-control-file', 'accept' => 'image/*']) !!} --}}
                </div>
            </div>
            <div class="mb-2">
                <div class="form-group">
                    <strong>ID Kantin</strong>
                    {!! Form::number('id_kantin', null, ['placeholder' => 'ID Kantin', 'class' => 'form-control', 'min' => 0]) !!}
                </div>
            </div>
            @if (auth()->user()->id == 1)
                <div class="mb-2">
                    <div class="form-group">
                        <strong>Role</strong>
                        {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control', 'multiple']) !!}
                    </div>
                </div>
            @else
                <div class="mb-2 d-none">
                    <div class="form-group">
                        <strong>Role</strong>
                        {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control', 'multiple']) !!}
                    </div>
                </div>
            @endif
            <div class="mb-2 text-left">
                <button type="submit" class="btn btn-primary">Ubah</button>
                <a href="/users" class="btn btn-light px-3">Kembali</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
