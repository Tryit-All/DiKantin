@extends('layout.main')
@section('title', 'Pesanan Online')
@section('content')
    <div class="container-fluid mt-3">
        <div class="table-responsive mt-2 bg-white p-4" style="border-radius: 20px; height:76% !important;">
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-menu"
                style="height: 10% !important">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Penjualan</th>
                        <th>Kasir</th>
                        <th>No Penjualan</th>
                        <th>Nama Customer</th>
                        <th>Biaya Ongkir</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembali</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td> {{ auth()->user()->name }} </td>
                            <td>{{ $item->kode_tr }}</td>
                            <td>{{ $item->Customer->nama }}</td>
                            <td>{{ $item->total_biaya_kurir }}</td>
                            <td>Rp {{ number_format($item->total_harga) }}</td>
                            <td>Rp {{ number_format($item->total_bayar) }}</td>
                            <td>Rp {{ number_format($item->kembalian) }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    {{-- <button class="btn btn-info btn-sm text-white m-0" type="submit">Cetak Ulang
                                        Nota</button> --}}
                                    <a href="/transaksi/{{ $item->kode_tr }}" target="_blank" class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-print"></i> Cetak Ulang Nota
                                    </a>
                                    <a href="/detail_tr/{{ $item->kode_tr }}" class="btn btn-sm btn-primary">detail</a>
                                
                            </td>
                        </tr>
                    @endforeach
              
                </tbody>
            </table>

        </div>
    </div>

    <!-- Modal -->

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#table-menu').DataTable();
        });
    </script>
@endpush
