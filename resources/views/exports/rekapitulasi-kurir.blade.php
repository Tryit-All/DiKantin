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
                <th colspan="3"
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
                <th>Nama Kurir</th>
                <th>Total Pendapatan Kurir</th>
            </tr>
        </thead>
        <tbody>
            <!-- Add your table rows here -->
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_kurir }}</td>
                    <td>{{ $item->total_ongkir }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
