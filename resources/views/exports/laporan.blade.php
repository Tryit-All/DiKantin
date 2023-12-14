<body data-new-gr-c-s-check-loaded="14.1145.0" data-gr-ext-installed="" style="">
    <div class="container-fluid mt-3">
        <div class="table-responsive bg-white p-4" style="border-radius: 20px; height:76% !important;">
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-menu"
                style="height: 100% !important">
                <thead class="table-dark">


                    <tr>
                        <th>No</th>
                        <th>Tgl Penjualan</th>
                        <th>Pembeli</th>
                        <th>Kasir</th>
                        <th>Kantin</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Diskon</th>
                        <th>Harga Jual</th>
                        <th>Harga Pokok</th>
                        <th>Subtotal Harga Pokok</th>
                        <th>Subtotal Harga Jual</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->pembeli }}</td>
                            <td>{{ $item->kasir }}</td>
                            <td>{{ $item->kantin }}</td>
                            <td>{{ $item->pesanan }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->status_pengiriman }}</td>
                            <td>{{ $item->diskon }}</td>
                            <td>{{ $item->harga_satuan }}</td>
                            <td>{{ $item->harga_pokok }}</td>
                            <td>{{ $item->subtotalpokok }}</td>
                            <td>{{ $item->subtotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>

                        <th></th>
                        <th style="text-align: left; border-left: 1px solid #ccc;">Total Pokok
                        </th>
                        <th style="border-right: 1px solid #ccc;">Rp {{ number_format($totalPokok) }}
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>



                        <th style="text-align: left; border-left: 1px solid #ccc;">Total Jual
                        </th>
                        <th style="border-right: 1px solid #ccc;">Rp {{ number_format($totalJual) }}
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>

                        <th></th>
                        <th></th>


                        <th style="text-align: left; border-left: 1px solid #ccc;"> Keuntungan
                        </th>
                        <th style="border-right: 1px solid #ccc;">Rp {{ number_format($pendapatan) }}
                        </th>
                    </tr>

                </tfoot>
            </table>

        </div>
    </div>
