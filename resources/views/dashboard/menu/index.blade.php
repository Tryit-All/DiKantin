@extends('layout.main')
@section('title', 'Menu')
@section('content')
    <div class="container-fluid mt-3">
        <a href="/menu/create" class="btn btn-dark text-white" style="padding: 7px; border-radius:10px;">
            + Tambah menu baru
        </a>
        <div class="table-responsive mt-2 bg-white p-4" style="border-radius: 20px; height:76% !important;">
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-menu"
                style="height: 10% !important">
                <thead>
                    <tr>
                        @php
                            $no = 1;
                        @endphp
                        <th>No</th>
                        <th>Menu</th>
                        <th>Harga Jual</th>
                        <th>Harga Pokok</th>
                        <th>Foto</th>
                        <th>Stok</th>
                        <th>Kantin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menu as $m)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>Rp {{ number_format($m->harga) }}</td>
                            <td>Rp {{ number_format($m->harga_pokok) }}</td>
                            <td>
                                <img src="{{ url($m->foto) }}" style="width: 70px; height: 70px; object-fit: cover;"
                                    alt="" class="rounded-circle">

                            </td>
                            <td>{{ $m->status_stok }}</td>
                            <td>{{ $m->id_kantin }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-1" style="color: white;">
                                    <a href="/menu/{{ $m->id_menu }}/edit" class="btn btn-warning btn-sm"
                                        style="color: white;">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    {{-- <form action="/menu/{{ $m->id }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit"
                                            onclick="confirm('Yakin ingin menghapus data ini ? ')">Hapus</button>
                                    </form> --}}
                                    {{-- <form action="/menu/{{ $m->id }}" method="post" id="delete-form">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit"
                                            onclick="deleteData()">Hapus</button>
                                    </form> --}}
                                    <form action="/menu/{{ $m->id_menu }}" method="post" class="delete-form">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $m->id_menu }}">
                                        <button class="btn btn-danger btn-sm m-0 delete-button" type="submit">
                                            <i class="fa-solid fa-trash-can"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <script>
                        const deleteButtons = document.querySelectorAll('.delete-button');

                        deleteButtons.forEach(button => {
                            button.addEventListener('click', function(event) {
                                event.preventDefault();

                                const id = this.parentNode.querySelector('input[name="id"]').value;

                                Swal.fire({
                                    title: 'Hapus Data?',
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
                                        this.parentNode.action = '/menu/' + id;
                                        this.parentNode.submit();
                                    }
                                });
                            });
                        });
                    </script>
                </tbody>
            </table>

        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#table-menu').DataTable();
        });
    </script>
@endpush
