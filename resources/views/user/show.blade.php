@extends('main')
@section('title', 'Detail User')
@section('content')
    <div class="container bg-white p-3 mt-3" style="border-radius: 20px">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>USER</h2>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="mb-2">
                <div class="form-group">
                    <strong>Nama : </strong>
                    {{ $user->name }}
                </div>
            </div>
            <div class="mb-2">
                <div class="form-group">
                    <strong>Email : </strong>
                    {{ $user->email }}
                </div>
            </div>
            <div class="mb-2">
                <div class="form-group">
                    <strong>Roles : </strong>
                    @if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $v)
                            <label class="badge" style="color: #514D4E;">{{ $v }}</label>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}">Kembali</a>
        </div>
    </div>
@endsection
