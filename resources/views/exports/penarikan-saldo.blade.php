<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ url(asset('img/logo-kotak.png')) }}">
    <title>DiKantin | Penarikan Saldo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        @media print {
            body {
                width: 250px;
                /* Set the width of the printed content */
                margin: 0;
                /* Remove default margin */
            }

            hr {
                display: none;
                /* Hide horizontal rules in print */
            }

            /* Add more print styles as needed */
        }
    </style>
</head>
</head>

<body style="width: 250px">
    <div class="container">
        <div class="identitas">
            <img src="{{ url(asset('/img/logo_struk-01.png')) }}" alt="Logo DiKantin" class="mx-auto d-block"
                width="80">
            <!-- <p class="text-center">Politeknik Negeri Jember</p> -->
        </div>
        <hr style="border-top: 2px dotted rgb(0, 0, 0)" class="mb-0">
        <div class="d-flex justify-content-between" style="font-size: 11px;">
            <div class="order">
                <p style="margin-bottom: 1px;">Penarikan Saldo Kantin / Kurir</p>
                <p style="margin-bottom: 1px;">No Transaksi : {{$kode_penarikan}}</p>
                <p style="margin-bottom: 1px;">Tanggal      : {{date('Y-m-d')}}</p>

            </div>
        </div>
        <hr class="mb-1 mt-0" style="border-top: 2px dotted rgb(0, 0, 0)">

        <div class="d-flex justify-content-between">
            <div class="bayar" style="font-size: 11px;">
                {{-- <p class="mb-2" style="line-height: 1;">Subtotal</p>
                <p class="mb-2" style="line-height: 1;">Diskon</p> --}}
                <p class="fw-bold mb-2" style="line-height: 1;">Nama : {{$nama}}</p>
                <p class="fw-bold mb-2" style="line-height: 1;">Total : Rp.{{number_format($total)}} </p>
            </div>

        </div>
        <div class="signatures mt-4">
            <div class="row">
                <div class="col-6">
                    <p class="fw-bold mb-2" style="line-height: 1;">Kasir </p>
                    <hr style="border-top: 2px dotted rgb(0, 0, 0)" class="mb-2 mt-4">
                </div>
                <div class="col-6">
                    <p class="fw-bold mb-2" style="line-height: 1;">Kantin/Kurir</p>
                    <hr style="border-top: 2px dotted rgb(0, 0, 0)" class="mb-2 mt-4">
                </div>
            </div>
            {{-- <hr style="border-top: 2px dotted rgb(0, 0, 0)" class="mb-2 "> --}}
        </div>

   
        <p class="text-center fw-bold mb-0 mt-1" style="font-size: 11px;">Terima Kasih</p>
        <p class="text-center fw-bold" style="font-size: 11px;">Salam manis Dikantin</p>

    </div>

    <script>
        window.print();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>
