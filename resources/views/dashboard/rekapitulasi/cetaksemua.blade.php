<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DiKantin | Cetak Rekapitulasi</title>
    <link rel="shortcut icon" href="{{ url(asset('img/logo-kotak.png')) }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        @media print {
            .table-dark {
                background-color: #fff !important;
                color: #000 !important;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-3">
        <h5 style="text-align:center;" class=" mb-0">REKAPITULASI PENDAPATAN KANTIN</h5>
        <h3 style="text-align:center;" class="fw-bold mb-0">"DIKANTIN"</h3>
        <h5 style="text-align:center;" class="mb-4">POLITEKNIK NEGERI JEMBER</h5>
        <hr style="border-top: solid black" class="mb-2 mt-3">

 
        <div class="table-responsive bg-white p-4" style="border-radius: 20px; height:76% !important;">
            <table class="mt-0 table table-striped table-hover w-100 nowrap" width="100%" id="table-menu"
                style="height: 100% !important">
                <thead class="table-dark">
                    <tr>
                        <th>Kode transaksi</th>
                        <th>Kantin</th>
                        <th>Metode</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $m)
                        <tr>
                            <td>{{ $m->kode }}</td>
                            <td>{{ $m->nama_kantin }}</td>
                            <td>{{ $m->metode }}</td>
                            <td>Rp {{ number_format($m->total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @if ($jumlah != null)
                        <tr>
                            <th colspan="1">Total Pendapatan :</th>
                            <th></th>
                            <th></th>
                            <th>Rp {{ number_format($sumTotal) }}</td>
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
