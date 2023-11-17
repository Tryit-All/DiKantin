<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content="Coderthemes" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    {{-- databale --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css">
    <!-- third party css end -->
    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    {{-- <link rel="stylesheet" href="{{ url(asset('public/css/style')) }}" /> --}}
    <link rel="stylesheet" href="/css/style.css
    ">

</head>

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}',
    style="background: #D0E3ED">

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
                        <th>Tanggal</th>
                        <th>No Penjualan</th>
                        <th>Pembeli</th>
                        <th>No Telp Pembeli</th>
                        <th>Kasir</th>
                        <th>Pembayaran</th>
                        <th>No Meja</th>
                        <th>Kantin</th>
                        <th>Pesanan</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Diskon</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $d->tanggal_penjualan }}</td>
                            <td>{{ $d->nomer_penjualan}}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->no_telepon }}</td>
                            <td>{{ $d->name }}</td>
                            <td>{{ $d->model_pembayaran }}</td>
                            <td>{{ $d->no_meja}}</td>
                            <td>{{ $d->nama_kantin }}</td>
                            <td>{{ $d->nama_menu }}</td>
                            <td>{{ $d->harga }}</td>
                            <td>{{ $d->jumlah }}</td>
                            <td>{{ $d->diskon }}</td>
                            <td>{{ $d->status }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ url('api/allData') }}"
                                        class="btn btn-warning text-white btn-sm">Detail</a>
                                    <form action="/api/allOrder/{{ $d->id }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit"
                                            onclick="confirm('Yakin ingin menghapus data ini ? ')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <script>
                $(document).ready(function() {
                    $('#table-menu').DataTable();
                });
            </script>
        </div>
    </div>




    <!-- bundle -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    <!-- third party js -->
    <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/demo.dashboard.js') }}"></script>
    <!-- end demo js-->

    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>


</body>

</html>
