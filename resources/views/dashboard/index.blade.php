@extends('layout.main')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-md-4">
                <div
                    class="p-3 bg-white shadow-sm d-flex justify-content-start gap-3 align-items-center dashboard-warna1 c-produk">
                    <i class="fas fa-solid fa-money-check-dollar fs-2 primary-text border  bg-white secondary-bg p-3"
                        style="color: #54BE6D; border-radius:15px;"></i>
                    <div>
                        {{-- <h3 class="fs-2">Rp 250.000</h3> --}}
                        {{-- <h3 class="fs-2">Rp
                            {{ number_format(\App\Models\Penjualan::getTotalPendapatanByTanggal('2023-04-06'), 0, ',', '.') }}
                        </h3> --}}
                        <h3 class="fs-2">Rp {{ number_format($pendapatan_seluruh) }}</h3>
                        <p class="fs-5">Total Pendapatan Hari Ini</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 menu-atas">
                <div
                    class="p-3 bg-white shadow-sm d-flex justify-content-start gap-3 align-items-center dashboard-warna2 c-menu">
                    <i class="fas fa-solid fa-cart-shopping fs-2 primary-text border  secondary-bg p-3 bg-white"
                        style="color: #D1D44F; border-radius:15px;"></i>
                    <div>
                        {{-- <h3 class="fs-2">12</h3> --}}
                        {{-- <h3 class="fs-2">{{ \App\Models\Detail_penjualan::getTotalMenuByTanggal('2023-04-06') }}</h3> --}}
                        <h3 class="fs-2">{{ number_format($totalMenu) }}</h3>
                        <p class="fs-5">Menu Terjual Hari Ini</p>
                    </div>

                </div>

            </div>

            <div class="col-md-4 menu-atas">
                <div
                    class="p-3 bg-white shadow-sm d-flex justify-content-start gap-3 align-items-center dashboard-warna3 c-customer">
                    <i class="fas fa-solid fa-users fs-2 primary-text border  secondary-bg p-3 bg-white"
                        style="color: #6BB1D7; border-radius:15px"></i>
                    <div>
                        {{-- <h3 class="fs-2">25</h3> --}}
                        {{-- <h3 class="fs-2">{{ \App\Models\Penjualan::getTotalTransaksiByTanggal(now()->toDateString()) }}
                        </h3> --}}
                        <h3 class="fs-2">
                            {{ \App\Models\Transaksi::getTotalTransaksiByTanggal(date('Y-m-d')) }}
                        </h3>
                        <p class="fs-5">Jumlah Transaksi Hari Ini</p>
                    </div>

                </div>
            </div>
            
            <div class="col-md-4 mt-3 menu-atas">
                <div
                class="p-3 bg-white shadow-sm d-flex justify-content-start gap-3 align-items-center dashboard-warna5 c-produk">
                <i class="fas fa-solid fa-money-check-dollar fs-2 primary-text border  bg-white secondary-bg p-3"
                    style="color: #fa9a13; border-radius:15px;"></i>
                <div>
                    {{-- <h3 class="fs-2">Rp 250.000</h3> --}}
                    {{-- <h3 class="fs-2">Rp
                        {{ number_format(\App\Models\Penjualan::getTotalPendapatanByTanggal('2023-04-06'), 0, ',', '.') }}
                    </h3> --}}
                    <h3 class="fs-2">Rp {{ number_format($Total_ongkir) }}</h3>
                    <p class="fs-5">Total Pendapatan Kurir Hari Ini</p>
                </div>
            </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-8">
                <div class="p-3 bg-white shadow-sm d-flex justify-content-start align-items-center dashboard-warna4"
                    id="grafik"></div>
            </div>
            <div class="col-md-4 dashboard-warna4" id="pendapatan">
                <div>
                    <p class="fs-5 mt-2" style="font-weight: bold; text-align: left; margin-left: 10px; margin-top:20px;">
                        Pendapatan Kantin Hari Ini</p>
                </div>
                <div class="p-2 bg-white top-kantin" id="pendapatan">

                    <div class="d-flex align-items-center gap-3 kantin1">
                        <p style="color: #FF4A4F">1</p>
                        <h1>
                            <i class='bx bx-store'></i>
                        </h1>
                        <div>
                            <h5 class="fw-bold">Kantin 1</h5>
                            <p> Rp {{ number_format($kantin1[0]->total) }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 kantin2 mt-3">
                        <p style="color: #A3A711">2</p>
                        <h1>
                            <i class='bx bx-store'></i>
                        </h1>
                        <div>
                            <h5 class="fw-bold">Kantin 2</h5>
                            <p>Rp {{ number_format($kantin2[0]->total) }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 kantin3 mt-3">
                        <p style="color: #54BE6D">3</p>
                        <h1>
                            <i class='bx bx-store'></i>
                        </h1>
                        <div>
                            <h5 class="fw-bold">Kantin 3</h5>
                            <p>Rp {{ number_format($kantin3[0]->total) }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 kantin4 mt-3">
                        <p style="color: #51AADD">4</p>
                        <h1>
                            <i class='bx bx-store'></i>
                        </h1>
                        <div>
                            <h5 class="fw-bold">Kantin 4</h5>
                            <p>Rp {{ number_format($kantin4[0]->total) }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 kantin5 mt-3" style="background-color: #4b4a4a42;">
                        <p style="color: #514D4E">5</p>
                        <h1>
                            <i class='bx bx-store' style="color: #514D4E"></i>
                        </h1>
                        <div>
                            <h5 class="fw-bold">Kantin 5</h5>
                            <p>Rp {{ number_format($kantin5[0]->total) }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 kantin6 mt-3" style="background-color: #ea718533;">
                        <p style="color: #EA7186">6</p>
                        <h1>
                            <i class='bx bx-store' style="color: #EA7186"></i>
                        </h1>
                        <div>
                            <h5 class="fw-bold">Kantin 6</h5>
                            <p>Rp {{ number_format($kantin6[0]->total) }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 kantin7 mt-3" style="background-color: #f2c66e3f;">
                        <p style="color: #F2C76E">7</p>
                        <h1>
                            <i class='bx bx-store' style="color: #F2C76E"></i>
                        </h1>
                        <div>
                            <h5 class="fw-bold">Kantin 7</h5>
                            <p>Rp {{ number_format($kantin7[0]->total) }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 kantin8 mt-3" style="background-color: #7a77b93d;">
                        <p style="color: #7A77B9">8</p>
                        <h1>
                            <i class='bx bx-store' style="color: #7A77B9"></i>
                        </h1>
                        <div>
                            <h5 class="fw-bold">Kantin 8</h5>
                            <p>Rp {{ number_format($kantin8[0]->total) }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 kantin8 mt-3" style="background-color: #bd9dea48;">
                        <p style="color: #BD9DEA">9</p>
                        <h1>
                            <i class='bx bx-store' style="color: #BD9DEA"></i>
                        </h1>
                        <div>
                            <h5 class="fw-bold">Kantin 9</h5>
                            <p>Rp {{ number_format($kantin9[0]->total) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('footer')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        Highcharts.chart('grafik', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Pendapatan Bulanan',
                style: {
                    color: '#514D4E'
                }
            },
            subtitle: {
                text: 'Dikantin Polije'
            },
            xAxis: {
                categories: [
                    @foreach ($pendapatan as $bulan=>$value)
                        '{{ $value["bulan"] }}',
                    @endforeach
                ]
            },

            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Pendapatan'
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>' + this.series.name + '</b><br/>' +
                        this.point.category + ': Rp ' + Highcharts.numberFormat(this.point.y, 0, ',', '.') +
                        '</b>';
                }
            },

            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Pendapatan',
                data: [
                    @foreach ($pendapatan as $data)
                        {{ $data["total"] }},
                    @endforeach
                ]
            }]

        });

        function reload() {
            var totalAwal = 0;
            $.ajax({
                url: "/api/ubahHarga",
                type: "GET",
                method: "GET",
                data: {},
                success: function(response) {
                    totalAwal = response;
                    console.log(response);
                }
            })

            setInterval(() => {

                $.ajax({
                    url: "/api/ubahHarga",
                    type: "GET",
                    method: "GET",
                    data: {},
                    success: function(response) {
                        if (totalAwal != response) {
                            location.reload();
                        }
                        console.log(response);
                    }
                })

            }, 2000);
        }

        reload();
    </script>
@endsection
