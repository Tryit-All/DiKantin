@extends('main')
@section('title', 'Tambah Role')
@section('content')
    <div class="container mt-3">
        <form method="POST" action="{{ route('roles.store') }}" class="bg-white p-3" style="border-radius: 20px;"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-2">
                <div class="form-group">
                    <strong>Nama</strong>
                    {!! Form::text('name', null, ['placeholder' => 'Nama', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="mb-2">
            <div class="form-group">
                <strong>Akses</strong>
                <br />
                <label class="mb-2">{{ Form::checkbox('select_all', 1, false, ['id' => 'select-all']) }} Pilih Semua</label>
                <br />
                @foreach ($permission as $value)
                    <label>{{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name']) }}
                        {{ $value->name }}</label>
                    <br />
                @endforeach
            </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-dark text-white">Simpan</button>
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

        </form>
    </div>
@endsection
