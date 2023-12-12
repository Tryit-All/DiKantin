@extends('layout.main')
@section('title', 'Laporan Pendapatan')
@section('content')
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
                <div class="col-md-2">
                    <label for="kantin" class="form-label">Kantin</label>
                    <select class="form-select" aria-label="Default select example" name="id_kantin" required
                        id="idKantin">
                        <option value="p">Pilih Kantin</option>
                        <option value="1">Kantin 1</option>
                        <option value="2">Kantin 2</option>
                        <option value="3">Kantin 3</option>
                        <option value="4">Kantin 4</option>
                        <option value="5">Kantin 5</option>
                        <option value="6">Kantin 6</option>
                        <option value="7">Kantin 7</option>
                        <option value="8">Kantin 8</option>
                        <option value="9">Kantin 9</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" aria-label="Default select example" name="status" required id="statuss">
                        <option value="p">Pilih Status</option>
                        <option value="proses">Proses</option>
                        <option value="kirim">Dikirim</option>
                        <option value="terima">Selesai</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="btn-cetak" class="form-label">&nbsp;</label><br>
                    <a href="" class="btn btn-primary" id="btn-cetak"
                        onclick="this.href='/ceklaporan/cetak/'+document.getElementById('tglMulai').value + '/' + document.getElementById('tglSelesai').value + '/' + document.getElementById('idKantin').value + '/' + document.getElementById('statuss').value">Proses</a>
                </div>
            </div>
            <table class="table table-striped table-hover w-100 nowrap" width="100%" id="table-menu"
                style="height: 100% !important">
                <thead>
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
                        <th>Harga</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $m)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $m->tanggal }}</td>
                            <td>{{ $m->pembeli }}</td>
                            <td>{{ $m->kasir }}</td>
                            <td>{{ $m->kantin }}</td>
                            <td>{{ $m->pesanan }}</td>
                            <td>{{ $m->jumlah }}</td>
                            <td>{{ $m->status_pengiriman }}</td>
                            <td>{{ $m->diskon }}</td>
                            <td>Rp {{ number_format($m->harga_satuan) }}</td>
                           
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
               
                    @if ($jumlah != null)
                    <tr>
                        <th colspan="9">Total Pendapatan :</th>
                        <th>Rp {{ number_format($sumTotal) }}</td>
                    </tr>
                @endif

                </tfoot>
            </table>
            <a href="" class="btn btn-primary" id="btn-cetak" targe="_blank"
                onclick="this.href='/laporan/cetak/'+ document.getElementById('tglMulai').value + '/' + document.getElementById('tglSelesai').value + '/' + document.getElementById('idKantin').value + '/' + document.getElementById('statuss').value">Cetak
                Laporan</a>
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
