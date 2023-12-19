@extends('layout.main')
@section('title', 'Keuangan')
@section('content')
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
    <div class="container mt-4">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-primary" onclick="showTable('kantin')">Kantin</button>
            <button type="button" class="btn btn-warning" onclick="showTable('kurir')">Kurir</button>
        </div>

        <div class="table-responsive mt-2 bg-white p-4" style="border-radius: 20px; height:76%; !important;">
            <table id="kantinTable" class="table table-striped table-hover w-100 nowrap" style="widows: 100%">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Kantin</th>
                        <th>Total Saldo Belum Diambil</th>
                        <th>Jumlah Penarikan (Kali)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($kantin as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>Rp.{{ number_format($item->total_saldo) }}</td>
                        <td>{{ $item->history == null ? 0 : sizeof($item->history) }} Kali</td>
                        <td>
                            <div class="d-flex justify-content-start align-items-center gap-2">
                                <div>
                                    <a href="{{ route('history-kantin', ['id' => $item->id_kantin]) }}"
                                        class="btn btn-warning">History Penarikan</a>
                                </div>
                                <div>
                                    <form action="{{ route('berikan-dana-kantin') }}" method="post">
                                        @csrf
                                        @method('post')
                                        <input type="text" value="{{ $item->total_saldo }}" hidden name="total_saldo">
                                        <input type="text" value="{{ $item->id_kantin }}" hidden name="id_kantin">
                                        <button type="submit" class="btn btn-primary">Berikan Ke kantin</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tr>
                </tbody>
            </table>
            <table id="kurirTable" class="table table-striped table-hover w-100 nowrap d-none" style="widows: 100%">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Kurir</th>
                        <th>Total Saldo Belum Diambil</th>
                        <th>Jumlah Penarikan (Kali)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kurir as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>Rp.{{ number_format($item->total_saldo) }}</td>
                            <td>0 Kali</td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center gap-2">
                                    <div>
                                        <a href="{{ route('history-kurir', ['id' => $item->id_kurir]) }}"
                                            class="btn btn-warning">History Penarikan</a>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-primary">Berikan Ke kurir</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showTable(tableType) {
            // Hide all tables
            document.getElementById('kantinTable').classList.add('d-none');
            document.getElementById('kurirTable').classList.add('d-none');

            // Show the selected table
            document.getElementById(tableType + 'Table').classList.remove('d-none');
        }
    </script>
@endsection
