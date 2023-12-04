@extends('layout.main')
@section('title', 'Detail Penjualan')
@section('content')
    <div class="container-fluid mt-3">
        {{-- <a href="/menu/create" class="btn text-white" style="padding: 7px; border-radius:10px; background: #51AADD">
            + Create New
        </a> --}}
        <div class="table-responsive mt-2 bg-white p-4" style="border-radius: 20px; height:76% !important;">
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-menu"
                style="height: 10% !important">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Penjualan</th>
                        <th>ID Penjualan</th>
                        <th>Nama Kantin</th>
                        <th>ID Menu</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $m)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $m->created_at }}</td>
                            <td>{{ $m->kode_tr }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>{{ $m->kode_menu }}</td>
                            <td>{{ $m->QTY }}</td>
                            <td>Rp {{ number_format($m->subtotal_bayar) }}</td>
                            <td>{{ $m->diskon }}</td>
                            <td>{{ $m->status_konfirm }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="/detailpenjualan/{{ $m->kode_tr }}/{{ $m->kode_menu }}/edit"
                                        class="btn btn-warning btn-sm" style="color: white;">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    {{-- <form action="/detailpenjualan/{{ $m->id }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit"
                                            onclick="confirm('Yakin ingin menghapus data ini ? ')">Hapus</button>
                                    </form> --}}
                                    {{-- <form action="/detailpenjualan/{{ $m->id }}" method="post" id="delete-form">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm text-white m-0" type="submit"
                                            onclick="deleteData()">Hapus</button>
                                    </form> --}}
                                    {{-- <form action="/detailpenjualan/{{ $m->kode_tr }}" method="post" class="delete-form">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $m->id }}">
                                        <button class="btn btn-danger btn-sm m-0 delete-button" style="color: white;"
                                            type="submit">
                                            <i class="fa-solid fa-trash-can"></i> Hapus</button>
                                    </form> --}}
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
                                        this.parentNode.action = '/detailpenjualan/' + id;
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
