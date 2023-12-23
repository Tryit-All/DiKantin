@extends('layout.main')
@section('title', 'Kasir')
@section('content')
    <div class="container-fluid mt-0" id="bungkusLuar" onload="updatePost()">
        <div class="row d-flex justify-content-between">
            <div class="col-md-8 m-0">
                <div class="row mt-2">
                    <div class="col-md-3">
                        {{-- <input type="text" placeholder="ID Customer" class="form-control" name="id_customer"
                            style="border-radius: 10px;" id="id_customer"> --}}

                        <select class="form-select" style="border-radius: 10px;" name="id_customer" id="id_customer">
                            <option value="">Pilih Pelanggan</option>
                            <option value="{{ $customer->id_customer }}">{{ $customer->nama }}</option>
                            {{-- @foreach ($customer as $item => $value)
                                <option value="{{ $value->id_customer }}">{{ $value->nama }}</option>
                            @endforeach --}}
                        </select>
                    </div>

                    <input type="hidden" id="inputid">
                    <div class="col-md-3"><input type="text" placeholder="Nama" class="form-control" id="inputnama"
                            class="form-control bg-lingkaran" readonly style="border-radius: 10px;"></div>
                    <div class="col-md-3"><input type="text" placeholder="No Telepon" class="form-control"
                            id="inputalamat" class="form-control bg-lingkaran" readonly style="border-radius: 10px;"></div>
                    <div class="col-md-3"><input type="text" placeholder="Alamat" class="form-control" id="inputtelepon"
                            class="form-control bg-lingkaran" readonly style="border-radius: 10px;"></div>
                </div>

                <div class="row mt-2">
                    {{-- <div class="col-md-12">
                        <input type="text" autocomplete="off" class="form-control d-inline" onchange="getMenu()"
                            placeholder="Cari Menu" name="q" id="search-input" style="border-radius: 10px;">
                    </div> --}}
                    <div class="col-md-6">
                        <select class="form-select" style="border-radius: 10px;" aria-label="Default select example"
                            name="kantin" onchange="getMenu()" required id="kantin">
                            <option value="">Semua Kantin</option>
                            @foreach ($kantin as $item)
                                <option value="{{ $item->id_kantin }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="btn-check-makanan" name="darkmode"
                                value="something" onchange="getMenu()">
                            <label class="form-check-label" for="tn-check-makanan">Makanan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="btn-check-minuman" name="darkmode"
                                value="something" onchange="getMenu()">
                            <label class="form-check-label" for="tn-check-minuman">Minuman</label>
                        </div>
                    </div>
                    {{-- <div class="col-md-2">
                        <input class="btn-check" type="checkbox" style="border-radius: 10px;" id="btn-check-makanan"
                            autocomplete="off" onchange="getMenu()">
                        <label class="btn btn-outline-primary ml-7" style="border-radius: 10px;"
                            for="btn-check-makanan">Makanan</label><br>
                    </div> --}}
                    {{-- <div class="col-md-2">
                        <input class="btn-check" type="checkbox" style="border-radius: 10px;" id="btn-check-minuman"
                            autocomplete="off" onchange="getMenu()">
                        <label class="btn btn-outline-primary" style="border-radius: 10px;"
                            for="btn-check-minuman">Minuman</label><br>
                    </div> --}}


                </div>
                <div class="row mt-2 m-0" id="data-menu"
                    style="background: rgba(255, 255, 255, 0.5); border-radius : 10px;">

                </div>
            </div>
            <div class="col-md-4 mt-2 pb-2 pt-2" style="background: white; border-radius:10px;">
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="d-flex justify-content-between">
                            <h5 class="text-left fw-bold d-inline m-0">ORDER <span hidden id="orderid"></span></h5>
                            <p class="m-0">{{ date('Y-m-d') }}</p>

                            {{-- <p class="m-0">{{ date('Y-m-d H:i:s') }}</p> --}}
                            {{-- <p class="m-0">{{ CURRENT_DATE('Y-m-d H:i:s') }}</p> --}}

                            {{-- <hr style="height: 2px"> --}}
                        </div>
                        <hr style="height: 2px">
                        <div id="cart">
                            {{-- <div class="cart-menu row align-items-center mt-3">
                                <div class="col-md-4">
                                    <p class="m-0 text-dark">Nasi Goreng</p>
                                    <p class="m-0 text-secondary">Rp 12.000</p>
                                </div>
                                <div class="col-5">
                                    <div class="d-flex align-items-center justify-content-end gap-3">
                                        <p class="m-0">x1</p>
                                        <input type="number" class="form-control border-0 bg-white" placeholder="0%"
                                            required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                    <button type="button" class="btn btn-light" style="border: 20px;">-</button>
                                        <button type="button" class="btn btn-light" style="border: 20px;">+</button>

                                        <button type="button" class="btn btn-danger" id="btn_hapus" style="border: 20px;">
                                            <i class="fa-solid fa-trash-can text-white"></i>
                                        </button>
                                    </div>
                                </div>
                                <hr style="height: 2px">
                            </div> --}}

                        </div>
                        <input type="hidden" name="id_penjualan" id="id_penjualan">
                        <div class="input-group mb-3 mt-3 no_meja">
                            <span class="input-group-text fw-bold" id="no_meja">No Meja</span>
                            <input type="number" class="form-control" placeholder="10" aria-label="Username"
                                aria-describedby="basic-addon1" name="no_meja" required min="0">
                        </div>
                        <div class="mb-3">
                            <div class="metode-pembayaran mt-0">
                                <select class="form-select" aria-label="Default select example" name="model_pembayaran"
                                    required>

                                    <option selected value="cash">Cash</option>
                                    <option value="polijepay">PolijePay</option>
                                    <option value="gopay">Gopay</option>
                                    <option value="qris">Qris</option>
                                    <option value="transfer bank">Transfer Bank</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mt-0">
                                <p class="fw-bold">Nama Customer</p>
                                <p class="fw-bold" id="nama_tampil"></p>
                            </div>
                            <div class="d-flex justify-content-between mt-0">
                                <label for="subtotal" class="fw-bold">Subtotal</label>

                                <input type="text" name="subtotal" id="subtotal"
                                    class="form-control input-bayar bg-white text-black" readonly value="0">
                            </div>
                            <div class="d-flex justify-content-between mt-0">
                                <label for="diskon" class="fw-bold">Diskon</label>
                                <input type="text" name="diskon" id="diskon" onchange="allDiscount(this)"
                                    class="form-control input-bayar bg-white text-black" min="1" max="100"
                                    placeholder="0 %" required>
                            </div>
                            {{-- oninput="hitungTotal()" --}}
                            <div class="d-flex justify-content-between mt-0">
                                <label for="total" class="fw-bold">Total </label>

                                <input type="text" name="total" id="total"
                                    class="form-control input-bayar bg-white text-black" readonly
                                    value="{{ '0' }}" required>
                            </div>
                            <div class="d-flex
                                    justify-content-between mt-0">
                                <label for="bayar" class="fw-bold">Bayar</label>

                                <input type="text" name="bayar" id="bayar" oninput="hitungPembayaran(this)"
                                    class="form-control input-bayar" min="1" placeholder="Rp.0" required>
                            </div>
                            <div class="d-flex justify-content-between mt-0">
                                <label for="kembali" class="fw-bold">Kembali</label>
                                {{-- <span class="fw-bold">Rp. </span> --}}
                                <input type="text" name="kembali" id="kembali"
                                    class="form-control input-bayar text-black bg-white" readonly placeholder="Rp.0">
                            </div>

                            <button type="submit" class="btn btn-simpan form-control text-white fw-bold" id="btn_save"
                                onclick="simpanAll()">Simpan</button>
                            <a href="javascript:void(0);" id="linkhapussemua"
                                class="btn btn-clearall form-control mt-2  relative text-white fw-bold" id="btn_clearAll"
                                onclick="location.reload()">Hapus Semua</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // In your Javascript (external .js resource or <script> tag)
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>
    @endsection

    @push('script')
        <script>
            let idCus = 1;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            })

            document.addEventListener('DOMContentLoaded', function() {
                var checkboxMakanan = document.getElementById('btn-check-makanan');
                var checkboxMinuman = document.getElementById('btn-check-minuman');

                checkboxMakanan.addEventListener('change', function() {
                    var valueMakanan = checkboxMakanan.checked ? 'Makanan' : '';
                    getMenu();
                    // console.log('Value Makanan:', valueMakanan);
                });

                checkboxMinuman.addEventListener('change', function() {
                    var valueMinuman = checkboxMinuman.checked ? 'Minuman' : '';
                    getMenu();
                    // console.log('Value Minuman:', valueMinuman);
                });
            });

            function reloadmenu() {
                var totalAwal = 0;
                $.ajax({
                    url: "/productAll",
                    type: "GET",
                    method: "GET",
                    data: {},
                    success: function(response) {
                        totalAwal = response;
                        // console.log(response);
                    }
                })

                setInterval(() => {

                    $.ajax({
                        url: "/productAll",
                        type: "GET",
                        method: "GET",
                        data: {},
                        success: function(response) {
                            if (totalAwal != response) {
                                totalAwal = response;
                                getMenu();
                            }
                            console.log(response);
                        }
                    })

                }, 3000);
            }

            reloadmenu();



            function savePenjualan() {
                let customer_id = $('#inputid').val();
                let cashier = '1';
                $.ajax({
                    url: "{{ route('penjualan.save') }}",
                    type: "POST",
                    data: {
                        id_customer: customer_id,
                        id_kasir: cashier,
                    },
                    success: function(response) {
                        $('#orderid').text(response.orderid);
                        $('#id_penjualan').val(response.orderid);
                        const linkhapussemua = document.getElementById('linkhapussemua');
                        linkhapussemua.href = '/kasir/hapussemua/' + response.orderid
                        $('#submitPenjualan').attr('disabled', true);
                        alert('Berhasil! Silahkan memilih makanan')
                    }
                })
            }

            function addCart(id) {
                let id_menu = id;
                console.log(id_menu);
                $.ajax({
                    url: "{{ route('penjualan.save') }}",
                    type: "POST",
                    method: "POST",
                    data: {
                        id_menu: id_menu,
                        id_kantin: $('#id_kantin').val(),
                        id_customer: $('#inputid').val(),
                        id_kasir: '{{ Auth::user()->id }}',
                    },
                    success: function(response) {
                        showCart(response.orderid)
                    }
                })
            }

            function showCart(element) {

                // console.log(element);
                let id = $(element).data('id');
                console.log(id);
                let cart = $('.cart-menu');
                let isThere = false;
                for (let i = 0; i < cart.length; i++) {
                    if (id == $(cart[i]).data('id')) {
                        isThere = true;
                    }
                }

                if (!isThere) {
                    let nama = $(element).data('nama')
                    let harga = $(element).data('harga')
                    let html = `<div class="cart-menu row align-items-center mt-2" data-id="${id}">
                                <div class="col-md-4">
                                    <p class="m-0 text-dark">${nama}</p>
                                    <p class="m-0 text-secondary subtotal-item">${harga}</p>
                                    <p class="d-none item-price">${harga}</p>
                                </div>
                                <div class="col-5 mb-2">
                                        <p class="m-0">x<span class="qty">1</span></p>
                                </div>
                                <div class="col-3">
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <button type="button" data-id="${id}" class="btn btn-light btn-kurang-qty" onclick="reduceQty(this)" style="border: 20px;">-</button>
                                        <button type="button" data-id="${id}" class="btn btn-light btn-tambah-qty" onclick="addQty(this)" style="border: 20px;">+</button>
                                        <button type="button" data-id="${id}" class="btn btn-danger btn-hapus-cart" onclick="deleteCartItem(this)" id="btn_hapus" style="border: 20px;">
                                            <i class="fa-solid fa-trash-can text-white"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-15 mt-1 mb-2">
                                    <p class="m-0 text-dark">Catatan Menu</p>
                                    <textarea name="keterangan" id="keterangan" style="width: 100%; resize: none;" cols="18" rows="1"></textarea>
                                </div>
                                <hr style="height: 2px">
                            </div>`

                    $('#cart').append(html)
                    total()
                } else {
                    let qty = $(`.cart-menu[data-id="${id}"]`).find(`span.qty`).html()
                    $(`.cart-menu[data-id="${id}"]`).find(`span.qty`).html(parseInt(qty) + 1)
                    subtotalPerItem(element, parseInt(qty) + 1)
                    discountPerItem(element)
                    total()
                }
            }

            function addQty(element) {
                let id = $(element).data('id');
                let qty = $(`.cart-menu[data-id="${id}"]`).find(`span.qty`).html()
                $(`.cart-menu[data-id="${id}"]`).find(`span.qty`).html(parseInt(qty) + 1)
                subtotalPerItem(element, parseInt(qty) + 1)
                discountPerItem(element)
                total()
            }

            function reduceQty(element) {
                let id = $(element).data('id');
                let qty = $(`.cart-menu[data-id="${id}"]`).find(`span.qty`).html()

                if (parseInt(qty) - 1 <= 0) {
                    deleteCartItem(element);
                } else {
                    $(`.cart-menu[data-id="${id}"]`).find(`span.qty`).html(parseInt(qty) - 1)
                    subtotalPerItem(element, parseInt(qty) - 1)
                    discountPerItem(element)
                    total()
                }
            }

            function deleteCartItem(element) {
                let id = $(element).data('id');
                $(`.cart-menu[data-id="${id}"]`).remove();
                total()
            }

            function subtotalPerItem(element, quantity) {
                let id = $(element).data('id');
                let harga = $(`.cart-menu[data-id="${id}"]`).find(`.item-price`).html()
                $(`.cart-menu[data-id="${id}"]`).find(`.subtotal-item`).html(parseInt(harga) * parseInt(quantity))
            }

            function discountPerItem(element) {

                let id = $(element).data('id'); // Perbaikan: Ambil data-id dari elemen element
                let discount = $(`.cart-menu[data-id="${id}"]`).find('input').val();

                if (discount == null || isNaN(discount) || !discount) {
                    discount = 0;
                }

                let qty = $(`.cart-menu[data-id="${id}"]`).find(`span.qty`).html();
                let harga = $(`.cart-menu[data-id="${id}"]`).find(`.item-price`).html();
                let subtotal = parseInt(harga) * parseInt(qty);

                let totalDiscount = Math.ceil((parseInt(discount) / 100) * parseInt(subtotal));

                $(`.cart-menu[data-id="${id}"]`).find(`.subtotal-item`).html(parseInt(subtotal) - parseInt(totalDiscount));
                total();

                var inputValue = element.value;

                // Tambahkan '%' di belakang nilai jika belum ada
                if (!inputValue.includes('%')) {
                    inputValue += '%'; // Perbaikan: Menggunakan operator += untuk menambahkan '%'
                }

                console.log(inputValue + "%");

                // Setel nilai input yang telah dimodifikasi
                element.value = inputValue;
            }



            function total() {
                let cart = $('.cart-menu');
                let total = 0;
                for (let i = 0; i < cart.length; i++) {
                    total += parseInt($(cart[i]).find('.subtotal-item').html())
                }

                $('input#subtotal').attr("data-value", total)
                $('input#subtotal').val(formatRupiah(total))
            }

            function allDiscount(element) {
                let discount = $(element).val();
                let subtotal = $('input#subtotal').attr('data-value')

                let totalDiscount = Math.ceil((discount / 100) * subtotal);
                $('input#total').val(formatRupiah(subtotal - totalDiscount));
                $('input#total').attr('data-value', (subtotal - totalDiscount));
            }

            function hitungPembayaran(element) {
                var value = element.value;
                var digitOnly = value.replace(/\D/g, '');
                $(element).attr('data-value', digitOnly);

                element.value = digitOnly.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');

                let discount = $('#diskon').val();
                if (discount == null || discount == NaN || !discount) {
                    bayar = digitOnly;
                    subtotal = $('input#subtotal').attr('data-value');
                    kembalian = bayar - subtotal;
                    $('#total').val(formatRupiah(subtotal));
                    $('#total').attr('data-value', subtotal);
                    $('#kembali').attr('data-value', kembalian);
                    $('#kembali').val(formatRupiah(kembalian));

                } else {
                    bayar = digitOnly;
                    total = $('#total').attr('data-value');

                    kembalian = bayar - total;
                    $('#kembali').attr('data-value', kembalian);
                    $('#kembali').val(formatRupiah(kembalian));



                }
            }

            function getMenu() {

                // searching = $('#search-input').val();
                searching = $('#kantin').val();
                makanan = $('#btn-check-makanan').is(':checked') ? 'Makanan' : '';
                minuman = $('#btn-check-minuman').is(':checked') ? 'Minuman' : '';
                $.ajax({
                    url: '/searchProductAll?kantin=' + searching + '&makanan=' + makanan + '&minuman=' + minuman,
                    // url: '/searchProductAll?q=' + searching,
                    method: 'GET',
                    success: function(response) {
                        html = ''
                        response.data.forEach((item) => {
                            html += `<div class="col-md-3 mt-2 pb-2">
                                        <div id="menu_luar" class="bungkus-menu bg-second bg-white" style="cursor: pointer; border-radius: 10px;" data-nama="${item.nama}" data-harga="${item.harga}" data-id="${item.id_menu}" onclick="showCart(this)">
                                                <img src="public/${item.foto}" alt="" class="justify-content-center align-items-center mx-auto d-block p-2 img-fluid" style="object-fit: cover; width: 100%; height: 100px;">
                                                <p class="m-0 text-center text-primary fw-bold" id="harga_menu">Rp ${item.harga}</p>
                                                <p class="m-0 text-center" id="nama_menu" onclick="namamakanan(this.value)"> ${item.nama}</p>
                                                <p class="text-primary fw-bold m-0 text-center" id="id_kantin"><small> <i>Kantin ${item.id_kantin} </i></small></p>
                                        </div>
                                    </div>`;
                        });

                        $('#data-menu').html(html);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
            getMenu();

            $(document).ready(function() {
                $('#id_customer').on('change', function() {
                    const value = $(this).val();

                    idCus = value
                    console.log(idCus);

                    $.ajax({
                        url: '/api/customer/get-by-id-customer?id_customer=' + value,
                        method: 'GET',
                        success: function(res) {

                            const customer = res.data;
                            $('#inputid').val(customer.id);
                            $('#inputnama').val(
                                customer.nama);
                            $('#inputalamat').val(customer.alamat);
                            $('#inputtelepon').val(customer.no_telepon);
                            $('#nama_tampil').html(customer.nama);

                        }
                    })
                });


            });



            function simpanAll() {
                var inputNoMeja = document.querySelector('input[name=no_meja]');
                if (!inputNoMeja.value) {
                    inputNoMeja.setCustomValidity('Isi No Meja');
                    inputNoMeja.reportValidity();
                } else {
                    inputNoMeja.setCustomValidity('');
                }

                console.log(idCus + "aaa");

                if (idCus == "1") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Informasi',
                        text: 'ID Customer tidak boleh kosong !!...',
                        showConfirmButton: false,
                        timer: 2200,
                    }).then(function() {});
                }

                let details = [];

                let cart = $('.cart-menu');
                for (let i = 0; i < cart.length; i++) {
                    details.push({
                        id_menu: $(cart[i]).data('id'),
                        jumlah: parseInt($(cart[i]).find(`span.qty`).html()),
                        harga: parseInt($(cart[i]).find(`.item-price`).html()),
                        diskon: $(cart[i]).find(`input`).val(),
                        catatan: $(cart[i]).find('textarea#keterangan').val()
                    });
                }

                // console.log(anu);
                console.log($('#total').attr('data-value'));
                console.log(details);

                console.log($('#inputid').val() +
                    " aasdd");

                if (details.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Informasi',
                        text: 'Ti dak ada data',
                        showConfirmButton: false,
                        timer: 2200,
                    }).then(function() {});
                } else if (parseInt($('#bayar').attr('data-value')) < parseInt($('#total').attr('data-value'))) {
                    var bayar = $('#bayar').attr('data-value');
                    console.log('total > ');
                    console.log($('#total').attr('data-value'));
                    console.log(bayar);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Informasi',
                        text: 'Nominal yang anda masukan kurang',
                        showConfirmButton: false,
                        timer: 2200,
                    }).then(function() {});
                } else if (parseInt($('#subtotal').attr('data-value')) == parseInt($('#total').attr('data-value'))) {




                    const data = {
                        id_customer: idCus,
                        id_kasir: '{{ Auth::user()->id }}',
                        subtotal: $('#subtotal').attr('data-value'),
                        diskon: $('#diskon').val(),
                        total: $('#total').attr('data-value'),
                        bayar: $('#bayar').attr('data-value'),
                        kembalian: $('#kembali').attr('data-value'),
                        model_pembayaran: $('select[name="model_pembayaran"] option:selected').val(),
                        no_meja: $('input[name="no_meja"]').val(),
                        details: details
                    };

                    // console.log(data);
                    // alert(data);

                    $.ajax({
                        url: "/api/kon/save",
                        type: "POST",
                        method: "POST",
                        data: {
                            id_customer: idCus,
                            id_kasir: '{{ Auth::user()->id }}',
                            subtotal: $('#subtotal').attr('data-value'),
                            diskon: $('#diskon').val(),
                            total: $('#total').attr('data-value'),
                            bayar: $('#bayar').attr('data-value'),
                            kembalian: $('#kembali').attr('data-value'),
                            model_pembayaran: $('select[name="model_pembayaran"] option:selected').val(),
                            no_meja: $('input[name="no_meja"]').val(),
                            details: details
                        },

                        success: function(response) {
                            console.log(response);
                            if (response.status == true) {
                                Swal.fire({
                                        icon: 'success',
                                        title: 'Transaksi Berhasil',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1200,
                                    })
                                    .then(function() {

                                        window.open("{{ url('/') }}/kasir/" + response.data.id, "_blank");
                                        location.reload();
                                    });
                            }
                        }

                    });
                } else if (parseInt($('#subtotal').attr('data-value')) > parseInt($('#total').attr('data-value'))) {

                    const data = {
                        id_customer: idCus,
                        id_kasir: '{{ Auth::user()->id }}',
                        subtotal: $('#subtotal').attr('data-value'),
                        diskon: $('#diskon').val(),
                        total: $('#total').attr('data-value'),
                        bayar: $('#bayar').attr('data-value'),
                        kembalian: $('#kembali').attr('data-value'),
                        model_pembayaran: $('select[name="model_pembayaran"] option:selected').val(),
                        no_meja: $('input[name="no_meja"]').val(),
                        details: details
                    };



                    $.ajax({
                        url: "api/kon/save",
                        type: "POST",
                        method: "POST",
                        data: data,
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire({
                                        icon: 'success',
                                        title: 'Transaksi Berhasil',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1200,
                                    })
                                    .then(function() {

                                        window.open("{{ url('/') }}/kasir/" + response.data.id, "_blank");
                                        location.reload();
                                    });
                            }
                        }

                    });

                }
            }







            function formatRupiah(angka) {
                var rupiah = '';
                var angkarev = angka.toString().split('').reverse().join('');
                for (var i = 0; i < angkarev.length; i++) {
                    if (i % 3 == 0) {
                        rupiah += angkarev.substr(i, 3) + '.';
                    }
                }
                return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
            }




            function getOriginalNumber(value) {
                let input = value;

                let number = input.replace(/[^\d.,]/g, '');

                number = number.replace(/\./g, '');

                number = number.replace(/,/g, '.');

                let originalNumber = parseFloat(number);

                return originalNumber;
            }
        </script>
    @endpush
