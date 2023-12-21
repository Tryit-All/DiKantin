@extends('layout.main')
@section('title', 'Menu')
@section('content')
    <div class="container-fluid mt-3">
        <a href="/online" class="btn btn-danger text-white" style="padding: 7px; border-radius:10px;">
          Kembali
        </a>
        <div class="table-responsive mt-2 bg-white p-4" style="border-radius: 20px; height:76% !important;">
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-menu"
                style="height: 10% !important">
                <thead>
                    <tr>
                      
                        <th>Kode Transaksi</th>
                        <th>Menu</th>
                        <th>Harga Jual</th>
                        <th>QTY</th>
                        <th>Subtotal Harga JUal</th>
                        <th>keterangan</th>
                        <th>Kantin</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan as $m)
                        <tr>
                             <td>{{ $m->kode_tr}}</td>
                            <td>{{ $m->Menu->nama }}</td>
                            <td>Rp {{ number_format($m->Menu->harga) }}</td>
                            <td>Rp {{ $m->QTY }}</td>
                            <td>Rp {{ number_format($m->subtotal_bayar) }}</td>
                            <td>Rp {{ $m->catatan }}</td>
                            <td>{{ $m->Menu->Kantin->nama }}</td> 
                          
                        </tr>
                    @endforeach
                  
                </tbody>
            </table>

        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#table-menu').DataTable();
        });
    </script>
@endpush
