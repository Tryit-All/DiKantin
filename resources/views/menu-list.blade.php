<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menu || Dikantin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Custom styles */
        .card-img-top {
            max-height: 200px;
            object-fit: cover;
        }

        .card-text {
            color: #555;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container mt-5">

        <div class="text-center">
            <img src="{{ asset('img/logo-baru1.png') }}" style="height: 100px;" alt="logo">
            <h3 class="mb-4">Menu Dikantin</h1>
        </div>
        <div class="row mb-4">
            <div class="col">
                <input type="text" class="form-control" placeholder="Cari Menu" aria-label="Cari Menu"
                    id="searchInput">
            </div>
            <div class="col">
                <select class="form-select" aria-label="Default select example" id="selectKantin">
                    <option selected>Semua Kantin</option>
                    @foreach ($kantins as $item)
                        <option value="{{ $item->id_kantin }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row" id="menuList">
            <!-- Card 1 -->
            @foreach ($menus as $item)
                <div class="col-md-4 mb-4">
                    <div class="card" style="height: 250px">
                        <img src="{{ url($item->foto) }}" alt="foto-menu"
                            class="justify-content-center align-items-center mx-auto d-block p-2 img-fluid"
                            style="object-fit: cover; width: 100%; height: 100px;">

                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama }}</h5>
                            <p class="card-text">{{ $item->kantin->nama ?? 'kantin' }}</p>
                            <p class="card-text">Rp.{{ number_format($item->harga) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script>
        // Ambil elemen-elemen HTML
        const searchInput = document.getElementById('searchInput');
        const selectKantin = document.getElementById('selectKantin');
        const menuList = document.getElementById('menuList');

        // Tambahkan event listener untuk setiap perubahan pada input pencarian atau pilihan kantin
        searchInput.addEventListener('input', updateMenuList);
        selectKantin.addEventListener('change', updateMenuList);

        // Fungsi untuk memfilter daftar menu berdasarkan pencarian dan pilihan kantin
        // Fungsi untuk memfilter daftar menu berdasarkan pencarian dan pilihan kantin
        function updateMenuList() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedKantin = selectKantin.value;

            console.log("");


            // Saring menu berdasarkan nama, kantin, dan status stok
            const filteredMenus = @json($menus)
                .filter(function(menu) {
                    return (
                        (menu.nama.toLowerCase().includes(searchTerm) || searchTerm === '') &&
                        (selectedKantin === 'Semua Kantin' || (menu.kantin && menu.kantin.id_kantin.toString() ===
                            selectedKantin)) &&
                        menu.status_stok === 'ada'
                    );
                });


            // Perbarui tampilan menu
            updateMenuView(filteredMenus);
        }


        // Fungsi untuk memperbarui tampilan menu
        function updateMenuView(menus) {
            menuList.innerHTML = '';
            menus.forEach(menu => {
                const cardHtml = `
                    <div class="col-md-4 mb-4">
                        <div class="card" style="height: 250px">
                            <img src="{{ url('/') }}/${menu.foto}" alt="foto-menu"
                                class="justify-content-center align-items-center mx-auto d-block p-2 img-fluid"
                                style="object-fit: cover; width: 100%; height: 100px;">

                            <div class="card-body">
                                <h5 class="card-title">${menu.nama}</h5>
                                <p class="card-text">${menu.kantin.nama || 'kantin'}</p>
                                <p class="card-text">Rp.${numberFormat(menu.harga)}</p>
                            </div>
                        </div>
                    </div>
                `;

                menuList.insertAdjacentHTML('beforeend', cardHtml);
            });
        }

        // Fungsi untuk format angka ke dalam format ribuan
        function numberFormat(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }
    </script>

</body>

</html>
