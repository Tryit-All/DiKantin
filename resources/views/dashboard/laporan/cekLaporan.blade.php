@extends('layout.main')
@section('title', 'Cek Laporan')
@section('content')
    @php
        $jsonContent = json_encode($data);
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
                    <input type="date" class="form-control" name="dariTanggal" id="tglMulai" value="{{ $tglMulai }}">
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" name="sampaiTanggal" id="tglSelesai"
                        value="{{ $tglSelesai }}">
                </div>
                <div class="col-md-2">
                    <label for="kantin" class="form-label">Kantin</label>
                    <select class="form-select" aria-label="Default select example" name="id_kantin" required
                        id="idKantin">

                        <option value="p"{{ $idKantin == 'p' ? 'selected' : '' }}>Semua Kantin</option>
                        <option value="1"{{ $idKantin == 1 ? 'selected' : '' }}>Kantin 1</option>
                        <option value="2"{{ $idKantin == 2 ? 'selected' : '' }}>Kantin 2</option>
                        <option value="3"{{ $idKantin == 3 ? 'selected' : '' }}>Kantin 3</option>
                        <option value="4"{{ $idKantin == 4 ? 'selected' : '' }}>Kantin 4</option>
                        <option value="5"{{ $idKantin == 5 ? 'selected' : '' }}>Kantin 5</option>
                        <option value="6"{{ $idKantin == 6 ? 'selected' : '' }}>Kantin 6</option>
                        <option value="7"{{ $idKantin == 7 ? 'selected' : '' }}>Kantin 7</option>
                        <option value="8"{{ $idKantin == 8 ? 'selected' : '' }}>Kantin 8</option>
                        <option value="9"{{ $idKantin == 9 ? 'selected' : '' }}>Kantin 9</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" aria-label="Default select example" name="status" required id="statuss">
                        <option value="p" {{ $status == 'p' ? 'selected' : '' }}>Semua Status</option>
                        <option value="proses" {{ $status == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="kirim" {{ $status == 'kirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="terima" {{ $status == 'terima' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="btn-cetak" class="form-label">&nbsp;</label><br>
                    <a href="" class="btn btn-primary" id="btn-cetak"
                        onclick="this.href='/ceklaporan/cetak/'+document.getElementById('tglMulai').value + '/' + document.getElementById('tglSelesai').value + '/' + document.getElementById('idKantin').value + '/' + document.getElementById('statuss').value">Proses</a>
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
                        <th>No</th>
                        <th>Tgl Penjualan</th>
                        <th>Pembeli</th>
                        <th>Kasir</th>
                        <th>Kantin</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Diskon</th>
                        <th>Harga Pokok</th>
                        <th>Harga Jual </th>
                        <th>Subtotal Harga  Pokok</th>
                        <th>Subtotal Harga Jual </th>
                 
                 

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
                            <td>Rp {{ number_format($m->harga_pokok) }}</td>
                            <td>Rp {{ number_format($m->harga_satuan) }}</td>
                            <td>Rp {{ number_format($m->subtotalpokok) }}</td>
                            <td>Rp {{ number_format($m->subtotal) }}</td>
                           
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    {{-- @if ($sumTotal == 0)
                        <tr>
                            <td colspan="8">
                                <center><b>Data tidak Ditemukan !
                                    </b></center>
                            </td>
                        </tr>
                    @endif --}}
                    @if ($jumlah != null)
                        <tr>
                        
                            <th colspan="11"></th>
                            <th>Total Penndapatan</th>
                            <th>Rp {{ number_format($pendapatan) }}</th>

                        </tr>
                    @endif
                </tfoot>
                <tfoot>
                    {{-- @if ($sumTotal == 0)
                        <tr>
                            <td colspan="8">
                                <center><b>Data tidak Ditemukan !
                                    </b></center>
                            </td>
                        </tr>
                    @endif --}}

                    @if ($jumlah != null)
                        <tr>
                            <th colspan="11">Total</th>
                            <th>Rp {{ number_format($sumTotal) }}</th>
                            <th>Rp {{ number_format($sumTotalPokok) }}</th>
                        </tr>
                    @endif

                </tfoot>




            </table>
            {{-- <a href="" class="btn btn-primary" id="btn-cetak" target="_blank"
                onclick="this.href='/laporan/cetak/'+ document.getElementById('tglMulai').value + '/' + document.getElementById('tglSelesai').value + '/' + document.getElementById('idKantin').value + '/' + document.getElementById('statuss').value">Cetak
                Laporan</a> --}} 
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cetak Excel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('laporan-excel') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <label for="format">Format Excel</label>
                        <select class="form-select" id="format" aria-label="Default select example" name="type">
                            <option value="xlsx">XLSX</option>
                            <option value="csv">CSV</option>
                            <input type="text" id="id_data" name="data" hidden>
                            <input type="text" id="totalPokok" name="total_pokok" hidden>
                            <input type="text" id="pendapatan" name="pendapatan" hidden>
                            <input type="text" id="totalJual" name="totalJual" hidden>

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
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#table-menu').DataTable();
        });
        $(document).on('click', '.btn-cetak', function() {
            var data = {!! json_encode($jsonContent) !!}
            $('#id_data').val(data);
            $('#pendapatan').val('{{ $pendapatan }}');
            $('#totalPokok').val('{{ $sumTotalPokok }}');
            $('#totalJual').val('{{ $sumTotal }}');
        });
    </script>
@endpush
