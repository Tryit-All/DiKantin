@extends('main')
@section('content')
    <div class="container mt-3">
        {!! Form::model($user, [
            'method' => 'PATCH',
            'route' => ['users.update', $user->id],
            'class' => 'bg-white p-3',
            'style' => 'border-radius: 20px;',
        ]) !!}
        {{-- <div class="row"> --}}
        <div class="mb-2">
            <div class="form-group">
                <strong>Nama</strong>
                {!! Form::text('name', null, ['placeholder' => 'Nama', 'class' => 'form-control']) !!}
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
                <strong>Password</strong>
                {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="mb-2">
            <div class="form-group">
                <strong>KOnfirmasi Password</strong>
                {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="mb-2">
            <div class="form-group">
                <strong>Role</strong>
                {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control', 'multiple']) !!}
            </div>
        </div>
        <div class="mb-2">
            <button type="submit" class="btn btn-primary">Ubah</button>
            <a href="{{ route('users.index') }}" class="btn btn-light px-3">Kembali</a>
        </div>
        {{-- </div> --}}
    </div>
    {!! Form::close() !!}
@endsection
