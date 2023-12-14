<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rekapitulasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
  
    <table>
        <thead>
            <tr>
                <th colspan="5"
                    style="
              text-align: center;
              font-size: 12px;
              background-color: yellow;
            ">
                    Laporan Rekapitulasi
                </th>
            </tr>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Kantin</th>
                <th>Metode</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php $totalJual = 0; @endphp
            <!-- Add your table rows here -->
            @foreach ($data as $item)
                @php $totalJual += $item->total; @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama_kantin }}</td>
                    <td>{{ $item->metode }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: end; ">Total Harga jual</td>
                <td style="text-align: end; ">{{ number_format($totalJual) }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: end; ">Total Harga Pokok</td>
                <td style="text-align: end; ">{{ number_format($totalPokok) }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: end; ">Total Keuntungan</td>
                <td style="text-align: end; ">{{ number_format($pendapatan) }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
