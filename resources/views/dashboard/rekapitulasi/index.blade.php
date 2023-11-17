@extends('main')
@section('title', 'Rekapitulasi Laporan Pendapatan')
@section('content')
    <div class="container-fluid mt-3">
        {{-- <a href="/menu/create" class="btn text-white" style="padding: 7px; border-radius:10px; background: #51AADD">
            + Create New
        </a> --}}
        <div class="table-responsive mt-2 bg-white p-4" style="border-radius: 20px; height:76% !important;">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="" class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" name="dariTanggal" id="tglMulai" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" name="sampaiTanggal" id="tglSelesai"
                        value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-4">
                    <label for="btn-cetak" class="form-label">&nbsp;</label><br>
                    <a href="" class="btn btn-primary" id="btn-cetak"
                        onclick="this.href='/cekRekapitulasi/cetak/'+document.getElementById('tglMulai').value + '/' + document.getElementById('tglSelesai').value">Proses</a>
                </div>
            </div>
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-rekapitulasi"
                style="height: 100% !important">
                <thead>
                    <tr>
                        <th>Kantin</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="1">Total Pendapatan :</th>
                        {{-- <th>{{ $sumTotal }}</td> --}}
                    </tr>
                    {{-- @endif --}}
                </tfoot>
            </table>
            <a href="" class="btn btn-primary" id="btn-cetak" targe="_blank"
                onclick="this.href='/rekapitulasi/cetak/'+ document.getElementById('tglMulai').value + '/' + document.getElementById('tglSelesai').value ">Cetak
                Rekapitulasi</a>
        </div>
        
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#table-rekapitulasi').DataTable();
        });
    </script>
@endpush