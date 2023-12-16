@extends('layout.main')
@section('title', 'Cek Onkir')
@section('content')
    @php
        $jsonContent = json_encode($ongkirByCourier);
        // dd($jsonContent);
    @endphp
    <div class="container-fluid mt-3">
        {{-- <a href="/menu/create" class="btn text-white" style="padding: 7px; border-radius:10px; background: #51AADD">
            + Create New
        </a> --}}
        <div class="table-responsive mt-2 bg-white p-4" style="border-radius: 20px; height:76% !important;">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="" class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" name="dariTanggal" id="tglMulai" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" name="sampaiTanggal" id="tglSelesai"
                        value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-4">
                    <label for="btn-cetak" class="form-label">&nbsp;</label><br>
                    <a href="" class="btn btn-primary" id="btn-cetak"
                        onclick="this.href='/cekOnkirKurir/cetak/'+document.getElementById('tglMulai').value + '/' + document.getElementById('tglSelesai').value">Proses
                    </a>
                    <button type="button" class="btn-cetak btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Cetak Excel
                    </button>
                </div>
            </div>
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-menu"
                style="height: 100% !important">
                <thead>
                    <tr>

                        <th>Kurir</th>
                        <th>TOtal Ongkir</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($ongkirByCourier as $m)
                        <tr>

                            <td>{{ $m['nama_kurir'] }}</td>
                            <td>Rp .{{ number_format($m['total_ongkir']) }}</td>

                        </tr>
                    @endforeach
                </tbody>
                {{-- <tfoot>
                    @if ($jumlah != null)
                        <tr>
                            <th colspan="1"></th>
                            <th></th>
                            <th></th>
                            <th>Pendapatan</td>
                            <th>Rp {{ number_format($pendapatan) }}</td>
                        </tr>
                    @endif
                </tfoot> --}}
                <tfoot>

                    <tr>
                        <th colspan="1">Total Ongkir Kurir:</th>
                        <th></th>


                        <th>Rp {{ number_format($total_keseluruhan_ongkir) }}</td>
                    </tr>

                </tfoot>
            </table>
            {{-- <a href="" class="btn btn-primary" id="btn-cetak" target="_blank"
                onclick="this.href='/rekapitulasi/cetak/'+document.getElementById('tglMulai').value + '/' + document.getElementById('tglSelesai').value">Cetak
                Rekapitulasi
            </a> --}}

        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cetak Excel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kurir-excel') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <label for="format">Format Excel</label>
                        <select class="form-select" id="format" aria-label="Default select example" name="type">
                            <option value="xlsx">XLSX</option>
                            <option value="csv">CSV</option>
                            <input type="text" id="id_data" name="data" hidden>

                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Cetak Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-cetak', function() {
                var data = {!! json_encode($jsonContent) !!}
                $('#id_data').val(data);
            })
        });
    </script>

@endsection
