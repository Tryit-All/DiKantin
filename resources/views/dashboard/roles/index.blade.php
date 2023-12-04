@extends('layout.main')
@section('title', 'Role')
@section('content')
    <div class="container-fluid mt-3">
        <a href="{{ route('roles.create') }}" class="btn btn-dark text-white" style="padding: 7px; border-radius:10px;"> +
            Tambah role baru
        </a>
        {{-- @can('role-create')
            <a class="btn text-white" href="{{ route('roles.create') }}"
                style="padding: 7px; border-radius:10px; background: #51AADD"> + Create New Role</a>
        @endcan --}}
        <div class="table-responsive mt-2 bg-white p-4" style="border-radius: 20px; height:76%; !important;">
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-user">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('roles.show', $role->id) }}">Detail</a>
                                @can('role-edit')
                                    <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                                @endcan
                                @can('role-delete')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                                    {!! Form::submit('Hapus', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                @endcan
                            </td>
                        </tr>
                    @endforeach --}}
                    @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}">Detail</a>
                                @can('role-edit')
                                    <a class="btn btn-warning btn-sm" style="color: white;"
                                        href="{{ route('roles.edit', $role->id) }}"><i class="fa-solid fa-pen-to-square"></i>
                                        Edit</a>
                                @endcan
                                @can('role-delete')
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['roles.destroy', $role->id],
                                        'style' => 'display:inline',
                                        'id' => 'delete-form-' . $role->id,
                                    ]) !!}
                                    {!! Form::button(' <i class="fa-solid fa-trash-can"></i> Hapus', [
                                        'class' => 'btn btn-danger btn-sm m-0',
                                        'style' => 'color: white',
                                        'onclick' => "deleteData($role->id)",
                                    ]) !!}
                                    {!! Form::close() !!}
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    <script>
                        function deleteData(id) {
                            Swal.fire({
                                title: 'Hapus Data?',
                                // text: "Data yang sudah dihapus tidak bisa dikembalikan lagi!",
                                icon: 'warning',
                                showCancelButton: true,
                                showCloseButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Hapus',
                                cancelButtonText: 'Batal',
                                customClass: {
                                    container: 'my-swal'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('delete-form-' + id).submit(); // Submit form untuk menghapus data
                                }
                            });
                        }
                    </script>
                </tbody>
            </table>
            {!! $roles->render() !!}

        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#table-user').DataTable()
        });
    </script>
@endpush
