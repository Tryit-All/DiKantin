<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>Nama Kantin</th>
            <th>Jumlah Penarikan</th>
            <th>Tanggal Penarikan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item->kantin->nama}}</td>
                <td>{{$item->total_penarikan}}</td>
                <td>{{\Carbon\Carbon::parse($item->created_at)->format('Y-m-d')}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
