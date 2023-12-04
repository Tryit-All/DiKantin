@extends('layout.main')
@section('title', 'Transaksi')
@section('content')
    <div class="container-fluid mt-3">
        <div class="table-responsive mt-2 bg-white p-4" style="border-radius: 20px; height:76% !important;">
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-menu"
                style="height: 10% !important">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Penjualan</th>
                        <th>Kasir</th>
                        <th>No Penjualan</th>
                        <th>No Meja</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembali</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td> {{ auth()->user()->name }} </td>
                            <td>{{ $item->kode_tr }}</td>
                            <td>{{ $item->no_meja }}</td>
                            <td>Rp {{ number_format($item->total_harga) }}</td>
                            <td>Rp {{ number_format($item->total_bayar) }}</td>
                            <td>Rp {{ number_format($item->kembalian) }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    {{-- <button class="btn btn-info btn-sm text-white m-0" type="submit">Cetak Ulang
                                        Nota</button> --}}
                                    <a href="/transaksi/{{ $item->kode_tr }}" target="_blank" class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-print"></i> Cetak Ulang Nota
                                    </a>
                                    <form action="/transaksi/{{ $item->kode_tr }}" method="post" class="delete-form">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">

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
                                        this.parentNode.action = '/transaksi/' + id;
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
