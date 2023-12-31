@extends('layout.main')
@section('title', 'Proses Order')
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
                        <th>Tanggal</th>
                        <th>Nama Menu</th>
                        <th>No Meja</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Diskon (%)</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $d->nomer_penjualan }}</td>
                            <td>{{ $d->tanggal }}</td>
                            <td>{{ $d->pesanan }}</td>
                            <td>{{ $d->no_meja }}</td>
                            <td>{{ $d->jumlah }}</td>
                            <td>Rp {{ number_format($d->harga_satuan) }}</td>
                            <td>{{ $d->diskon }}</td>
                            <td>
                                @if ($d->status == 'proses')
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="" method="">
                                            @csrf
                                            <button class="btn btn-secondary btn-sm" id=""
                                                disabled>{{ $d->status }}</button>
                                        </form>
                                    </div>
                                @endif
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
        Pusher.logToConsole = true;

        var pusher = new Pusher('635466c2765ece12d468', {
            cluster: 'ap1',
        });

        var channel = pusher.subscribe("{{ auth()->user()->id }}");
        channel.bind('pusher:subscription_succeeded', function(members) {
            console.log('successfully subscribed!');
        });


        // channel.bind('App\\Events\\OrderNotification', function(data) {
        //     console.log("test" + data);  > dari riski
        // location.reload();
        // });

        $(document).ready(function() {
            $('#table-menu').DataTable();
        });

        function reload() {
            var totalAwal = 0;
            $.ajax({
                url: "/api/update",
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
                    url: "/api/update",
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

            }, 2000);
        }

        reload();
    </script>
@endpush
