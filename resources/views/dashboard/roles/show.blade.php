@extends('main')
@section('title', 'Detail Role')
@section('content')
    <div class="container-fluid bg-white p-3 mt-3" style="border-radius: 20px;">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Role</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mb-2">
                <div class="form-group">
                    <strong>Nama : </strong>
                    {{ $role->name }}
                </div>
            </div>
            <div class="mb-2">
                <div class="form-group">
                    <strong>Akses : </strong>
                    @if (!empty($rolePermissions))
                        @foreach ($rolePermissions as $v)
                            <label class="label label-success">{{ $v->name }},</label>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="pull-right mb-2">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Kembali</a>
        </div>
    </div>
@endsection
