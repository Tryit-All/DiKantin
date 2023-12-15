<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ url(asset('img/logo-kotak.png')) }}">
    <title>DiKantin | Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
</head>

<body style="width: 350px">
    <div class="container">
        <div class="identitas">
            <img src="{{ url(asset('/img/logo_struk-01.png')) }}" alt="Logo DiKantin" class="mx-auto d-block"
                width="80">
            <!-- <p class="text-center">Politeknik Negeri Jember</p> -->
        </div>
        <hr style="border-top: 2px dotted rgb(0, 0, 0)" class="mb-0">
        <div class="d-flex justify-content-between">
            <div class="order">
                <p style="margin-bottom: 1px;">{{ $penjualan->kode_tr }}</p>
                <p style="margin-bottom: 1px;">No Meja : {{ $penjualan->no_meja }}</p>
            </div>
            <div class="value">
                <p style="margin-bottom: 1px; text-align: right;">
                    {{ date('Y-m-d', strtotime($penjualan->created_at)) }}</p>
                <p style="margin-bottom: 1px; text-align: right;">Kasir : {{ auth()->user()->name }}</p>
            </div>
        </div>
        <hr class="mb-1 mt-0" style="border-top: 2px dotted rgb(0, 0, 0)">

        <div class="d-flex justify-content-between">
            <div class="nama-product">
                <p class="fw-bold mb-0">Menu</p>
                @foreach ($penjualan->detail_transaksi as $item)
                    <p class="mb-0">{{ $item->menu->nama }}</p>
                @endforeach
            </div>
            <div class="qty">
                <p class="fw-bold mb-0">Qty</p>
                @foreach ($penjualan->detail_transaksi as $item)
                    <p class="mb-0" style="text-align: center;">{{ $item->QTY }}</p>
                @endforeach
            </div>
            <div class="keterangan">
                <p class="fw-bold mb-0">keterangan</p>
                @foreach ($penjualan->detail_transaksi as $item)
                    <p class="mb-0" style="text-align: center;">{{ $item->catatan }}</p>
                @endforeach
            </div>
            <div class="diskon">
                <p class="fw-bold mb-0">Kantin</p>
                @foreach ($penjualan->detail_transaksi as $item)
                    <p class="mb-0" style="text-align: center;">{{ $item->menu->id_kantin }}</p>
                @endforeach
            </div>
            <div class="harga">
                <p class="fw-bold mb-0">Harga</p>
                @foreach ($penjualan->detail_transaksi as $item)
                    <p class="mb-0" style="text-align: right;">{{ number_format($item->menu->harga) }}</p>
                @endforeach
            </div>
        </div>

        <hr style="border-top: 2px dotted rgb(0, 0, 0)" class="mb-2 mt-2">
        <div class="d-flex justify-content-between">
            <div class="bayar">
                <p class="mb-2" style="line-height: 1;">Model Pembayaran</p>
                {{-- <p class="mb-2" style="line-height: 1;">Subtotal</p>
                <p class="mb-2" style="line-height: 1;">Diskon</p> --}}
                <p class="fw-bold mb-2" style="line-height: 1;">Total</p>
                <p class="fw-bold mb-2" style="line-height: 1;">Bayar</p>
                <p class="fw-bold mb-2" style="line-height: 1;">Kembali</p>

            </div>
            <div class="value-bayar mb-1">
                <p class="mb-2" style="line-height: 1; text-align: right;">{{ $penjualan->model_pembayaran }}</p>
                </p>
                {{-- @if ($penjualan->diskon == null)
                    <p class="mb-2" style="line-height: 1; text-align: right;"> 0 %</p>
                @else
                    <p class="mb-2" style="line-height: 1; text-align: right;">{{ $penjualan->diskon }} %</p>
                @endif --}}
                <p class="mb-2" style="line-height: 1; text-align: right;">
                    {{ number_format($penjualan->total_harga) }}</p>
                <p class="mb-2" style="line-height: 1; text-align: right;">
                    {{ number_format($penjualan->total_bayar) }}</p>
                <p class="mb-2" style="line-height: 1; text-align: right;">{{ number_format($penjualan->kembalian) }}
                </p>
            </div>
        </div>

        <hr style="border-top: 2px dotted rgb(0, 0, 0)" class="mt-1 mb-2">
        <p class="text-center fw-bold mb-0 mt-1">Terima Kasih</p>
        <p class="text-center fw-bold">Atas Kunjungan Anda</p>

    </div>

    <script>
        window.print();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>
