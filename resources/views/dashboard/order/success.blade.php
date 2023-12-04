@extends('layout.main')
@section('title', 'Selesai Order')
@section('content')
    <div class="container-fluid mt-2">
        <div class="table-responsive mt-3 bg-white p-4" style="border-radius: 20px; height:76% !important;">
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-menu"
                style="height: 10% !important">
                <thead>
                    <tr>
                        @php
                            $no = 1;
                        @endphp
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Tanggal Order</th>
                        <th>Tanggal Diterima</th>
                        <th>Customer</th>
                        <th>kurir</th>
                        <th>Detail</th>
                        <th>Pembayaran</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $d->Kode_Tr }}</td>
                            <td>{{ $d->Tanggal_Order }}</td>
                            <td>{{ $d->Tanggal_Selesai }}</td>
                            <td>{{ $d->Customer }}</td>
                            <td>{{ $d->Kurir }}</td>
                            <td>{{ $d->Detail }}</td>
                            <td>{{ $d->Pembayaran }}</td>
                            <td>Rp {{ number_format($d->Total) }}</td>
                            <td>
                                @if ($d->Status == 'kirim')
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="" method="">
                                            {{-- @method('DELETE') --}}
                                            @csrf
                                            <button class="btn btn-warning" type="submit" id="konfirmasi-button"
                                                onclick="confirm('Apakah anda ingin menyelesaikan Transaksi ? ')"
                                                disabled>{{ $d->Status }}</button>
                                        </form>
                                    </div>
                                @elseif ($d->Status == 'terima')
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="" method="">
                                            @csrf
                                            <button class="btn btn-primary" id=""
                                                disabled>{{ $d->Status }}</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if ($d->Kode_Tr == $d->Bukti && $d->SK == '2' && $d->SP == '3')
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="/success/{{ $d->Kode_Tr }}" method="POST">
                                            {{-- @method('DELETE') --}}
                                            @csrf
                                            <button class="btn btn-success btn-sm" type="submit" id="konfirmasi-button"
                                                onclick="confirm('Apakah anda ingin menyelesaikan Transaksi ? ')">Konfirmasi</button>
                                        </form>
                                    </div>
                                @elseif ($d->Bukti == null && $d->SK == '2' && $d->SP == '3')
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="" method="">
                                            @csrf
                                            <button class="btn btn-outline-success btn-sm" id="">Validasi
                                                Kurir</button>
                                        </form>
                                    </div>
                                @elseif ($d->Bukti == 'Done' && $d->SK == '3' && $d->SP == '3')
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="" method="">
                                            @csrf
                                            <button class="btn btn-success" id="" disabled>Transaksi
                                                Selesai</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="/trouble/{{ $d->Kode_Tr }}" method="POST">
                                            @csrf
                                            <button class="btn btn-secondary btn-sm" type="submit" id="konfirmasi-button"
                                                onclick="confirm('Apakah anda ingin mengulang validasi transaksi ? ')">Tidak
                                                Valid</button>
                                        </form>
                                    </div>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                    <script>
                        const deleteButtons = document.querySelectorAll('.konfirmasi-button');

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
                                        this.parentNode.action = '/allOrder/' + id;
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

        function reload() {
            var totalAwal = 0;
            $.ajax({
                url: "/api/updateselesai",
                type: "GET",
                method: "GET",
                data: {},
                success: function(response) {
                    totalAwal = response;
                    console.log(response);
                }
            })

            setInterval(() => {

                $.ajax({
                    url: "/api/updateselesai",
                    type: "GET",
                    method: "GET",
                    data: {},
                    success: function(response) {
                        if (totalAwal != response) {
                            location.reload();
                        }
                        console.log(response);
                    }
                })

            }, 3000);
        }

        reload();
    </script>
@endpush
