@extends('layout.main')
@section('title', 'History Penarikan')

@section('content')
    <input type="text" id="id_kantin" class="d-none" value="{{ $id }}"></input>
    <div class="row mb-3 mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/keuangan">Keuangan</a></li>
                <li class="breadcrumb-item active" aria-current="page">History Penarikan</li>
            </ol>
        </nav>
        <div class="col-md-3">
            <label for="" class="form-label">Dari Tanggal</label>
            <input type="date" class="form-control" name="dariTanggal" id="tglMulai" value="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-3">
            <label for="" class="form-label">Sampai Tanggal</label>
            <input type="date" class="form-control" name="sampaiTanggal" id="tglSelesai" value="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-4">
            <label for="btn-cetak" class="form-label">&nbsp;</label><br>
            <button type="button" class="btn btn-primary" id="btn-cetak" onclick="prosesCetak()">Proses</button>
            <button type="button" class="btn-cetak btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Cetak Excel
            </button>
        </div>

        <script>
            function prosesCetak() {

                var dariTanggal = document.getElementById('tglMulai').value;
                var sampaiTanggal = document.getElementById('tglSelesai').value;
                var id_kantin = document.getElementById('id_kantin').value;


                // Redirect to the specified URL
                window.location.href = '/keuangan/kantin/' + id_kantin + '/history/' + dariTanggal + '/' + sampaiTanggal + '/'
            }
        </script>

        <div class="container">
            <div class="table-responsive mt-2 bg-white p-4 mr-2" style="border-radius: 20px; height:76%; !important;">
                <table class="table table-striped table-hover w-100 nowrap" style="widows: 100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Penarikan</th>
                            <th>Tanggal Penarikan</th>
                            <th>Jumlah Penarikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kode_penarikan }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:m') }}</td>
                                <td>Rp.{{ number_format($item->total_penarikan) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
