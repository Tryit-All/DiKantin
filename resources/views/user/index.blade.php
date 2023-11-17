@extends('main')
@section('title', 'User')
@section('content')
    <div class="container-fluid mt-3">
        @if (auth()->user()->id == 1 || auth()->user()->id == 4)
            <a href="{{ route('users.create') }}" class="btn btn-dark text-white" style="padding: 7px; border-radius:10px;"> +
                Tambah User
            </a>
        @endif

        <div class="table-responsive mt-2 bg-white p-4" style="border-radius: 20px; height:76%; !important;">
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-user">
                <thead>
                    <tr>
                        @php
                            $no = 1;
                        @endphp
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Username</th>
                        <th>ID Kantin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data as $key => $user)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <label class="badge badge-success" style="color:#514D4E;">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->id_kantin }}</td>
                            <td>
                                {{-- @if (auth()->user()->roles == 'Admin') --}}
                                @if (auth()->user()->id == 1 || auth()->user()->id == 4)
                                    {{-- <a class="btn btn-info" href="{{ route('users.show', $user->id) }}">Detail</a> --}}
                                    <a class="btn btn-warning btn-sm" style="color: white;"
                                        href="{{ route('users.edit', $user->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['users.destroy', $user->id],
                                        'style' => 'display:inline',
                                        'id' => 'delete-form-' . $user->id,
                                    ]) !!}
                                    {!! Form::button('<i class="fa-solid fa-trash-can"></i> Hapus', [
                                        'class' => 'btn btn-danger btn-sm m-0 ',
                                        'style' => 'color: white',
                                        'onclick' => "deleteData($user->id)",
                                    ]) !!}
                                    {!! Form::close() !!}
                                @else
                                    {{-- <a class="btn btn-info" href="{{ route('users.show', $user->id) }}">Detail</a> --}}
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
            {{-- {!! $data->render() !!} --}}
        </div>
    </div>
@endsection

@push('script')
    <script>
        function deleteData(id) {
            Swal.fire({
                title: 'Hapus Data?',
                // text: "Data yang sudah dihapus tidak bisa dikembalikan lagi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                showCloseButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: {
                    container: 'my-swal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit(); // Submit form untuk menghapus data
                }
            });
        }

        $(document).ready(function() {
            $('#table-user').DataTable()
        });
    </script>
@endpush
