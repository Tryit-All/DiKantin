@extends('main')
@section('title', 'Edit Role')
@section('content')
    <div class="container mt-3">
        {!! Form::model($role, [
            'method' => 'PATCH',
            'route' => ['roles.update', $role->id],
            'class' => 'bg-white p-3',
            'style' => 'border-radius : 20px',
        ]) !!}
        <div class="mb-2">
            <div class="form-group">
                <strong>Role</strong>
                {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="mb-2">
            <div class="form-group">
                <strong>Akses</strong>
                <br />
                <label class="mb-2">{{ Form::checkbox('select_all', 1, false, ['id' => 'select-all']) }} Pilih Semua</label>
                <br />
                @foreach ($permission as $value)
                    <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'name']) }}
                        {{ $value->name }}</label>
                    <br />
                @endforeach
            </div>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn text-white" style="background: #51AADD">Ubah</button>
            <a href="{{ route('roles.index') }}" class="btn btn-light px-3">Kembali</a>
        </div>
        <script>
            $(document).ready(function() {
                $('#select-all').change(function() {
                    if ($(this).is(':checked')) {
                        $('.name').prop('checked', true);
                    } else {
                        $('.name').prop('checked', false);
                    }
                });
            });
        </script>
        {!! Form::close() !!}
    </div>
@endsection
