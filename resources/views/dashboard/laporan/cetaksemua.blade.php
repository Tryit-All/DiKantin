<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DiKantin | Cetak Laporan</title>
    <link rel="shortcut icon" href="{{ url(asset('img/logo-kotak.png')) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        @media print {
            .table-dark {
                background-color: #fff !important;
                color: #000 !important;
            }

            th {
                border-top: 1px solid #ccc;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-3">
        <h5 style="text-align:center;" class=" mb-0">LAPORAN PENDAPATAN KANTIN</h5>
        <h3 style="text-align:center;" class="fw-bold mb-0">"DIKANTIN"</h3>
        <h5 style="text-align:center;" class="mb-4">POLITEKNIK NEGERI JEMBER</h5>
        <hr style="border-top: solid black" class="mb-2 mt-3">
        <div style="display: flex; align-items: center;">
            <p class="mb-0" style="margin-bottom: 0; margin-left: 25px;">Data Keseluruhan</p>
            

        </div>
    
        <div class="table-responsive bg-white p-4" style="border-radius: 20px; height:76% !important;">
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-menu"
                style="height: 100% !important">
                <thead class="table-dark">
                    <tr>
                        <th
                            style="text-align: center; border-left: 1px solid #ccc; white-space: normal; vertical-align: middle;">
                            No</th>
                        <th style="text-align: center; white-space: normal; vertical-align: middle;">Tgl Penjualan</th>
                        <th style="text-align: center; white-space: normal; vertical-align: middle;">Pembeli</th>
                        <th style="text-align: center; white-space: normal; vertical-align: middle;">Kasir</th>
                        <th style="text-align: center; white-space: normal; vertical-align: middle;">Kantin</th>
                        <th style="text-align: center; white-space: normal; vertical-align: middle;">Menu</th>
                        <th style="text-align: center; white-space: normal; vertical-align: middle;">Jumlah</th>
                        <th style="text-align: center; white-space: normal; vertical-align: middle;">Status</th>
                        <th style="text-align: center; white-space: normal; vertical-align: middle;">Diskon</th>
                        <th style="border-right: 1px solid #ccc; white-space: normal; vertical-align: middle;">Harga
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $m)
                        <tr>
                            <td style="border-left: 1px solid #ccc;">{{ $loop->iteration }}</td>
                            <td>{{ $m->tanggal }}</td>
                            <td>{{ $m->pembeli }}</td>
                            <td>{{ $m->kasir }}</td>
                            <td>{{ $m->kantin }}</td>
                            <td>{{ $m->pesanan }}</td>
                            <td>{{ $m->jumlah }}</td>
                            <td>{{ $m->status_pengiriman }}</td>
                            <td>{{ $m->diskon }}</td>
                            <td style="border-right: 1px solid #ccc;">
                                Rp {{ number_format($m->harga_satuan) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    {{-- @if ($sumTotal == 0)
                        <tr>
                            <td colspan="8">
                                <center><b>Data tidak Ditemukan !
                                    </b></center>
                            </td>
                        </tr>
                    @endif --}}
                    @if ($jumlah != null)
                        <tr>
                            <th style="text-align: left; border-left: 1px solid #ccc;" colspan="9">Total Pendapatan :
                            </th>
                            <th style="border-right: 1px solid #ccc;">Rp {{ number_format($sumTotal) }}</td>
                        </tr>
                    @endif

                </tfoot>
            </table>

        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
